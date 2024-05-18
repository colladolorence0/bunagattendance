<!-- Add Deduction Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Deduction</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="deduction_add.php">
                    <!-- New Fields -->
                    <div class="form-group">
                        <label for="sss_contribution" class="col-sm-3 control-label">SSS Contribution</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sss_contribution" name="sss_contribution">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="philhealth_contribution" class="col-sm-3 control-label">PhilHealth Contribution</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="philhealth_contribution" name="philhealth_contribution">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="withholding_tax" class="col-sm-3 control-label">Withholding Tax</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="withholding_tax" name="withholding_tax">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Deduction Modal -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Update Deduction</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="deduction_edit.php">
                    <input type="hidden" class="decid" name="id">
                    <!-- New Fields -->
                    <div class="form-group">
                        <label for="edit_sss_contribution" class="col-sm-3 control-label">SSS Contribution</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_sss_contribution" name="sss_contribution">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_philhealth_contribution" class="col-sm-3 control-label">PhilHealth Contribution</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_philhealth_contribution" name="philhealth_contribution">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_withholding_tax" class="col-sm-3 control-label">Withholding Tax</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_withholding_tax" name="withholding_tax">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Delete Deduction</b></h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this deduction?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                <button type="button" id="confirmDelete" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.delete').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteConfirmation').modal('show');

            $('#confirmDelete').click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'deduction_delete.php',
                    data: {id: id},
                    success: function(response){
                        // Handle success response here
                        location.reload(); // Reload the page after successful deletion
                    },
                    error: function(xhr, status, error){
                        // Handle error here
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    });
</script>


