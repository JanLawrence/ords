$(function(){
    $('#addForm').submit(function(){
        $.post(URL+'admin/saveUser',$(this).serialize())
        .done(returnData(function){
            alert(returnData);
            return false;
        })
        return false;
    })
})