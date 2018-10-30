$(function(){
    CKEDITOR.replace( 'editor' );
    $('#newResearchForm').submit(function(e){
        var content = CKEDITOR.instances.editor.getData();
        var file = $('#newResearchForm').find('input[name="file"]').get(0).files.length;
        
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
                    if(returnData == 2){
                        alert('Please upload PDF files only');
                    } else if(returnData == 1){
                        alert('Error file uploaded');
                    } else {
                        location.href = URL+"research/researchList";
                    }
                }
            });
        } else {
            alert('Either content or file is required');
        }
        return false;
            
    })
    $('#editResearchForm').submit(function(e){
        var content = CKEDITOR.instances.editor.getData();
        var file = $('#editResearchForm').find('input[name="file"]').get(0).files.length;
        
        var form = new FormData(this);
        form.append('content', content);

        if(content != '' || file != 0){
            $.ajax({
                url: URL + 'research/edit',
                type: "POST",
                data:  form,
                contentType: false,
                cache: false,
                processData:false,
                success: function(returnData){
                    if(returnData == 2){
                        alert('Please upload PDF files only');
                    } else if(returnData == 1){
                        alert('Error file uploaded');
                    } else{
                        location.href = URL+"research/researchList";
                    }
                }
            });
        } else {
            alert('Either content or file is required');
        }
        return false;
            
    })
})