<div class="row">
    <div class="col-md-12">
        <div class="card  border-top-0 rounded-0">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <tr>
                            <th style="width: 15%">Control Number</th>
                            <th style="width: 50%">Title & Details</th>
                            <th style="width: 15%">Date Filed</th>
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
                                    <?php if($each->file_name != ''):?>
                                        <a target="_blank" href="<?= base_url()?>research/download?id=<?=$each->id?>"><small>Download File</small></a> 
                                        <?= ($each->content != '') ? ' | ' : ''?> 
                                    <?php endif;?>
                                    <?php if($each->content != ''):?>
                                        <a target="_blank" href="<?= base_url()?>research/showContent?id=<?=$each->id?>"><small>View Content</small></a>
                                    <?php endif;?><hr>
                                    <small>By: <?= $each->name?></small>
                                </td>
                                <td><?= date('F d, Y  h:i A' , strtotime($each->date_created)) ?></td>
                                <td class="text-center">
                                    <?php if($each->status == 'pending'):?>
                                        <span class="badge badge-warning"><?= ucwords($each->status);?></span>
                                    <?php elseif($each->status == 'approved'):?>
                                        <span class="badge badge-success"><?= ucwords($each->status);?></span>
                                    <?php elseif($each->status == 'disapproved'):?>
                                        <span class="badge badge-danger"><?= ucwords($each->status);?></span>
                                    <?php endif;?>
                                </td>
                                <td><a href="<?= base_url()?>research/researchEdit?id=<?=$each->id?>" target="_blank" class="btn btn-info btn-sm"><i class="ti-pencil-alt"></i> Edit</a></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan = "4" class="text-center"> No pending research found. </td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url()?>assets/modules/js/research.js"></script>