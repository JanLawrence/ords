<!-- List of Classification -->
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                <form id="sendForm" method="post">
                    <div class="text-left">
                        <h3>Contact Us</h3>
                    </div><br>
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