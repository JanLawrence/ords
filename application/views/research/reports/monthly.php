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
                        <button class="btn btn-info addBtn" type="button"> Add</button> 
                        <button class="btn btn-info" type="submit" form="monthlyForm"> Submit</button> 
                    </div>
                </div>
                <hr>
                <form id="monthlyForm" method="post">
				<table class="table table-bordered table-striped table-hovered" id="monthlyReport">
					<thead>
						<tr>
							<th rowspan="2">Objectives</th>
							<th rowspan="2">Activities</th>
							<th colspan="2">Person</th>
							<th rowspan="2">Schedule</th>
							<th rowspan="2">Resource</th>
							<th rowspan="2">Output</th>
							<th rowspan="2"></th>
						</tr>
						<tr>
							<th>Responsible</th>
							<th>Involved</th>
						</tr>
					</thead>
					<tbody>
                        <?php foreach($research as $each): ?> <!-- foreach loop: this displays array of data  -->
                            <tr>
                                <td class="text-center"><?= $each->objectives?></td>
                                <td class="text-center"><?= $each->activities?></td>
                                <td class="text-center"><?= $each->responsible?></td>
                                <td class="text-center"><?= $each->involved?></td>
                                <td class="text-center"><?= $each->schedule?></td>
                                <td class="text-center"><?= $each->resources?></td>
                                <td class="text-center"><?= $each->output?></td>
                                <td class="text-center"></td>
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
        var append = `<tr>
                        <td class="text-center"><input class="form-control" required type="text" name="objectives[]"></td>
                        <td class="text-center"><input class="form-control" required type="text" name="activities[]"></td>
                        <td class="text-center"><input class="form-control" required type="text" name="responsible[]"></td>
                        <td class="text-center"><input class="form-control" required type="text" name="involved[]"></td>
                        <td class="text-center"><input class="form-control" required type="text" name="schedule[]"></td>
                        <td class="text-center"><input class="form-control" required type="text" name="resources[]"></td>
                        <td class="text-center"><input class="form-control" required type="text" name="output[]"></td>
                        <td class="text-center"><button class="btn btn-danger btn-delete">Delete</button></td>
                    </tr>`;
        $('.addBtn').click(function(){
            $('#monthlyReport tbody').append(append);
            // table.draw();

            $('.btn-delete').click(function(){
                $(this).closest('tr').remove();
            })
        })
        $('#monthlyForm').submit(function(){
            var form = $(this).serialize();
            if(confirm('Are you sure you want to add this report?')){
                $.post(URL+'research/addMonthly', form)
                .done(function(returnData){
                    alert(returnData);
                    alert('Saved successfully')
                    location.reload();
                })
                return false;
            } else {
                return false;
            }
        })
    })
</script>