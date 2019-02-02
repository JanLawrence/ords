<?php 
  $user = $this->session->userdata['user'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hovered" id="researchList">
                    <thead>
                        <tr>
                            <th style="width: 15%">Control Number</th>
                            <th style="width: 35%">Title & Details</th>
                            <!-- <th style="width: 10%">Classification</th>
                            <th style="width: 5%">Deadline</th> -->
                            <th style="width: 15%">Date Submitted</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%"><i class="ti-settings"></i></th>
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
                                    <a target="_blank" href="<?= base_url()?>research/showContent?id=<?=$each->id?>"><small>View Content</small></a>
                                        <?php if($each->file_name != ''):?>
                                             <?= ' | '?> 
                                            <a target="_blank" href="<?= base_url()?>research/download?id=<?=$each->id?>"><small>Download File</small></a> 
                                        <?php endif;?><hr>
                                    <small>By: <?= $each->researcher?></small><br><br>
                                    <?php if($each->duration_date != ''):?>
                                    <small>Duration Date: <?= date('F d, Y' , strtotime($each->duration_date))?></small>
                                    <?php endif;?>
                                </td>
                                <!-- <td><?= $each->classification ?></td>
                                <td><?= date('F d, Y' , strtotime($each->deadline)) ?></td> -->
                                <td><?= date('F d, Y  h:i A' , strtotime($each->date_created)) ?></td>
                                <td class="text-center">
                                    <?php if($each->status == 'open'):?>
                                    <span class="badge badge-warning"><?= ucwords($each->status);?></span>
                                    <?php elseif($each->status == 'admin_remarks'):?>
                                    <span class="badge badge-warning">For Admin Remarks</span>
                                    <?php elseif($each->status == 'twg_remarks'):?>
                                    <span class="badge badge-warning">For TWG Remarks</span>
                                    <?php elseif($each->status == 'rde_remarks'):?>
                                    <span class="badge badge-warning">For RDE Remarks</span>
                                    <?php elseif($each->status == 'pres_remarks'):?>
                                    <span class="badge badge-warning">For University President Remarks</span>
                                    <?php elseif($each->status == 'admin_approved'):?>
                                    <span class="badge badge-success">Approved By Admin</span>
                                    <?php elseif($each->status == 'twg_approved'):?>
                                    <span class="badge badge-success">Approved By TWG</span>
                                    <?php elseif($each->status == 'rde_approved'):?>
                                    <span class="badge badge-success">Approved By RDE</span>
                                    <?php elseif($each->status == 'pres_approved'):?>
                                    <span class="badge badge-success">Approved By University President</span>
                                    <?php elseif($each->status == 'admin_disapproved'):?>
                                    <span class="badge badge-danger">Disapproved By Admin</span>
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
                                    <?php if($user->user_type == 'admin'): ?>
                                        <?php if($each->status == 'open' || $each->status == 'admin_remarks'):?>
                                        <button class="btn btn-success btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="approved" type="button">Send</button>
                                        <!-- <button class="btn btn-danger btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="disapproved" type="button">Disapprove</button> -->
                                        <button class="btn btn-info btn-sm btn-notes" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" type="button"><i class="ti-plus"></i> Add Notes</button>
                                        <?php endif;?>
                                        <?php if($each->status == 'pres_approved' && $each->duration_date == ''):?>
                                        <button class="btn btn-info btn-sm btn-deadline" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" type="button"><i class="ti-calendar"></i> Set Deadline</button>
                                        <?php endif;?>
                                    <?php elseif($user->user_type == 'twg'): ?>
                                        <?php if($each->status == 'open' || $each->status == 'twg_remarks' || $each->status == 'admin_approved'):?>
                                        <button class="btn btn-success btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="approved" type="button">Approve</button>
                                        <button class="btn btn-danger btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="disapproved" type="button">Disapprove</button>
                                        <button class="btn btn-info btn-sm btn-notes" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" type="button"><i class="ti-plus"></i> Add Notes</button>
                                        <?php endif;?>
                                    <?php elseif($user->user_type == 'rde'): ?>
                                        <?php if($each->status == 'open' || $each->status == 'rde_remarks' || $each->status == 'twg_approved'):?>
                                        <button class="btn btn-success btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="approved" type="button">Approve</button>
                                        <button class="btn btn-danger btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="disapproved" type="button">Disapprove</button>
                                        <button class="btn btn-info btn-sm btn-notes" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" type="button"><i class="ti-plus"></i> Add Notes</button>
                                        <?php endif;?>
                                    <?php elseif($user->user_type == 'pres'): ?>
                                        <?php if($each->status == 'open' || $each->status == 'pres_remarks' || $each->status == 'rde_approved'):?>
                                        <button class="btn btn-success btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="approved" type="button">Approve</button>
                                        <button class="btn btn-danger btn-sm btn-status" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" status="disapproved" type="button">Disapprove</button>
                                        <button class="btn btn-info btn-sm btn-notes" rid="<?= $each->id ?>" rpid="<?=$each->research_progress_id?>" type="button"><i class="ti-plus"></i> Add Notes</button>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php //elseif($this->session->userdata['user']->user_type == 'university president'):?>
                                    <?php //if($each->president_status == 'remarks'):?>
                                        <!-- <button class="btn btn-success btn-sm btn-status" rid="<?= $each->id ?>" status="approved" type="button">Approve</button>
                                        <button class="btn btn-danger btn-sm btn-status" rid="<?= $each->id ?>" status="disapproved" type="button">Disapprove</button>
                                        <button class="btn btn-info btn-sm btn-notes" rid="<?= $each->id ?>" status="disapproved" type="button"><i class="ti-plus"></i> Add Notes</button> -->
                                    <?php //endif;?>
                                </td>
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
                                <input type="hidden" class="form-control" name="progress_id" required>
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
<div class="modal" id="setDurationModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="ti-plus"></i> Set Duration</h4>
            </div>
            <form id="addDurationForm" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Date:</label>
                                <input type="hidden" class="form-control" name="id" required>
                                <input type="hidden" class="form-control" name="progress_id" required>
                                <input type="date" class="form-control" name="date" required></textarea>
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