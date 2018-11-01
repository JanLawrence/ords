<!-- Display Research List -->
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
                                <th style="width: 10%"><i class="ti-settings"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Statements for displaying data -->
                            <?php if(!empty($research)):?> <!-- if variable research is not empty proceed to foreach -->
                            <?php foreach($research as $each): ?> <!-- foreach loop: this displays array of data  -->
                                <tr>
                                    <td>
                                        <strong><?= $each->series_number?></strong>
                                        <p><p>
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
                                        <?php endif;?>
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
                                    <td>
                                        <?php if($each->status == 'pending'):?>
                                            <a href="<?= base_url()?>research/researchEdit?id=<?=$each->id?>" target="_blank" class="btn btn-info btn-sm"><i class="ti-pencil-alt"></i> Edit</a>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach;?><!-- end of foreach loop -->
                            <?php else:?> <!-- if variable research is empty; displays-->
                                <tr>
                                    <td colspan = "6" class="text-center"> No pending research found. </td>
                                </tr>
                            <?php endif;?> <!-- end of if statement -->      
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
<!-- Point to external Javascript file -->
<script src="<?= base_url()?>assets/modules/js/research.js"></script>