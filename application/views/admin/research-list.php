<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hovered" id="researchList">
                    <thead>
                        <tr>
                            <th style="width: 15%">Control Number</th>
                            <th style="width: 35%">Title & Details</th>
                            <th style="width: 10%">Classification</th>
                            <th style="width: 5%">Deadline</th>
                            <th style="width: 15%">Date Filed</th>
                            <th style="width: 10%">Status</th>
                            <?php if($this->session->userdata['user']->user_type == 'admin'):?>
                                <th style="width: 10%"><i class="ti-settings"></i></th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($research)):?>
                        <?php foreach($research as $each): ?>
                            <tr>
                                <td>
                                    <strong><?= $each->series_number?></strong><hr>
                                </td>
                                <td>
                                    <h5><?= $each->title?></h5><hr>
                                    <p><?= $each->details ?></p>
                                    <?php if($each->file_name != ''):?>
                                        <a target="_blank" href="<?= base_url()?>research/download?id=<?=$each->id?>"><small>Download File</small></a> 
                                        <?= ($each->content != '') ? ' | ' : ''?> 
                                    <?php endif;?>
                                    <?php if($each->content != ''):?>
                                        <a target="_blank" href="<?= base_url()?>research/showContent?id=<?=$each->id?>"><small>View Content</small></a>
                                    <?php endif;?><hr>
                                    <small>By: <?= $each->name?></small>
                                </td>
                                <td><?= $each->classification ?></td>
                                <td><?= date('F d, Y' , strtotime($each->deadline)) ?></td>
                                <td><?= date('F d, Y  h:i A' , strtotime($each->date_created)) ?></td>
                                <td class="text-center">
                                    <?php if($each->status == 'pending'):?>
                                    <span class="badge badge-warning"><?= ucwords($each->status);?></span>
                                    <?php elseif($each->status == 'approved'):?>
                                    <span class="badge badge-success"><?= ucwords($each->status);?></span>
                                    <?php elseif($each->status == 'disapproved'):?>
                                    <span class="badge badge-danger"><?= ucwords($each->status);?></span>
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
                                <?php if($this->session->userdata['user']->user_type == 'admin'):?>
                                    <td>
                                        <?php if($each->admin_status == 'remarks'):?>
                                            <button class="btn btn-success btn-sm btn-status" rid="<?= $each->id ?>" status="approved" type="button">Approve</button>
                                            <button class="btn btn-danger btn-sm btn-status" rid="<?= $each->id ?>" status="disapproved" type="button">Disapprove</button>
                                            <button class="btn btn-info btn-sm btn-notes" rid="<?= $each->id ?>" status="disapproved" type="button"><i class="ti-plus"></i> Add Notes</button>
                                        <?php endif;?>
                                    <?php //elseif($this->session->userdata['user']->user_type == 'university president'):?>
                                        <?php //if($each->president_status == 'remarks'):?>
                                            <!-- <button class="btn btn-success btn-sm btn-status" rid="<?= $each->id ?>" status="approved" type="button">Approve</button>
                                            <button class="btn btn-danger btn-sm btn-status" rid="<?= $each->id ?>" status="disapproved" type="button">Disapprove</button>
                                            <button class="btn btn-info btn-sm btn-notes" rid="<?= $each->id ?>" status="disapproved" type="button"><i class="ti-plus"></i> Add Notes</button> -->
                                        <?php //endif;?>
                                    </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan = "6" class="text-center"> No pending research found. </td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>
<div class="modal" id="addNotesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="ti-plus"></i> Add Notes</h4>
            </div>
            <form id="addNotesForm" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Note:</label>
                                <input type="hidden" class="form-control" name="id" required>
                                <textarea type="text" class="form-control" name="notes" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="ti-close"></i> Close</a>
                    <button class="btn btn-success btn-sm btn-submit" type="submit"><i class="ti-save"></i> Submit</button>
                </div>
            </form>
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
<script src="<?= base_url()?>assets/modules/js/admin.js"></script>