<?php foreach($notes as $each):?>
<?php if($each->user_type == 'rnd'): ?>
    <div class="card bg-light mb-3">
        <div class="card-body">
            <p class="card-text"><?= $each->notes?></p>
            <h6 class="card-subtitle mb-2 text-muted"><small>By: <?= ucwords($each->user_type) ?> - <?=date('F d, Y H:i A', strtotime($each->date_created))?></small></h6>
            <?php if($each->attachment_id != ''): ?>
                <a href="<?= base_url()?>admin/downloadNote?id=<?= $each->attachment_id?>"> Download Attachment </a>
            <?php endif;?>
        </div>
    </div>
<?php elseif($each->user_type == 'twg'): ?>
    <div class="card bg-warning mb-3">
        <div class="card-body">
            <p class="card-text"><?= $each->notes?></p>
            <h6 class="card-subtitle mb-2 text-muted"><small>By: <?= ucwords($each->user_type) ?> - <?=date('F d, Y H:i A', strtotime($each->date_created))?></small></h6>
            <?php if($each->attachment_id != ''): ?>
                <a href="<?= base_url()?>admin/downloadNote?id=<?= $each->attachment_id?>"> Download Attachment </a>
            <?php endif;?>
        </div>
    </div>
<?php elseif($each->user_type == 'rde'): ?>
    <div class="card bg-danger mb-3">
        <div class="card-body">
            <p class="card-text"><?= $each->notes?></p>
            <h6 class="card-subtitle mb-2 text-muted"><small>By: <?= ucwords($each->user_type) ?> - <?=date('F d, Y H:i A', strtotime($each->date_created))?></small></h6>
            <?php if($each->attachment_id != ''): ?>
                <a href="<?= base_url()?>admin/downloadNote?id=<?= $each->attachment_id?>"> Download Attachment </a>
            <?php endif;?>
        </div>
    </div>
<?php elseif($each->user_type == 'pres'): ?>
    <div class="card text-white bg-info mb-3">
        <div class="card-body">
            <p class="card-text"><?= $each->notes?></p>
            <h6 class="card-subtitle mb-2 text-light"><small>By: <?= ucwords($each->user_type) ?> - <?=date('F d, Y H:i A', strtotime($each->date_created))?></small></h6>
            <?php if($each->attachment_id != ''): ?>
                <a href="<?= base_url()?>admin/downloadNote?id=<?= $each->attachment_id?>"> Download Attachment </a>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>

<?php endforeach;?>