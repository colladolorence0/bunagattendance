<!-- Add Other Earnings Modal -->
<div class="modal fade" id="addOtherEarnings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add Other Earnings</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="earnings_add.php">
                    <div class="form-group">
                        <label for="employee" class="col-sm-3 control-label">Employee ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="employee" name="employee" required>
                        </div>
                    </div>
                    <!-- Bonus -->
                    <div class="form-group">
                        <label for="bonus" class="col-sm-3 control-label">Bonus</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="bonus" name="bonus" required>
                        </div>
                    </div>
                    <!-- Transportation Allowance -->
                    <div class="form-group">
                        <label for="transportation" class="col-sm-3 control-label">Transportation Allowance</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="transportation" name="transportation" required>
                        </div>
                    </div>
                    <!-- Overtime -->
                    <div class="form-group">
                        <label for="overtime" class="col-sm-3 control-label">Overtime</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="overtime" name="overtime" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-flat" name="add">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Other Earnings Modal -->
<div class="modal fade" id="editOtherEarnings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Edit Other Earnings</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="earnings_edit.php">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_bonus" class="col-sm-3 control-label">Bonus</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_bonus" name="bonus" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_transportation" class="col-sm-3 control-label">Transportation Allowance</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_transportation" name="transportation" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_overtime" class="col-sm-3 control-label">Overtime</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_overtime" name="overtime" required>
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
<div class="modal fade" id="deleteConfirmation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-flat" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
