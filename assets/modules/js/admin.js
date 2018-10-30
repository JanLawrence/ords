$(function(){
    $('#addForm').submit(function(){
        $.post(URL+'admin/saveUser',$(this).serialize())
        .done(function(returnData){
            alert(returnData);
            return false;
        })
        return false;
    })
    $("#tableList").on('click','.btn-edit',function(){
        alert();
    })
})