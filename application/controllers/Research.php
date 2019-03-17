<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research extends CI_Controller {
	
	public function index()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'researcher'){ // if user type researcher 

				$data['control_num'] = $this->research_model->seriesIDResearch(); // load control num
				$data['agendaList'] = $this->admin_model->agendaList(); // load agenda in admin model
				// load view
				$this->load->view('templates/header');
				$this->load->view('research/research', $data);
				$this->load->view('templates/footer');
		     
			} else { 
				show_404(); // show 404 error page
			}
		} else {
			show_404(); // show 404 error page
		}
	}
	public function researchEdit()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'researcher'){ // if user type researcher
				$data['research'] = $this->research_model->getResearch($_REQUEST['id']); // load research per edit id
				$data['control_num'] = $this->research_model->seriesIDResearch(); // load control num
				$data['agendaList'] = $this->admin_model->agendaList(); // load agenda in admin model
				// $data['classification'] = $this->admin_model->classificationList(); // load classification in admin model
				// load view
				$this->load->view('templates/header');
				$this->load->view('research/research-edit', $data);
				$this->load->view('templates/footer');
			} else { 
				show_404(); // show 404 error page
			}
		} else {
			show_404(); // show 404 error page
		}
	}
	public function upload()
	{
		$this->research_model->upload();  // upload research controller
	}
	public function add()
	{
		$this->research_model->add();  // add research controller
	}
	public function edit()
	{
		$this->research_model->edit();  // edit research controller
	}
	public function researchList()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
			if($this->session->userdata['user']->user_type == 'researcher'){ // if user type researcher
				$from = isset($_GET['from']) && $_GET['from'] != '' ? $_GET['from'] : date('Y-m-d');
				$to = isset($_GET['to']) &&  $_GET['from'] != '' ? $_GET['to'] : date('Y-m-d');
				$data['research'] = $this->research_model->getResearchByResearcher($from, $to); // load research per researcher

				// load view
				$this->load->view('templates/header');
				$this->load->view('research/research-list', $data);
				$this->load->view('templates/footer');
			} else { 
				show_404(); // show 404 error page
			}
		} else {
			show_404(); // show 404 error page
		}
	}
	public function monthly()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
			$data['research'] = $this->research_model->getResearchByResearcherMonthly(); // load research per researcher
			// load view
			$this->load->view('templates/header');
			$this->load->view('research/reports/monthly', $data);
			$this->load->view('templates/footer');

		} else {
			show_404(); // show 404 error page
		}
	}
	public function midterm()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
			$data['research'] = $this->research_model->getResearchByResearcherMidterm(); // load research per researcher
			// load view
			$this->load->view('templates/header');
			$this->load->view('research/reports/midterm', $data);
			$this->load->view('templates/footer');

		} else {
			show_404(); // show 404 error page
		}
	}
	public function terminal()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
			$from = isset($_GET['from']) && $_GET['from'] != '' ? $_GET['from'] : date('Y-m-d');
			$to = isset($_GET['to']) && $_GET['from'] != '' ? $_GET['to'] : date('Y-m-d');
			$data['research'] = $this->research_model->getResearchByResearcherTerminal($from, $to); // load research per researcher
			// load view
			$this->load->view('templates/header');
			$this->load->view('research/reports/terminal', $data);
			$this->load->view('templates/footer');

		} else {
			show_404(); // show 404 error page
		}
	}
	public function download()
	{
		$this->research_model->download(); // download research controller
	}
	public function addMonthly()
	{
		$this->research_model->addMonthly(); // download research controller
	}
	public function researchDurNotifTerminal()
	{
		$user = $this->session->userdata['user'];
		$sql = "SELECT r.series_number, r.title, rd.duration_date
				FROM tbl_research r
				INNER JOIN 
					tbl_user_info ui
				ON r.created_by = ui.user_id
				INNER JOIN
					tbl_research_duration rd
				ON rd.research_id = r.id
				WHERE ui.user_id = $user->id
				AND rd.duration_date = '".date('Y-m-d')."'";
		$query = $this->db->query($sql);
        echo json_encode($query->result());
	}
	public function researchDurNotifMonthly()
	{
		$date = date("Y-m-d", strtotime("+1 month"));
		$user = $this->session->userdata['user'];
		$sql = "SELECT r.series_number, r.title, rd.duration_date
				FROM tbl_research r
				INNER JOIN 
					tbl_user_info ui
				ON r.created_by = ui.user_id
				INNER JOIN
					tbl_research_duration rd
				ON rd.research_id = r.id
				WHERE ui.user_id = $user->id
				AND rd.duration_date = '".$date."'";
		$query = $this->db->query($sql);
        echo json_encode($query->result());
	}
	public function dashboard()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'researcher'){ // if user type researcher
				// load view
				$data['submitted'] = $this->admin_model->submittedResearch();
				$data['forapproval'] = $this->admin_model->forApprovalResearch();
				$data['attachment'] = $this->admin_model->attachmentResearch();
				$this->load->view('templates/header');
				$this->load->view('research/dashboard', $data);
				$this->load->view('templates/footer');
			} else { 
				show_404(); // show 404 error page
			}
		} else {
			show_404(); // show 404 error page
		}
	}
	public function showContent() // show content of research controller
	{
		if(!empty($this->session->userdata['user'])){ // if has session
			$data['research'] = $this->research_model->getResearch($_REQUEST['id']); // load research per edit id
			$data['agendaList'] = $this->admin_model->agendaList(); // load agenda in admin model
			// $this->load->view('templates/header');
			$this->load->view('research/research-show', $data);
			// $this->load->view('templates/footer');
		} else {
			show_404(); // show 404 error page
		}
	}
}
