<?php if($userSession->user_type == 'researcher'): ?>
				<li class="nav-item">
					<a class="nav-link <?= $controller.'/'.$method == 'research/dashboard' ? 'active' : ''?>" href="<?= base_url()?>research/dashboard"><i class="ti-dashboard"></i> Dashboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= $controller.'/'.$method == 'research/index' ? 'active' : ''?>" href="<?= base_url()?>research"><i class="ti-plus"></i> New Research</a>
                </li>
                <li class="nav-item">
					<a class="nav-link <?= $controller.'/'.$method == 'research/researchList' ? 'active' : ''?>" href="<?= base_url()?>research/researchList"><i class="ti-write"></i> Research List</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false">
						<i class="ti-clipboard"></i> Reports
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?= base_url()?>research/monthly">Monthly</a>
						<!-- <a class="dropdown-item" href="<?= base_url()?>research/midterm">Midterm</a> -->
						<a class="dropdown-item" href="<?= base_url()?>research/terminal">Terminal</a>
					</div>
				</li>
			<?php elseif($userSession->user_type == 'admin' || $userSession->user_type == 'pres' || $userSession->user_type == 'rde' || $userSession->user_type == 'twg' || $userSession->user_type == 'rnd'): ?>
				<?php if($userSession->user_type == 'admin'):?>
					<li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/addUser' ? 'active' : ''?>" href="<?= base_url()?>admin/addUser"><i class="ti-user"></i> User List</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/calendar' ? 'active' : ''?>" href="<?= base_url()?>admin/calendar"><i class="ti-calendar"></i> Calendar</a>
					</li>
					<!-- <li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/classification' ? 'active' : ''?>" href="<?= base_url()?>admin/classification"><i class="ti-layers-alt"></i> Classification List</a>
					</li> -->
					<li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/department' ? 'active' : ''?>" href="<?= base_url()?>admin/department"><i class="ti-layers-alt"></i> Department</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/specialization' ? 'active' : ''?>" href="<?= base_url()?>admin/specialization"><i class="ti-layers-alt"></i> Specialization</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/agenda' ? 'active' : ''?>" href="<?= base_url()?>admin/agenda"><i class="ti-layers-alt"></i> Agenda</a>
					</li>
				<?php endif;?>
				<?php if($userSession->user_type == 'rnd' || $userSession->user_type == 'pres' || $userSession->user_type == 'rde' || $userSession->user_type == 'twg'):?>
					<li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/dashboard' ? 'active' : ''?>" href="<?= base_url()?>admin/dashboard"><i class="ti-dashboard"></i> Dashboard</a>
					</li>
					<li class="nav-item" >
						<a class="nav-link <?= $controller.'/'.$method == 'admin/researchList' ? 'active' : ''?>" href="<?= base_url()?>admin/researchList"><i class="ti-write"></i> Research List</a>
					</li>
				<?php endif;?>
			<?php endif;?>
			<li class="nav-item d-none" >
				<a class="nav-link <?= $controller.'/'.$method == 'contactus/index' ? 'active' : ''?>" href="<?= base_url()?>contactus"><i class="ti-email"></i> Contact Us</a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto nav-tabs-standard">
			<?php if($userSession->user_type != 'admin'): ?>
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
            
            
<nav class="navbar navbar-expand-lg navbar-light bg-white">
	<a class="navbar-brand ml-2" href="#"><strong>ORDS</strong></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
	 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto nav-tabs-standard ml-3">

		
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
</nav>