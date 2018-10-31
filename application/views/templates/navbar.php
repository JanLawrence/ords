<?php 
	$controller = $this->router->fetch_class();
	$method = $this->router->fetch_method();
	$userSession = $this->session->userdata['user'];
	$userInfo = $this->db->get_where('tbl_user_info', array('user_id' => $userSession->id));
	$userInfo = $userInfo->result();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
	<a class="navbar-brand" href="#"><strong>ORDS</strong></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
	 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
				 aria-expanded="false">
					<i class="ti-bell"></i><span class="badge badge-danger">2</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <div class="dropdown-header">Notifications <span class="badge badge-light">2</span></div>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#"><i class="ti-check text-success"></i> Your research <strong>RSH-0001</strong> has been approved!</a>
					<a class="dropdown-item" href="#"><i class="ti-close text-danger"></i> Your research <strong>RSH-0002</strong> has been disapproved!</a>
					<div class="dropdown-divider"></div>
                    <div class="dropdown-header"><a href="#">See All</a></div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
				 aria-expanded="false">
					Welcome! <strong><?= $userInfo[0]->first_name.' '.($userInfo[0]->middle_name != '' ? substr(ucwords($userInfo[0]->middle_name), 0, 1).'.' : '').' '. $userInfo[0]->last_name?></strong>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#"><i class="ti-settings"></i> Manage Accounts</a>
					<a class="dropdown-item" href="#"><i class="ti-key"></i> Change Password</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?=base_url()?>home/logout"><i class="ti-power-off"></i> Logout</a>
				</div>
			</li>
		</ul>
	</div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
			<?php if($userSession->user_type == 'researcher'): ?>
            <ul class="nav nav-tabs nav-tabs-standard">
				<li class="nav-item">
					<a class="nav-link <?= $controller.'/'.$method == 'research/index' ? 'active' : ''?>" href="<?= base_url()?>research"><i class="ti-plus"></i> New Research</a>
                </li>
                <li class="nav-item">
					<a class="nav-link <?= $controller.'/'.$method == 'research/researchList' ? 'active' : ''?>" href="<?= base_url()?>research/researchList"><i class="ti-write"></i> Research List</a>
                </li>
            </ul>
			<?php elseif($userSession->user_type == 'admin' || $userSession->user_type == 'university president'): ?>
            <ul class="nav nav-tabs nav-tabs-standard">
				<?php if($userSession->user_type == 'admin'):?>
					<li class="nav-item">
						<a class="nav-link <?= $controller.'/'.$method == 'admin/addUser' ? 'active' : ''?>" href="<?= base_url()?>admin/addUser"><i class="ti-plus"></i> New User</a>
					</li>
				<?php endif;?>
                <li class="nav-item">
                    <a class="nav-link <?= $controller.'/'.$method == 'admin/researchList' ? 'active' : ''?>" href="<?= base_url()?>admin/researchList"><i class="ti-write"></i> Research List</a>
                </li>
			</ul>
			<?php endif;?>