$(function(){
    $('#addForm').submit(function(){ // submit add department form
        $.post(URL+'admin/saveDept', $(this).serialize()) // post to admin/savedepartment
        .done(function(returnData){
            if(returnData == 1){ // if existing department
                alert('Exisiting Department') // alert error
            } else {
                location.reload(); // reload if success
            }
        })
        return false;
    })
    $("#tableList").on('click','.btn-edit',function(){ // on click edit button on user list
        $('#editModal').modal('toggle'); // toggle edit modal
        
         // get values on attr of the button clicked
        var cid = $(this).attr('c_id');
        var cname = $(this).attr('c_name');

        // put attr values on each specific input 
        $('#editForm').find('input[name="id"]').val(cid);
        $('#editForm').find('input[name="department"]').val(cname);

        return false;
    })
    $('#editForm').submit(function(){ // submit edit department form
        $.post(URL+'admin/editDept',$(this).serialize()) // post to admin/editdepartment
        .done(function(returnData){
            if(returnData == 1){ // if existing department
                alert('Exisiting Department') // alert error
            } else {
                location.reload(); // reload if success
            }
        })
        return false;
    })
})