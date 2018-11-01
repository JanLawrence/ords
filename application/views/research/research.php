<!-- Landing Page of Researcher User -->
<div class="row">
    <div class="col-md-12">
        <!-- Form for creating new research-->
        <form id="newResearchForm" method="post" enctype="multipart/form-data">
            <div class="card rounded-0">
                <div class="card-body">
                    <label class="card-subtitle mb-3 text-muted"><small>Control Number: </small></label> <strong> <?= empty($control_num) ? 'RSH-0000001' : $control_num[0]->newnum?></strong>
                    <div class="form-group"> 
                        <label>Title: </label>
                        <input class="form-control" type="text" name="title" required>
                    </div>    
                    <div class="form-group">
                        <label>Details: </label>
                        <input class="form-control" type="text" name="details" required>
                    </div>    
                    <div class="form-group">
                        <label>Classification: </label>
                        <select class="form-control" name="classification" required>
                            <option selected disabled value="">--- Select Classification ---</option>
                            <?php foreach($classification as $each): ?>
                                <option value="<?= $each->id?>"><?= $each->classification?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>    
                    <div class="form-group">
                        <label>Deadline: </label>
                        <input class="form-control" type="date" name="deadline">
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
<!-- Point to external Javascript file -->
<script src="<?= base_url()?>assets/modules/js/research.js"></script>