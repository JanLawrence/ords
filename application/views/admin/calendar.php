<?php
	$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
	list($year,$month) = explode('-',$date);
	$week1 = date('w',strtotime($year.'-'.$month.'-01'));
	$month = dateNumber($month);

	$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

	function dateNumber($int)
	{
		if(strlen($int) == 1)
		{
			return '0'.$int;
		} else 
		{
			return $int;
		}
	}
	function showWorkingCalendar($month, $year,$day, $check) {

		$date = $year.'-'.$month.'-'.str_pad($day, 2, '0', STR_PAD_LEFT);
		$dateToday = date('Y-m-d');
		$checkWeekEnd = date('N', strtotime($date)) >= 6;
		// $dateRegistered = date('Y-m-d', strtotime($_SESSION['user']['dateCreated']));

		// $check = DAOFactory::getTblWorkingCalendarDAO()->queryByWorkingDate($date);
		// $check = array();
		if(empty($check)){
			echo '<span class="calendar-day">'. str_pad($day, 2, '0', STR_PAD_LEFT) .'</span> <br> 
				<span class="calendar-working-day">No Event</span> <br><br>
				<span style="float:right;">
					<button class="btn btn-success btn-circle btnAddEvent"> <i class="ti-plus"></i></button></span>
				';
		} else {

			$viewRemarks = '';
			$workingTime = '<br><br>';
			// $workingDay = $check[0]->workingType == 'regular' ? 'Regular Working Day' : ($check[0]->workingType == 'holiday' ?  'Holiday' : 'Rest Day');
            $workingDay = $check[0]->event.'...';
            $viewRemarks = '<span style="float:left;">
			 		<button class="btn btn-info btn-circle btnViewRemarks" > <i class="ti-eye pe-lg"></i></button>
			 	</span>';
			// if($check[0]->remarks != ''){
			// 	$viewRemarks = '<span style="float:left;">
			// 		<button class="btn btn-info btn-circle btnViewRemarks" > <i class="pe-7s-look pe-lg"></i></button>
			// 	</span>';
			// }			
			// if($check[0]->workingType != 'restday'){
			// 	$workingTime = '<span class="calendar-working-time">'.date('h:i A', strtotime($check[0]->fromTime)).'-'.date('h:i A', strtotime($check[0]->toTime)).'</span><br>';
			// }
			echo '  
				<span class="calendar-day">'. str_pad($day, 2, '0', STR_PAD_LEFT) .'</span> <br> 
				<span class="calendar-working-day">'.$workingDay.'</span>'
				.$workingTime.
				'<span style="float:right;">
					<button class="btn btn-warning btn-circle btnUpdateEvent"> <i class="ti-pencil-alt"></i></button></span>'.$viewRemarks;
		}
		// print_r($check);
	}

?>
<style>
	.calendar > tr > td > span.calendar-working-day{
		font-size: 10px;
		font-weight: bolder;
		background: #21bc5a	;
		padding: 3px 10px;
		border-radius: 2px;
		color: #fff;
		margin: 5px auto;
		display: block;
		/* text-align: center; */
	}
	.calendar > tr > td > span.calendar-working-time{
		font-size: 10px;
		font-weight: bolder;
		background: #f44336;
		padding: 3px;
		border-radius: 2px;
		color: #fff;
		margin: 5px auto;
		display: block;
		text-align: center;
	}
	.btn-circle {
		width: 26px;
    	height: 26px;
	    text-align: center;
	    padding: 5px 5px;
	    font-size: 12px;
	    line-height: 1.428571429;
	    border-radius: 15px;
		}
	.showWorkingType{
		font-size: 18px; 
		padding: 10px; 
		background: #5bc0de; 
		color: #fff
	}
	.showTime{
		font-size: 12px;
		padding: 7px 11px;
		background: #f1f1f1;
		border-left: 1px solid #ddd;
		border-right: 1px solid #ddd;
		color: #585858;
	}
	.showRemarks{
		font-size: 15px;
		padding: 20px;
		background: #fff;
		border: 1px solid #ddd;
		height: 380px;
		overflow-y: scroll;
	}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <h3><i class="ti-calendar"></i> &nbsp<?= date('F Y', strtotime($date))?></h3>
                    </div>
                    <div class="float-right">
                        <a href="calendar?date=<?=date('Y-m-d',strtotime($date.'-1 month'))?>"><button type="button" class="btn btn-success" style="padding: 10px"> <i class="ti-angle-left"></i></button></a>
                        <a href="calendar?date=<?=date('Y-m-d',strtotime($date.' +1 month'))?>"><button type="button" class="btn btn-success" style="padding: 10px"> <i class="ti-angle-right"></i></button></a>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
					<table class="table table-standard table-bordered" style="height: 500px;">
						<thead>
							<tr>
								<th style="width:14.30%" class="text-center">Sun</th>
								<th style="width:14.30%" class="text-center">Mon</th>
								<th style="width:14.30%" class="text-center">Tue</th>
								<th style="width:14.30%" class="text-center">Wed</th>
								<th style="width:14.30%" class="text-center">Thu</th>
								<th style="width:14.30%" class="text-center">Fri</th>
								<th style="width:14.30%" class="text-center">Sat</th>
							</tr>
						</thead>
						<tbody class="calendar">
							<?php $day = 1;?>
							<tr>
								<?php for($i = 0; $i < 7; $i++):
										if($week1 > $i):?>
											<td></td>
									<?php else: ?>
											<td>
                                                <?php  	
                                                    $date = $year.'-'.$month.'-'.str_pad($day, 2, '0', STR_PAD_LEFT);
                                                    $this->db->select('ca.*, SUBSTRING(ca.event,1,20) sub_event')
                                                    ->from('tbl_calendar_activity ca');
                                                    $this->db->where('ca.event_date', $date);
                                                    $check = $this->db->get();
                                                ?>
												<?= showWorkingCalendar($month,$year,$day, $check->result()); ?>
											</td>
									<?php $day++; ?>
									<?php endif; ?>
								<?php endfor; ?>
							</tr>
							<?php $day--;?>
								<?php for($p = 1; $p < 6; $p++):?>
								<tr>
									<?php for($d = 1; $d <= 7; $d++):?>
										<?php if($day!=$days): $day++; ?>
											<td>
                                                <?php  	
                                                    $date = $year.'-'.$month.'-'.str_pad($day, 2, '0', STR_PAD_LEFT);
                                                    $this->db->select('ca.*, SUBSTRING(ca.event,1,20) sub_event')
                                                    ->from('tbl_calendar_activity ca');
                                                    $this->db->where('ca.event_date', $date);
                                                    $check = $this->db->get();
                                                ?>
												<?= showWorkingCalendar($month,$year,$day, $check->result()); ?>
											</td>
										<?php else: ?>
											<td></td>
										<?php endif; ?>
									<?php endfor; ?>
								</tr>
								<?php endfor; ?>
						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>
<form method="post" id="formAddEvent">
	<div id="sampleModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="pe-7s-date pe-lg"></i> Add Event</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        Date: 
                        <input type="text" class="form-control" readonly name="date">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        Event: 
                        <textarea class="form-control" rows="6" name="remarks" required></textarea>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

		</div>
	</div>
</form>
<form method="post" id="formUpdateEvent">
	<div id="updateModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="pe-7s-date pe-lg"></i> Update Event</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        Date: 
                        <input type="hidden" class="form-control" readonly name="id">
                        <input type="text" class="form-control" readonly name="date">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        Event: 
                        <textarea class="form-control" rows="6" name="remarks" required></textarea>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

		</div>
	</div>
</form>

<script>
	var year = "<?=$year?>";
	var month = "<?=$month?>";
	$(function(){
		// $('textarea[name="remarks"]').ckeditor();
		
		$('#formAddEvent').submit(function(){
            var form = $(this).serialize();
            if(confirm('Are you sure you want to add this event?') == true){
				$.post(URL+'admin/addEvent',form)
				.done(function(returnData){
					alert(returnData);
				})
				return false;
            } else {
                return false;
            }
			
		})
		$('#formUpdateEvent').submit(function(){
			var form = $(this).serialize();
			saveAlert('You want to update this event?',function(){
				$.post(URL+'calendar/updateEvent',form)
				.done(function(returnData){
					location.reload();
				})
				return false;
			})
			return false;
			
		})
		$('.btnAddEvent').click(function(){
			// getHoliday()
			var day = $(this).closest('td').find('span.calendar-day').html();
			var date = year+'-'+month+'-'+day;
			$('#sampleModal').modal('toggle');
			$('#formAddEvent').find('input[name="date"]').val(date);
		})
		$('.btnUpdateEvent').click(function(){
			var day = $(this).closest('td').find('span.calendar-day').html();
			var date = year+'-'+month+'-'+day;
			selectDate(date);
		})
		$('.btnViewRemarks').click(function(){
			var day = $(this).closest('td').find('span.calendar-day').html();
			var date = year+'-'+month+'-'+day;
			getEvent(date);
		})

	})
	function selectDate(date){
		$.post(URL+'admin/getEventByDate',{"date":date})
		.done(function(returnData){
			var data = $.parseJSON(returnData);
			$('#formUpdateEvent').find('input[name="date"]').val(data[0].event_date);
			$('#formUpdateEvent').find('input[name="id"]').val(data[0].id);
			$('#formUpdateEvent').find('textarea[name="remarks"]').val(data[0].event);
			$('#updateModal').modal({
			  	backdrop: 'static', 
			   	keyboard: false,
			   	toggle: true
			});

		})
	}
	function getEvent(date){
		$.post(URL+'calendar/getEventByDateHoliday',{'date':date})
		.done(function(returnData){
			var data = $.parseJSON(returnData);
			if(data[0].remarks!=''){
				var monthNames = ["","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
				var wdayTitle = (data[0].working_type == "regular") ? data[0].working_type.toUpperCase()+' WORKING DAY' : ((data[0].working_type == "holiday") ? data[0].working_type.toUpperCase()+' ('+data[0].holiday+')' : data[0].working_type.toUpperCase());
				var wTimeTitle = (data[0].working_type == "regular" || data[0].working_type == "holiday") ? tConvert(data[0].fromTime)+' - '+tConvert(data[0].toTime) : '';
				var month = monthNames[Number(date.split('-')[1]).toString()];
				var day = date.split('-')[2];
				var year = date.split('-')[0];
				$('.titleDate').html(month+' '+day+', '+year);
				$('.showWorkingType').html(wdayTitle);
				$('.showTime').html(wTimeTitle);
				$('.showRemarks').html(data[0].remarks);
				$('#showInfo').modal({
				  	backdrop: 'static', 
				    keyboard: false,
				    toggle: true
				});
			}
		})
	}
</script>