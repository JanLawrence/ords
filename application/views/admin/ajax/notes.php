<?php foreach($notes as $each):?>
<?php if($each->user_type == 'admin'): ?>
    <div class="card bg-light mb-3">
        <div class="card-body">
            <p class="card-text"><?= $each->notes?></p>
            <h6 class="card-subtitle mb-2 text-muted"><small>By: <?= ucwords($each->user_type) ?> - <?=date('F d, Y H:i A', strtotime($each->date_created))?></small></h6>
        </div>
    </div>
<?php elseif($each->user_type == 'university president'): ?>
    <div class="card text-white bg-info mb-3">
        <div class="card-body">
            <p class="card-text"><?= $each->notes?></p>
            <h6 class="card-subtitle mb-2 text-light"><small>By: <?= ucwords($each->user_type) ?> - <?=date('F d, Y H:i A', strtotime($each->date_created))?></small></h6>
        </div>
    </div>
<?php endif;?>
<?php endforeach;?>