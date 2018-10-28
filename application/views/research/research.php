<div class="row">
    <div class="col-md-12">
        <form>
            <div class="card border-top-0 rounded-0">
                <div class="card-body">
                    <div class="form-group">
                        <label>Title: </label>
                        <input class="form-control" type="text" name="title">
                    </div>    
                    <div class="form-group">
                        <label>Upload File: </label>
                        <input class="form-control" type="file" name="file">
                    </div>    
                    <div class="form-group">
                        <label>Create Research: </label>
                        <textarea class="form-control" type="text" name="research" id="editor"></textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-info"><i class="ti-save"></i> Submit</button> 
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url()?>assets/modules/js/research.js"></script>