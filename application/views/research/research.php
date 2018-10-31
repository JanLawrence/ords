<div class="row">
    <div class="col-md-12">
        <form id="newResearchForm" method="post" enctype="multipart/form-data">
            <div class="card border-top-0 rounded-0">
                <div class="card-body">
                    <label class="card-subtitle mb-3 text-muted"><small>Control Number: </small></label> <strong> <?= $control_num[0]->newnum?></strong>
                    <div class="form-group">
                        <label>Title: </label>
                        <input class="form-control" type="text" name="title" required>
                    </div>    
                    <div class="form-group">
                        <label>Details: </label>
                        <input class="form-control" type="text" name="details" required>
                    </div>    
                    <div class="form-group">
                        <label>Upload File: </label>
                        <input class="form-control" type="file" name="file">
                    </div>    
                    <div class="form-group">
                        <label>Content: </label>
                        <textarea class="form-control" type="text" name="research" id="editor" required></textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-info" type="submit"><i class="ti-save"></i> Submit</button> 
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url()?>assets/modules/js/research.js"></script>