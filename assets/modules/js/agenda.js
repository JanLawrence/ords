$(function(){
    $('#addForm').submit(function(){ // submit add agenda form
        $.post(URL+'admin/saveAgenda', $(this).serialize()) // post to admin/saveAagenda
        .done(function(returnData){
            if(returnData == 1){ // if existing agenda
                alert('Exisiting Agenda') // alert error
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
        $('#editForm').find('input[name="agenda"]').val(cname);

        return false;
    })
    $('#editForm').submit(function(){ // submit edit agenda form
        $.post(URL+'admin/editAgenda',$(this).serialize()) // post to admin/editAgenda
        .done(function(returnData){
            if(returnData == 1){ // if existing agenda
                alert('Exisiting Agenda') // alert error
            } else {
                location.reload(); // reload if success
            }
        })
        return false;
    })
})