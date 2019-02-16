<!-- Researcher Login -->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Language" content="en">
        <title>ORDS</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.min.css" >
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/themify-icons.css" >
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/modules/css/login.css" >
        <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/style-me.css" >
        <script src="<?= base_url();?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url();?>assets/js/popper.min.js"></script>
        <script src="<?= base_url();?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url();?>assets/ckeditor/ckeditor.js"></script>
        <script>
             var URL = "<?= base_url()?>";
        </script>
        <script src="<?= base_url()?>assets/modules/js/admin.js"></script>
      
    </head>
    <body>
        <!-- for title and details of system -->
        <div class="sidenav">
            <div class="login-main-text">
                <h2><strong>ORDS</strong><br></h2>
                <p>Research Evaluation, Implementation and Monitoring System</p>
            </div>
            <div class="login-main-text" style="margin-top:400px;">
                <p><a href="<?= base_url()?>contactus"><i class="ti-email"></i> Contact Us</a></p>
            </div>
        </div>
        <!-- login form -->
        <div class="main">
            <div class="col-md-6 col-sm-12">
                <div class="login-form">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="User Name" name="username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                        <!-- for validation(if entry is invalid this class will show) -->
                        <div class="form-group text-center">
                            <?php if(validation_errors() == true):?> 
                                <div class="alert alert-danger"><i class="ti-alert"></i> Invalid Username or Password</div>
                            <?php endif;?> 
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-black">Login</button>
                            <button type="button" class="btn btn-black" data-toggle="modal" data-target="#addModal">Register Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="addModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Register</h4>
                    </div>
                    <form id="addForm" method="post">
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
                                            <input type="text" class="form-control" name="mname">
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
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3"> Confirm Password:</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="confirmpass" required>
                                            <span class="alert-notif"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3"> User Type:</label>
                                        <div class="col-sm-9">
                                            <select name="usertype" class="form-control" required>
                                            <option value="admin">Admin</option>
                                                <option value="researcher">Researcher</option>
                                                <option value="pres">University President</option>
                                                <option value="twg">TWG</option>
                                                <option value="rde">RDE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row dept d-none">
                                        <label class="col-sm-3"> Department:</label>
                                        <div class="col-sm-9">
                                            <select name="department" class="form-control">
                                                <?php if(!empty($deptList)):
                                                    foreach($deptList as $each){
                                                ?>
                                                    <option value="<?= $each->id?>"><?= $each->department?></option>
                                                <?php 
                                                    }
                                                else:
                                                ?>
                                                    <option selected disabled>Setup Department<option>
                                                <?php endif;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row spec d-none">
                                        <label class="col-sm-3"> Specialization:</label>
                                        <div class="col-sm-9">
                                            <select name="specialization" class="form-control">
                                                <?php if(!empty($specialization)):
                                                    foreach($specialization as $each){
                                                ?>
                                                    <option value="<?= $each->id?>"><?= $each->specialization?></option>
                                                <?php 
                                                    }
                                                else:
                                                ?>
                                                    <option selected disabled>Setup Specialization<option>
                                                <?php endif;?>
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
    </body>
</html>
