<script type="text/javascript">
    var table;
    $(document).ready(function()
    {
        table =
        $('table.defectiveTable').DataTable({ //user datatables
            "dom": 'lrtip',
            "language": {
                "emptyTable": " "
            },
            processing: true,
            serverSide: true,
            ajax: 'return-table',
            
            columns: [
                { data: 'date', name:'date'},
                { data: 'branch', name:'branch'},
                { data: 'category', name:'category'},
                { data: 'item', name:'item'},
                { data: 'serial', name:'serial'},
                { data: 'status', name:'status'}
            ]
        });

        $('.tbsearch').delay().fadeOut('slow'); //hide search

        $('#search-ic').on("click", function () { //clear search box on hide
            for ( var i=0 ; i<=5 ; i++ ) {
                
                $('.fl-'+i).val('').change();
                table
                .columns(i).search( '' )
                .draw();
            }
            $('.tbsearch').toggle();
            
        });

        $('.filter-input').keyup(function() { //search columns
            table.column( $(this).data('column'))
                .search( $(this).val())
                .draw();
        });

    });

    $(document).on("click", "#defectiveTable tr", function () {
        var trdata = table.row(this).data();
        var id = trdata.id;
        var descop = " ";
        console.log(trdata);
        $('#branch_id').val(trdata.branchid);
        $('#date').val(trdata.date);
        $('#description').val(trdata.item);
        $('#status').val(trdata.status);
        $('#myid').val(trdata.id);
        $('#serial').val(trdata.serial);
        if (trdata.status == 'For receiving') {
            $('#submit_Btn').val('Received');
            $('#submit_Btn').show();
        }else if (trdata.status == 'For repair') {
            $('#submit_Btn').val('Repaired');
            $('#submit_Btn').show();
        }else if (trdata.status == 'pending') {
            $('#submit_Btn').val('pending');
            $('#submit_Btn').show();
        }else{
            $('#submit_Btn').hide();
        }

        $('#returnModal').modal({backdrop: 'static', keyboard: false});
    });

    $(document).on('click', '#submit_Btn', function(){
        var branch = $('#branch_id').val();
        var id = $('#myid').val();
        var status = $('#submit_Btn').val()
        if ($('#submit_Btn').val() == 'Received'){
            $.ajax({
                url: 'return-update',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                type: 'PUT',
                data: {
                    id: id,
                    branch: branch,
                    status: status
                },
                success:function(data)
                {
                    window.location.href = 'return';
                }
            });
        }
        if ($('#submit_Btn').val() == 'Repaired'){
            $.ajax({
                url: 'return-update',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                type: 'PUT',
                data: {
                    id: id,
                    branch: branch,
                    status: status
                },
                success:function(data)
                {
                    window.location.href = 'return';
                }
            });
        }
        if ($('#submit_Btn').val() == 'pending'){
            $.ajax({
                url: 'return-update',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                type: 'PUT',
                data: {
                    id: id,
                    branch: branch,
                    status: status
                },
                success:function(data)
                {
                    window.location.href = 'return';
                }
            });
        }
    });

    $(document).on('click', '.cancel', function(){
        window.location.href = 'return';
    });


</script>