
<script type="text/javascript">
    var y = 1;
    var interval = null;
    $(document).ready(function()
    {
        var d = new Date();
        var hour = String(d.getHours()).padStart(2, '0') % 12 || 12
        var ampm = (String(d.getHours()).padStart(2, '0') < 12 || String(d.getHours()).padStart(2, '0') === 24) ? "AM" : "PM";
        var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        //$('#requestModal').modal('show');
        $('#date').val(months[d.getMonth()]+' '+d.getDate()+', ' +d.getFullYear()+' '+hour+':'+String(d.getMinutes()).padStart(2, '0')+ampm);
        $('#sdate').val(months[d.getMonth()]+' '+d.getDate()+', ' +d.getFullYear()+' '+hour+':'+String(d.getMinutes()).padStart(2, '0')+ampm);

        var table =
        $('table.requestTable').DataTable({ //user datatables
            "dom": 'lrtip',
            "language": {
                    "emptyTable": " "
                },
            processing: true,
            serverSide: true,
            ajax: 'requests',
            columns: [
                { data: 'created_at', name:'date', "width": "14%" },
                { data: 'request_no', name:'request_no', "width": "14%"},
                { data: 'reqBy', name:'reqBy', "width": "14%"},
                { data: 'status', name:'status', "width": "14%"}
            ]
        });

        interval = setInterval(function(){
            table.draw();
        }, 30000);

        $('#requestTable tbody').on('click', 'tr', function () { //show branch details in modal
            clearInterval(interval);
            var trdata = table.row(this).data();
            var dtdata = $('#requestTable tbody tr:eq(0)').data();
            //$('#requestModal').modal('show');
            
            $('#date').val(trdata.created_at);
            $('#reqno').val(trdata.request_no);
            $('#branch').val(trdata.branch);
            $('#name').val(trdata.reqBy);
            $('#area').val(trdata.area);
            $('table.requestDetails').dataTable().fnDestroy();
            $('table.schedDetails').dataTable().fnDestroy();

            if (trdata.status == 'PENDING') {
                $('table.schedDetails').hide();
                $('table.requestDetails').show();
                $('.sched').hide();
                $('#del_Btn').show();
                $('#rec_Btn').hide();
                $('#del_Btn').attr('reqno', trdata.request_no);
                $('table.requestDetails').DataTable({ //user datatables
                    "dom": 'lrtip',
                    "language": {
                        "emptyTable": " "
                    },
                    processing: true,
                    serverSide: true,
                    ajax: "/requests/"+trdata.request_no,
                    columns: [
                        { data: 'items_id', name:'items_id'},
                        { data: 'item_name', name:'item_name'},
                        { data: 'quantity', name:'quantity'},
                        { data: 'purpose', name:'purpose'}
                    ]
                });
            }else if(trdata.status == 'SCHEDULED'){
                $('table.requestDetails').hide();
                $('.sched').show();
                $('table.schedDetails').show();
                $('#sched').val(trdata.sched);
                $('#del_Btn').hide();
                $('#rec_Btn').show();
                $('table.schedDetails').DataTable({ //user datatables
                    "dom": 'lrtip',
                    "language": {
                        "emptyTable": " "
                    },
                    processing: true,
                    serverSide: true,
                    ajax: "/send/"+trdata.request_no,
                    columns: [
                        { data: 'items_id', name:'items_id'},
                        { data: 'item_name', name:'item_name'},
                        { data: 'serial', name:'serial'}
                    ]
                });
            }
            $('#requestModal').modal('show');
        });
    });

    $(document).on('click', '#del_Btn', function(){
        var reqno = $(this).attr('reqno');
        $.ajax({
            url: 'remove',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: 'DELETE',
            data: {
                reqno : reqno                     
            },
            success: function(){
                alert("Pending Request Deleted!!!");
                window.location.href = 'request';
            }
        });
    });

    $(document).on('click', '#rec_Btn', function(){
        var reqno = $('#reqno').val();
        var status = "2";
        var stat = "ok";
        var datesched = $('#sched').val();
        console.log(datesched);
        $.ajax({
            url: 'update',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: 'PUT',
            data: {
                reqno : reqno,
                status: status,
                datesched: datesched,
                stat: stat                    
            },
            success: function(){
                
            },
            error: function (data,error, errorThrown) {
                alert(data.responseText);
            }
        });

        $.ajax({
            url: 'storerreceived',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: 'POST',
            data: {
                reqno : reqno     
            },
            success: function(){
                alert("Stock added to inventory!!!");
                window.location.href = 'request';
            },
            error: function (data,error, errorThrown) {
                alert(data.responseText);
            }
        });
    });

    $(document).on('click', '#reqBtn', function(){
        clearInterval(interval);
        $.ajax({
            type:'get',
            url:'gen',
            async: false,
            success:function(result)
            {
                $('#sreqno').val(result);
            },
        });
        $('#sendrequestModal').modal({backdrop: 'static', keyboard: false});

    });

    $(document).on('click', '.add_item', function(){

        //$('.add_item').on('click', function(){ //show user/branch modal
            var rowcount = $(this).attr('btn_id');
            if ($(this).val() == 'Add Item') {
                if($('#qty'+rowcount).val() != 0 && $('#purpose'+rowcount).val()){
                    y++;
                    var additem = '<div class="row no-margin" id="row'+y+'"><div class="col-md-2 form-group"><select id="category'+y+'" style="color: black;" class="form-control category" row_count="'+y+'"></select></div><div class="col-md-2 form-group"><select id="item'+y+'" style="color: black;" class="form-control item" row_count="'+y+'"><option selected disabled>select item code</option></select></div><div class="col-md-3 form-group"><select id="desc'+y+'" class="form-control desc" style="color: black;" row_count="'+y+'"><option selected disabled>select description</option></select></div><div class="col-md-2 form-group"><select id="purpose'+y+'" class="form-control purpose" style="color: black;" row_count="'+y+'"><option selected disabled>select purpose</option><option value="1">Service Unit</option><option value="2">Replacement</option><option value="3">Stock</option></select></div><div class="col-md-2 form-group"><input type="number" min="0" class="form-control" style="color: black; width: 6em" name="qty'+y+'" id="qty'+y+'" placeholder="0" disabled></div><div class="col-md-1 form-group"><input type="button" class="add_item btn btn-xs btn-primary" btn_id="'+y+'" value="Add Item"></div></div>'
                    $(this).val('Remove');
                    $('#category'+ rowcount).prop('disabled', true);
                    $('#item'+ rowcount).prop('disabled', true);
                    $('#desc'+ rowcount).prop('disabled', true);
                    $('#qty'+ rowcount).prop('disabled', true);
                    $('#purpose'+ rowcount).prop('disabled', true);
                    $('#reqfield').append(additem);
                    $('#category'+ rowcount).find('option').clone().appendTo('#category'+y);
                }else{
                    alert("Invalid Quantity value!!!");
                }
            }else{
                $('#category'+rowcount).val('select category');
                $('#item'+rowcount).val('select item code');
                $('#desc'+rowcount).val('select description');
                $('#serial'+rowcount).val('select serial');
                $('#purpose'+rowcount).val('select purpose');
                $('#category'+rowcount).prop('disabled', false);
                $('#item'+rowcount).prop('disabled', false);
                $('#desc'+rowcount).prop('disabled', false);
                $('#serial'+rowcount).prop('disabled', false);
                $('#purpose'+ rowcount).prop('disabled', false);
                $('#row'+rowcount).hide();
                $(this).val('Add Item');
            }
            
        //});

    });

    $(document).on('click', '.send_sub_Btn', function(e){
            e.preventDefault();
            var cat = "";
            var item = "";
            var desc = "";
            var qty = "";
            var stat = "notok";
            var reqno = $('#sreqno').val();
            for(var q=1;q<=y;q++){
                if ($('#row'+q).is(":visible")) {
                    if ($('.add_item[btn_id=\''+q+'\']').val() == 'Remove') {
                        cat = $('#category'+q).val();
                        item = $('#item'+q).val();
                        desc = $('#desc'+q).val();
                        qty = $('#qty'+q).val();
                        purpose = $('#purpose'+q).val();
                        $.ajax({
                            url: 'storerequest',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                reqno : reqno,
                                item: item,
                                purpose: purpose,
                                qty: qty,
                                stat: stat                           
                            },
                        });
                    }
                }
                if (q == y) {
                    stat = "ok";
                    $.ajax({
                        url: 'storerequest',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            reqno : reqno,  
                            stat: stat                     
                        },
                    });
                    alert("Request details submitted!!!");
                    window.location.href = 'request';
                }
            }
    });

    $(document).on('change', '.desc', function(){
        var count = $(this).attr('row_count');
        var id = $(this).val();
        $('#item' + count).val(id);
        $('#qty'+count).prop('disabled', false);
    });

    $(document).on('change', '.item', function(){
        var count = $(this).attr('row_count');
        var id = $(this).val();
        $('#desc' + count).val(id);
        $('#qty'+count).prop('disabled', false);
    });

    $(document).on('change', '.category', function(){
        var codeOp = " ";
        var descOp = " ";
        var count = $(this).attr('row_count');
        var id = $(this).val();
        $('#stock' + count).val('Stock');
        selectItem(item1);
        $('#item' + count).val('select itemcode');
        $('#desc' + count).val('select description');
        $('#item' + count).css("border", "");
        function selectItem(item1) {
            $.ajax({
                type:'get',
                url:'itemcode',
                data:{'id':id},
                success:function(data)
                {
                    codeOp+='<option selected value="select" disabled>select item code</option>';
                    descOp+='<option selected value="select" disabled>select description</option>';
                    for(var i=0;i<data.length;i++){
                        codeOp+='<option value="'+data[i].id+'">'+data[i].id+'</option>';
                        descOp+='<option value="'+data[i].id+'">'+data[i].item.toUpperCase()+'</option>';
                    }
                    $("#item" + count).find('option').remove().end().append(codeOp);
                    $("#desc" + count).find('option').remove().end().append(descOp);
                },
            });
        }
    });

    $(document).on('click', '.cancel', function(){
        window.location.href = 'request';
    });
</script>
