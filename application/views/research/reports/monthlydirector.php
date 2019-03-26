<?php 
    $user = $this->session->userdata['user'];
    $this->db->select('ui.user_id, CONCAT(ui.first_name," ",ui.middle_name," ",ui.last_name) u_name')
        ->from('tbl_user u')
        ->join('tbl_user_info ui', 'ui.user_id = u.id', 'left');
    $this->db->where('u.user_type', 'researcher');
    $this->db->where('u.username != "default"');
    $query = $this->db->get();
    $researchers = $query->result();
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
                    </div>
                </div>
                <form method="get" class="mt-3">
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
                            <label>Researcher</label>
                            <select name="researcher" class="form-control">
                                <option value="%%">All</option>
                                <?php foreach($researchers as $each): ?>
                                    <option value="<?= $each->user_id?>" <?= isset($_GET['researcher']) && $_GET['researcher'] == $each->user_id ? 'selected' : '' ?>><?= $each->u_name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3 mt-4">
                            <button type="submit" class="btn btn-info"> Generate</button>
                        </div>
                    </div>
                </form>
                <hr>
                <form id="monthlyForm" method="post">
				<table class="table table-bordered table-striped table-hovered" id="monthlyReport">
					<thead>
						<tr>
							<th rowspan="2">Researcher</th>
							<th rowspan="2">Objectives</th>
							<th rowspan="2">Activities</th>
							<th colspan="2">Person</th>
							<th rowspan="2">Schedule</th>
							<th rowspan="2">Resource</th>
							<th rowspan="2">Output</th>
							<th rowspan="2">Date Created</th>
						</tr>
						<tr>
							<th>Responsible</th>
							<th>Involved</th>
						</tr>
					</thead>
					<tbody>
                        <?php foreach($research as $each): ?> <!-- foreach loop: this displays array of data  -->
                            <tr>
                                <td class="text-center"><?= $each->u_name?></td>
                                <td class="text-center"><?= $each->objectives?></td>
                                <td class="text-center"><?= $each->activities?></td>
                                <td class="text-center"><?= $each->responsible?></td>
                                <td class="text-center"><?= $each->involved?></td>
                                <td class="text-center"><?= $each->schedule?></td>
                                <td class="text-center"><?= $each->resources?></td>
                                <td class="text-center"><?= $each->output?></td>
                                <td class="text-center"><?= date('F d, Y H:i A' , strtotime($each->date_created))?></td>
                            </tr>
                        <?php endforeach;?>
					</tbody>
                </table>
                </form>
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
        var table = $('#monthlyReport').DataTable();
    })
</script>    