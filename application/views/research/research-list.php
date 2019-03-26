<!-- Display Research List -->
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                    <form method="get">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>From</label>
                                <input type="date" class="form-control" name="from" value="<?= isset($_GET['from']) && $_GET['from'] != '' ? $_GET['from'] : ''?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label>To</label>
                                <input type="date" class="form-control" name="to" value="<?= isset($_GET['to']) && $_GET['to'] != '' ? $_GET['to'] : ''?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Status</label>
                                <input type="date" class="form-control" name="to" value="<?= isset($_GET['to']) && $_GET['to'] != '' ? $_GET['to'] : ''?>">
                            </div>
                            <div class="form-group col-md-3 mt-4">
                                <button type="submit" class="btn btn-info"> Generate</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped table-hovered" id="researchList">
                        <thead>
                            <tr>
                                <th style="width: 10%">Control Number</th>
                                <th style="width: 30%">Title & Details</th>
                                <th style="width: 10%">Department</th>
                                <th style="width: 10%">College</th>
                                <!-- <th style="width: 10%">Classification</th>
                                <th style="width: 5%">Deadline</th> -->
                                <th style="width: 10%">Date Submitted</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 10%"><i class="ti-settings"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Statements for displaying data -->
                            <?php foreach($research as $each): ?> <!-- foreach loop: this displays array of data  -->
                                <tr>
                                    <td>
                                        <strong><?= $each->series_number?></strong>
                                        <p><p>
                                    </td>
                                    <td>
                                        <h5><?= $each->title?></h5><hr>
                                        <p><?= $each->details ?></p>
                                        <!-- <a target="_blank" href="<?= base_url()?>research/showContent?id=<?=$each->id?>"><small>View Content</small></a> -->
                                        <a r-id="<?=$each->id?>" href="#" class="showContentBtn"><small>View Content</small></a>
                                        <?php if($each->file_name != ''):?>
                                             <?= ' | '?> 
                                            <a target="_blank" href="<?= base_url()?>research/download?id=<?=$each->id?>"><small>Download File</small></a> 
                                        <?php endif;?><br><br>
                                        <?php if($each->duration_date != ''):?>
                                        <small>Duration Date: <?= date('F d, Y' , strtotime($each->duration_date))?></small>
                                        <?php endif;?>
                                    </td>
                                    <!-- <td><?= $each->classification ?></td>
                                    <td><?= date('F d, Y' , strtotime($each->deadline)) ?></td> -->
                                    <td><?= $each->department ?></td>
                                    <td><?= $each->moi ?></td>
                                    <td><?= date('F d, Y  h:i A' , strtotime($each->date_created)) ?></td>
                                    <td class="text-center">
                                        <?php if($each->status == 'open'):?>
                                        <span class="badge badge-warning"><?= ucwords($each->status);?></span>
                                        <?php elseif($each->status == 'admin_remarks'):?>
                                        <span class="badge badge-warning">For Director Remarks</span>
                                        <?php elseif($each->status == 'twg_remarks'):?>
                                        <span class="badge badge-warning">For TWG Remarks</span>
                                        <?php elseif($each->status == 'rde_remarks'):?>
                                        <span class="badge badge-warning">For RDE Remarks</span>
                                        <?php elseif($each->status == 'pres_remarks'):?>
                                        <span class="badge badge-warning">For University President Remarks</span>
                                        <?php elseif($each->status == 'admin_approved'):?>
                                        <span class="badge badge-success">For approval TWG</span>
                                        <?php elseif($each->status == 'twg_approved'):?>
                                        <span class="badge badge-success">For approval RDE</span>
                                        <?php elseif($each->status == 'rde_approved'):?>
                                        <span class="badge badge-success">Approved</span>
                                        <?php elseif($each->status == 'pres_approved'):?>
                                        <span class="badge badge-success">Approved</span>
                                        <?php elseif($each->status == 'admin_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By Director</span>
                                        <?php elseif($each->status == 'twg_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By TWG</span>
                                        <?php elseif($each->status == 'rde_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By RDE</span>
                                        <?php elseif($each->status == 'pres_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By University President</span>
                                        <?php endif;?> 
                                        <?php   
                                            // check if research has notes
                                            $notes = $this->db->get_where('tbl_research_notes', array('research_id' => $each->id)); //get notes by research id
                                            $notes= $notes->result();
                                            if(!empty($notes)):
                                        ?>
                                            <hr>
                                            <a class="btn-view-notes" rid="<?= $each->id ?>" href="#"><small>View Notes  <span class="badge badge-danger"><?= count($notes)?></span></small></a>
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <?php if($each->status == 'admin_remarks' || $each->status == 'twg_remarks' || $each->status == 'rde_remarks' || $each->status == 'pres_remarks'):?>
                                            <a href="<?= base_url()?>research/researchEdit?id=<?=$each->id?>" target="_blank" class="btn btn-info btn-sm"><i class="ti-pencil-alt"></i> Edit</a>
                                        <?php endif;?>
                                        <?php if($each->status == 'rde_approved'):?>
                                            <a class="btn btn-info btn-sm btn-upload text-light" rid="<?=$each->id?>"><i class="ti-upload"></i> Upload</a>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach;?><!-- end of foreach loop -->
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="viewNotesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="ti-plus"></i>Notes</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="returnNotes">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="ti-close"></i> Close</a>
            </div>
        </div>
    </div>   
</div>
<form id="uploadResearchForm" method="post" enctype="multipart/form-data">
    <div class="modal" id="uploadResearchModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4><i class="ti-plus"></i>Upload File</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Upload File: </label>
                        <input class="form-control" type="hidden" name="id">
                        <input class="form-control" type="file" name="file">
                    </div>    
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="ti-close"></i> Close</a>
                    <button type="submit" class="btn btn-success btn-sm"><i class="ti-save"></i> Submit</a>
                </div>
            </div>
        </div>   
    </div>
</form>
<div class="modal" id="showContentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="contentContainer">
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="ti-close"></i> Close</a>
            </div>
        </div>
    </div>   
</div>
<script>
    $(function(){
        $('.showContentBtn').click(function(){
            var id = $(this).attr('r-id');
            $.post(URL+'research/showContent', {'id': id})
            .done(function(returnData){
                $('#contentContainer').html(returnData);
                $('#showContentModal').modal('show');
            })
        })
    })
</script>
<!-- Point to external Javascript file -->
<script src="<?= base_url()?>assets/modules/js/research.js"></script>