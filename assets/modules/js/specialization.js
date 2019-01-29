$(function(){
    $('#addForm').submit(function(){ // submit add form
        $.post(URL+'admin/saveSpecialization', $(this).serialize()) // post to admin/savedepartment
        .done(function(returnData){
            if(returnData == 1){ // if existing
                alert('Exisiting Specialization') // alert error
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
        $('#editForm').find('input[name="specialization"]').val(cname);

        return false;
    })
    $('#editForm').submit(function(){ // submit edit form
        $.post(URL+'admin/editSpecialization',$(this).serialize()) // post to admin/editSpecialization
        .done(function(returnData){
            if(returnData == 1){ // if existing
                alert('Exisiting Specialization') // alert error
            } else {
                location.reload(); // reload if success
            }
        })
        return false;
    })
})