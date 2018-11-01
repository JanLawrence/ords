<!-- Edit  Selected Data-->
<div class="row">
    <div class="col-md-12">
        <form id="editResearchForm" method="post" enctype="multipart/form-data">
            <div class="card rounded-0">
                <div class="card-body">
                    <!-- value displays existing data -->
                    <div class="form-group">
                        <label>Title: </label>
                        <input class="form-control" type="hidden" name="id" value="<?= $research[0]->id?>" required>
                        <input class="form-control" type="text" name="title" value="<?= $research[0]->title?>" required>
                    </div>    
                    <div class="form-group">
                        <label>Details: </label>
                        <input class="form-control" type="text" name="details" value="<?= $research[0]->details?>"  required>
                    </div>
                    <div class="form-group">
                        <label>Classification: </label>
                        <select class="form-control" name="classification" required>
                            <option selected disabled value="">--- Select Classification ---</option>
                            <?php foreach($classification as $each): ?>
                                <option value="<?= $each->id?>" <?= $research[0]->classification_id == $each->id ? 'selected' : ''?>><?= $each->classification?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>    
                    <div class="form-group">
                        <label>Deadline: </label>
                        <input class="form-control" type="date" name="deadline" value="<?= $research[0]->deadline?>">
                    </div>
                    <div class="form-group">
                        <label>Upload File: </label>
                        <input class="form-control" type="file" name="file">
                    </div>    
                    <div class="form-group">
                        <label>Content: </label>
                        <textarea class="form-control" type="text" name="research" id="editor" required><?= $research[0]->content?></textarea>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-info" type="submit"><i class="ti-save"></i> Submit</button> 
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Point to external Javascript file -->
<script src="<?= base_url()?>assets/modules/js/research.js"></script>