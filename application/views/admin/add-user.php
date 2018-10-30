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
            <form id="addForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6> User Information</h6>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3"> First Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="fname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"> Middle Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"> Last Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="lname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"> Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"> Position:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="position" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6> User Login Information </h6>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3"> Username:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"> Password:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"> Confirm Password:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="confirmpass" required>
                                    <span class="alert-notif"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"> User Tpe:</label>
                                <div class="col-sm-9">
                                    <select name="usertype" class="form-control" required>
                                        <option value="admin">Admin</option>
                                        <option value="researcher">Researcher</option>
                                        <option value="university president">University President</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="ti-close"></i> Close</a>
                    <button class="btn btn-success btn-sm btn-submit" type="submit"><i class="ti-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>   
</div>
<script src="<?= base_url()?>assets/modules/js/admin.js"></script>