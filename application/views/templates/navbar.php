<?php 
	$controller = $this->router->fetch_class();
	$method = $this->router->fetch_method();
	$userSession = $this->session->userdata['user'];
	$userInfo = $this->db->get_where('tbl_user_info', array('user_id' => $userSession->id));
	$userInfo = $userInfo->result();
	$ci =&get_instance();
	$ci->load->model('admin_model');
	$notif = $ci->admin_model->notifications();
?>
<style>
	.dtnotif{
		font-size: 10px;
		font-weight: 400;
	}
</style>
   <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 style="font-weight: 900;">ORDS</h3>
            </div>
			<ul class="list-unstyled components">

				<?php if($userSession->user_type == 'researcher'): ?>
					<li class=" <?= $controller.'/'.$method == 'research/dashboard' ? 'active' : ''?>">
						<a class="text-white" href="<?= base_url()?>research/dashboard"><i class="ti-dashboard"></i>&nbsp&nbsp Dashboard</a>
					</li>
					<li class="<?= $controller.'/'.$method == 'research/index' ? 'active' : ''?>">
						<a class="text-white" href="<?= base_url()?>research"><i class="ti-plus"></i>&nbsp&nbsp New Research</a>
					</li>
					<li class="<?= $controller.'/'.$method == 'research/researchList' ? 'active' : ''?>">
						<a class="text-white" href="<?= base_url()?>research/researchList"><i class="ti-write"></i>&nbsp&nbsp Research List</a>
					</li>
					<li class=" dropdown">
						<a class="dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">
							<i class="ti-clipboard"></i>&nbsp&nbsp Reports
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?= base_url()?>research/monthly">Monthly</a>
							<!-- <a class="dropdown-item" href="<?= base_url()?>research/midterm">Midterm</a> -->
							<a class="dropdown-item" href="<?= base_url()?>research/terminal">Terminal</a>
						</div>
					</li>
				<?php elseif($userSession->user_type == 'admin' || $userSession->user_type == 'pres' || $userSession->user_type == 'rde' || $userSession->user_type == 'twg' || $userSession->user_type == 'rnd' || $userSession->user_type == 'staff'): ?>
					<?php if($userSession->user_type == 'admin'):?>
						<li class="<?= $controller.'/'.$method == 'admin/addUser' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/addUser"><i class="ti-user"></i>&nbsp&nbsp User List</a>
						</li>
						<li class="<?= $controller.'/'.$method == 'admin/calendar' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/calendar"><i class="ti-calendar"></i>&nbsp&nbsp Calendar</a>
						</li>
						<!-- <li class="<?= $controller.'/'.$method == 'admin/classification' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/classification"><i class="ti-layers-alt"></i>&nbsp&nbsp Classification List</a>
						</li> -->
						<li class="<?= $controller.'/'.$method == 'admin/department' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/department"><i class="ti-layers-alt"></i>&nbsp&nbsp Department</a>
						</li>
						<li class="<?= $controller.'/'.$method == 'admin/specialization' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/specialization"><i class="ti-layers-alt"></i>&nbsp&nbsp Specialization</a>
						</li>
						<li class="<?= $controller.'/'.$method == 'admin/agenda' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/agenda"><i class="ti-layers-alt"></i>&nbsp&nbsp Agenda</a>
						</li>
						<li class="<?= $controller.'/'.$method == 'admin/userLogs' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/userLogs"><i class="ti-layers-alt"></i>&nbsp&nbsp User Logs</a>
						</li>
					<?php endif;?>
					<?php if( $userSession->user_type == 'pres' || $userSession->user_type == 'rde' || $userSession->user_type == 'twg' || $userSession->user_type == 'staff'):?>
						<li class="<?= $controller.'/'.$method == 'admin/dashboard' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/dashboard"><i class="ti-dashboard"></i>&nbsp&nbsp Dashboard</a>
						</li>
						<li class="<?= $controller.'/'.$method == 'admin/researchList' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/researchList"><i class="ti-write"></i>&nbsp&nbsp Research List</a>
						</li>
					<?php elseif($userSession->user_type == 'rnd'):?>
						<li class="<?= $controller.'/'.$method == 'admin/dashboard' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/dashboard"><i class="ti-dashboard"></i>&nbsp&nbsp Dashboard</a>
						</li>
						<li class="<?= $controller.'/'.$method == 'admin/researchList' ? 'active' : ''?>">
							<a class="text-white" href="<?= base_url()?>admin/researchList"><i class="ti-write"></i>&nbsp&nbsp Research List</a>
						</li>
						<li class=" dropdown">
							<a class="dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false">
								<i class="ti-clipboard"></i>&nbsp&nbsp Reports
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="<?= base_url()?>research/monthly">Monthly</a>
								<!-- <a class="dropdown-item" href="<?= base_url()?>research/midterm">Midterm</a> -->
								<a class="dropdown-item" href="<?= base_url()?>research/terminal">Terminal</a>
							</div>
						</li>
					<?php endif;?>
				<?php endif;?>
				<li class="d-none <?= $controller.'/'.$method == 'contactus/index' ? 'active' : ''?>" >
					<a class="text-white" href="<?= base_url()?>contactus"><i class="ti-email"></i>&nbsp&nbsp Contact Us</a>
				</li>
			</ul>
		</nav>
	<!-- Page Content  -->
	<div id="content">
			

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">

		<!-- <button type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fas fa-align-left"></i>
			<span>Toggle Sidebar</span>
		</button> -->
		<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fas fa-align-justify"></i>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			
			<ul class="nav navbar-nav ml-auto">
				<?php if($userSession->user_type != 'admin' && $userSession->user_type != 'staff'): ?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle notifBtn" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false">
						<i class="ti-bell"></i><span class="badge badge-danger"><?= count($notif);?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<div class="dropdown-header">Notifications <span class="badge badge-light"><?= count($notif);?></span></div>
						<div class="dropdown-divider"></div>
						<?php if(!empty($notif)):?>
							<?php foreach($notif as $each):?>
							<a class="dropdown-item" href="<?= ($userSession->user_type == 'researcher') ? base_url().'research/researchList' :  base_url().'admin/researchList' ?>">
								<?php if($each->status == 'remarks'):?>
									<?php if($userSession->user_type == 'researcher'): ?>
										<span class="badge badge-warning">For <?= ucwords($each->status)?></span>
									<?php else:?>
										<span class="badge badge-warning">Update <?= ucwords($each->status)?></span>
									<?php endif;?>
								<?php elseif($each->status == 'open'):?>
								<span class="badge badge-warning">Submitted</span>
								<?php elseif($each->status == 'approved'):?>
								<span class="badge badge-success"><?= ucwords($each->status)?></span>
								<?php elseif($each->status == 'disapproved'):?>
								<span class="badge badge-danger"><?= ucwords($each->status)?></span>
								<?php elseif($each->status == 'twg'):?>
								<span class="badge badge-warning">Approved By RND</span>
								<?php endif;?>
							
							| <strong><?= $each->series_number?></strong> - <?= $each->title?> | by: <?= $each->researcher?> <br>
								<span class="dtnotif"><?= date('F d, Y  h:i A' , strtotime($each->date_created)) ?> - <?= strtoupper($each->user_type)?></span> <hr>
							</a> 
							<?php endforeach;?>
						<?php else:?>
							<a class="dropdown-item" href="#">No Notifications</a>
						<?php endif;?>
						<!-- <div class="dropdown-divider"></div>
						<div class="dropdown-header"><a href="#">See All</a></div> -->
					</div>
				</li>
				<?php endif;?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false">
						<!-- Display User Info of user -->
						Welcome! <strong><?= $userInfo[0]->first_name.' '.($userInfo[0]->middle_name != '' ? substr(ucwords($userInfo[0]->middle_name), 0, 1).'.' : '').' '. $userInfo[0]->last_name?></strong>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="#" id="manageAccount"><i class="ti-settings"></i> Manage Accounts</a>
						<a class="dropdown-item" href="#" id="openPass"><i class="ti-key"></i> Change Password</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?=base_url()?>home/logout" id="logout"><i class="ti-power-off"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<form id="changePassForm" method="post">
    <div class="modal fade" id="changePassModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti-key"></i> Change Password</h5>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>Old Password</label>
                            <input type="password" class="form-control" name="oldpass">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="pass">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirmpass">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                    <button type="submit" class="btn btn-default"><i class="ti-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="manageAccountForm" method="post">
    <div class="modal fade" id="manageAccountModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti-user"></i> Manage Account</h5>
                </div>
                <div class="modal-body">
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="username" value="<?= $userSession->username?>" required>
					</div>
					<div class="form-group">
						<label>First Name</label>
						<input type="hidden" class="form-control" name="id" value="<?= $userSession->id?>" >
						<input type="text" class="form-control" name="fname" value="<?= $userInfo[0]->first_name?>" required>
					</div>
					<div class="form-group">
						<label>Middle Name</label>
						<input type="text" class="form-control" name="mname" value="<?= $userInfo[0]->middle_name?>">
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" class="form-control" name="lname" value="<?= $userInfo[0]->last_name?>" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="email" value="<?= $userInfo[0]->email?>" required>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                    <button type="submit" class="btn btn-default"><i class="ti-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        $('#logout').click(function(){
            var r = confirm('Are you sure you want to logout?');
            if(r==true){
                return;
            } else {
                return false;
            }
        })
        $('#openPass').click(function(){
            $('#changePassModal').modal('toggle');
        })
        $('#manageAccount').click(function(){
            $('#manageAccountModal').modal('toggle');
        })
        $('#changePassForm').submit(function(){
            var r = confirm('Are you sure you want to change your password?');
            if(r==true){
                var form = $(this).serialize(); // get form declare to variable form
                var pass = $('#changePassForm').find('input[name=pass]').val(); // get value of pass input to changepassform
                var confirmpass = $('#changePassForm').find('input[name=confirmpass]').val(); // get value of confirmpass input to changepassform
                if(pass == confirmpass){ //if equal return to post
                    $.post(URL+'home/changepass', form) // post to home/changepass
                    .done(function(returnData){
                        if(returnData == 1){
                            alert('Invalid Old Password'); // alert error if old password is invalid
                        } else {
                            alert('Password successfully changed');
                            location.reload();
                        }
                    })
                } else {
                    alert('Password do not match'); // alert error
                }
            } else {
                return false;
            }
            return false;
        })
        $('#manageAccountForm').submit(function(){
            var r = confirm('Are you sure you want to update your account?');
            if(r==true){
                var form = $(this).serialize(); // get form declare to variable form
				$.post(URL+'home/accountupdate', form) // post to home/accountupdate
				.done(function(returnData){
					alert('Account successfully changed');
					location.reload();
				})
            } else {
                return false;
            }
            return false;
		})
		$('.notifBtn').click(function(){
			$.post(URL+'admin/readNotifs')
			.done(function(returnData){
			})
		})
    })
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
			<!-- Statement Condition -->
			