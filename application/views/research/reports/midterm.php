<?php 
  $user = $this->session->userdata['user'];
?>
<div class="row">
	<div class="col-md-12">
		<div class="card rounded-0">
			<div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <h3>Monthly Report</h3>
                    </div>
                    <div class="float-right text-right">
                        <a class="btn btn-info" href="<?= base_url()?>files/logo.jpg"> Download</a> 
                    </div>
                </div>
				<hr>
				<table class="table table-bordered table-striped table-hovered" id="researchList">
					<thead>
						<tr>
							<th style="width: 15%">Control Number</th>
							<th style="width: 35%">Title</th>
							<th style="width: 5%">Duration</th>
							<th style="width: 15%">Date Submitted</th>
							<th style="width: 10%">Status</th>
						</tr>
					</thead>
					<tbody>
                        <?php if(!empty($research)):?> <!-- if variable research is not empty proceed to foreach -->
                            <?php foreach($research as $each): ?> <!-- foreach loop: this displays array of data  -->
                                <tr>
                                    <td><strong><?= $each->series_number?></strong></td>
                                    <td><?= $each->title?></td>
                                    <td><?= $each->duration_date?></td>
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
                                        <span class="badge badge-success">For approval TWG</span>
                                        <?php elseif($each->status == 'twg_approved'):?>
                                        <span class="badge badge-success">For approval RDE</span>
                                        <?php elseif($each->status == 'rde_approved'):?>
                                        <span class="badge badge-success">For approval University President</span>
                                        <?php elseif($each->status == 'pres_approved'):?>
                                        <span class="badge badge-success">Approved</span>
                                        <?php elseif($each->status == 'admin_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By Admin</span>
                                        <?php elseif($each->status == 'twg_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By TWG</span>
                                        <?php elseif($each->status == 'rde_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By RDE</span>
                                        <?php elseif($each->status == 'pres_disapproved'):?>
                                        <span class="badge badge-danger">Disapproved By University President</span>
                                        <?php endif;?> 
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan = "6" class="text-center"> No result </td>
                            </tr>
                        <?php endif;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>