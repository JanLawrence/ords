$(function(){
    $('#addForm').submit(function(){ // submit add classification form
        $.post(URL+'admin/saveClassification', $(this).serialize()) // post to admin/saveClassification
        .done(function(returnData){
            if(returnData == 1){ // if existing classification
                alert('Exisiting Classification') // alert error
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
        $('#editForm').find('input[name="classification"]').val(cname);

        return false;
    })
    $('#editForm').submit(function(){ // submit edit classification form
        $.post(URL+'admin/editClassification',$(this).serialize()) // post to admin/editClassification
        .done(function(returnData){
            if(returnData == 1){ // if existing classification
                alert('Exisiting Classification') // alert error
            } else {
                location.reload(); // reload if success
            }
        })
        return false;
    })
})