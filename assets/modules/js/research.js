$(function(){
    CKEDITOR.replace( 'editor' );
    $('#newResearchForm').submit(function(){
        var content = CKEDITOR.instances.editor.getData();
        var file = $('input[name="file"]').get(0).files.length;
        
        var form = new FormData(this);
        form.append('content', content);

        if(content != '' || file != 0){
            $.ajax({
                url: URL + 'research/add',
                type: "POST",
                data:  form,
                contentType: false,
                cache: false,
                processData:false,
                success: function(returnData){
                    alert(returnData)
                }
            });
        } else {
            alert('Either content or file is required');
        }
        return false;
            
    })
})