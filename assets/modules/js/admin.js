$(function(){
    $('#addForm').submit(function(){
        var pass = $(this).find('input[name="password"]').val();
        var confirmpass = $(this).find('input[name="confirmpass"]').val();

        if(pass == confirmpass){

            $.post(URL+'admin/saveUser',$(this).serialize())
            .done(function(returnData){
                location.reload();
            })
        } else {
            alert('Password do not match.');
        }
        return false;
    })
    $("#tableList").on('click','.btn-edit',function(){
        $('#editModal').modal('toggle');

        var uid = $(this).attr('userid');
        var fname = $(this).attr('u_fname');
        var lname = $(this).attr('u_lname');
        var mname = $(this).attr('u_mname');
        var userType = $(this).attr('u_user_type');
        var email = $(this).attr('u_email');
        var position = $(this).attr('u_position');
        var username = $(this).attr('u_username');
        var password = $(this).attr('u_password');

        $('#editForm').find('input[name="id"]').val(uid);
        $('#editForm').find('input[name="fname"]').val(fname);
        $('#editForm').find('input[name="mname"]').val(mname);
        $('#editForm').find('input[name="lname"]').val(lname);
        $('#editForm').find('input[name="email"]').val(email);
        $('#editForm').find('input[name="position"]').val(position);
        $('#editForm').find('input[name="username"]').val(username);
        $('#editForm').find('input[name="password"]').val(password);
        $('#editForm').find('input[name="confirmpass"]').val(password);
        $('#editForm').find('select[name="usertype"]').val(userType).change();

        return false;
    })
    $('#editForm').submit(function(){
        var pass = $(this).find('input[name="password"]').val();
        var confirmpass = $(this).find('input[name="confirmpass"]').val();

        if(pass == confirmpass){

            $.post(URL+'admin/editUser',$(this).serialize())
            .done(function(returnData){
                location.reload();
            })
        } else {
            alert('Password do not match.');
        }
        return false;
    })
})