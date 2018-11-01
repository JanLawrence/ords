$(function(){
    $('#addForm').submit(function(){ // submit add user form
        var pass = $(this).find('input[name="password"]').val();
        var confirmpass = $(this).find('input[name="confirmpass"]').val();
        var that = $(this);
        if(pass == confirmpass){ // validation password and confirm pass
            $.post(URL+'admin/saveUser',that.serialize()) // post to admin/saveUser
            .done(function(returnData){
                if(returnData == 1){ // if existing username
                    alert('Exisiting Username') // alert error
                } else {
                    location.reload(); // reload if success
                }
            })
        } else {
            alert('Password do not match.'); // alert error if pass not match
        }
        return false;
    })
    $("#tableList").on('click','.btn-edit',function(){ // on click edit button on user list
        $('#editModal').modal('toggle'); // toggle edit modal
        
         // get values on attr of the button clicked
        var uid = $(this).attr('userid');
        var fname = $(this).attr('u_fname');
        var lname = $(this).attr('u_lname');
        var mname = $(this).attr('u_mname');
        var userType = $(this).attr('u_user_type');
        var email = $(this).attr('u_email');
        var position = $(this).attr('u_position');
        var username = $(this).attr('u_username');
        var password = $(this).attr('u_password');

        // put attr values on each specific input 
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
    $('#editForm').submit(function(){ // submit edit user form
        var pass = $(this).find('input[name="password"]').val();
        var confirmpass = $(this).find('input[name="confirmpass"]').val();
        var that = $(this);
        if(pass == confirmpass){ // validation password and confirm pass
            $.post(URL+'admin/editUser',that.serialize()) // post to admin/editUser
            .done(function(returnData){
                if(returnData == 1){ // if existing username
                    alert('Exisiting Username') // alert error
                } else {
                    location.reload(); // reload if success
                }
            })
        } else {
            alert('Password do not match.'); // alert error if pass not match
        }
        return false;
    })
    $('#researchList').on('click', '.btn-status', function(){ // on click status buttons on research list
        // get attr values for status and research id
        var status = $(this).attr('status');
        var id = $(this).attr('rid');
        
        var r = confirm("Are you sure?"); // alert confirmation if will update
        if (r == true) {
            $.post(URL+'admin/changeResearchStatus',{'status': status, 'id': id})  // post to admin/changeResearchStatus
            .done(function(returnData){
                location.reload(); // reload if success
            })
        } 
        return false;
    })
    $('#researchList').on('click', '.btn-notes', function(){ // on click notes buttons on research list

        var id = $(this).attr('rid'); // get attr values for status and research id
        $('#addNotesForm').find('input[name="id"]').val(id); // put attr values on each specific input 
        
        $('#addNotesModal').modal('toggle'); // toggle notes modal
    })
    $('#addNotesForm').submit(function(){ // submit add notes form
        var r = confirm("Are you sure?"); // alert confirmation if will add note
        if (r == true) {
            $.post(URL+'admin/addNotes',$(this).serialize()) // post to admin/addNotes
            .done(function(returnData){
                location.reload(); // reload if success
            })
        }
        return false;
    })
    $('#researchList').on('click', '.btn-view-notes', function(){ // on click notes buttons on research list

        var id = $(this).attr('rid'); // get attr values for status and research id
         $.post(URL+'admin/viewNotesPerResearch',{'research': id}) // post to admin/viewNotesPerResearch and pass research id
        .done(function(returnData){
            $('#returnNotes').html(returnData) // pass the return of the post to notes modal
            $('#viewNotesModal').modal('toggle');
        })
    })
})