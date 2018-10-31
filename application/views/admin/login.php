<!-- Admin Login -->
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
        <script src="<?= base_url();?>assets/js/jquery-slim.min.js"></script>
        <script src="<?= base_url();?>assets/js/popper.min.js"></script>
        <script src="<?= base_url();?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url();?>assets/ckeditor/ckeditor.js"></script>
      
    </head>
    <body>
        <!-- for title and details of system -->
        <div class="sidenav">
            <div class="login-main-text">
                <h2><strong>ORDS</strong><br></h2>
                <p>Research Evaluation, Implementation and Monitoring System</p>
                <p>Administrator</p>
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
                        <div class="form-group text-center">
                            <?php if(validation_errors() == true):?> 
                            <div class="alert alert-danger"><i class="ti-alert"></i> Invalid Username or Password</div>
                            <?php endif;?> 
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-black">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>