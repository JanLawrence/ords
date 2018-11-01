$(function(){
    $('#researchList').on('click', '.btn-view-notes', function(){ // on click notes buttons on research list
        var id = $(this).attr('rid'); // get attr values for status and research id
         $.post(URL+'admin/viewNotesPerResearch',{'research': id}) // post to admin/viewNotesPerResearch and pass research id
        .done(function(returnData){
            $('#returnNotes').html(returnData) // pass the return of the post to notes modal
            $('#viewNotesModal').modal('toggle');
        })
    })
    CKEDITOR.replace( 'editor' ); // toggle ckeditor on textarea with id = editor
    // new research
    $('#newResearchForm').submit(function(e){ 
        var content = CKEDITOR.instances.editor.getData(); // get CKeditor data
        var file = $('#newResearchForm').find('input[name="file"]').get(0).files.length; // get file length
        
        var form = new FormData(this); // get form data
        form.append('content', content); // add ckeditor content to form

        if(content != '' || file != 0){ // if neither two of content or file is required
            $.ajax({
                url: URL + 'research/add', // post to research/add
                type: "POST",
                data:  form,
                contentType: false, // for file uploading purposes
                cache: false,  // for file uploading purposes
                processData:false, // for file uploading purposes
                success: function(returnData){ // get returned data in the posted link by using returnData variable
                    if(returnData == 2){ // if returned data is equal to 2 or if not PDF
                        alert('Please upload PDF files only'); // alert PDF only 
                    } else if(returnData == 1){  // if returned data is equal to 1 or if error file
                        alert('Error file uploaded'); // alert error
                    } else {
                        location.href = URL+"research/researchList"; //if success redirect to research list
                    }
                }
            });
        } else {
            alert('Either content or file is required'); // alert if nothing of the file or content is inputed
        }
        return false;
            
    })

    // edit research (same comments for new research)
    $('#editResearchForm').submit(function(e){
        var content = CKEDITOR.instances.editor.getData();  // get CKeditor data
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