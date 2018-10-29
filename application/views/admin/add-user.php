<div class="row">
    <div class="col-md-12">
        <div class="card  border-top-0 rounded-0">
            <div class="card-body">
                <div class="text-right">
                    <a href="#" class="btn btn-secondary btn-sm mb-4" data-toggle="modal" data-target="#addModal"><i class="ti-plus"></i> Add User</a>
                </div>
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <tr>
                            <th style="width: 20%">#</th>
                            <th style="width: 50%">Name</th>
                            <th style="width: 30%">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Doe, John</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Doe, Jane</td>
                            <td>University President</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Dela Cruz, Juan</td>
                            <td>Researcher</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="addModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="ti-plus"></i> Add User</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6> User Information</h6>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3"> First Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="fname">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3"> Middle Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="mname">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3"> Last Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="lname">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3"> Email:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3"> Position:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="position">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6> User Login Information </h6>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3"> Username:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3"> Password:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3"> Confirm Password:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="confirmpass">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="ti-close"></i> Close</a>
                <a href="#" class="btn btn-success btn-sm"><i class="ti-save"></i> Save</a>
            </div>
        </div>
    </div>   
</div>
<script src="<?= base_url()?>assets/modules/js/research.js"></script>