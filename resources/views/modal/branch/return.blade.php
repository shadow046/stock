<div id="returnModal" class="modal fade" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Return details</h4>
                <button class="close cancel" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mod">
                
                <form id="requestForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="myid">
                    <input type="hidden" id="branch_id">
                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                        <div class="col-md-6">
                            <input id="date" type="text" class="form-control" name="date" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Item Description') }}</label>
                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control" name="description" disabled>
                        </div>
                    </div>

                    <div class="form-group row" id="serials">
                        <label for="serial" class="col-md-4 col-form-label text-md-right">{{ __('Serial') }}</label>
                        <div class="col-md-6">
                            <input id="serial" type="text" class="form-control" name="serial" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                        <div class="col-md-6">
                            <input id="status" type="text" class="form-control" name="status" disabled>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" id="submit_Btn" value="Return">
                </div>
            </div>  
        </div>
    </div>
</div>