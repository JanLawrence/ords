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
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-3">
                <div class="card rounded-0">
                    <div class="card-body">
                        <form id="sendForm" method="post">
                            <div class="text-left">
                                <h3>Contact Us</h3>
                            </div><br>
                            <div class="form-group">
                                <input class="form-control" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="email" placeholder="Email" type="email">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="10" placeholder="Send us your message"></textarea>
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
<script>
    $(function(){
        $('#sendForm').submit(function(){ 
            var that = $(this);
            if(confirm("Are you sure you want to send this message?")){
                $.post(URL+'admin/saveMessage',that.serialize()) 
                .done(function(returnData){
                    alert('Message Submitted!')
                    location.reload();
                })
                return false;
            } else {
                alert('Password do not match.');
            }
            return false;
        })
    })
</script>