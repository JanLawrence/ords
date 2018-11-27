<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research extends CI_Controller {
	
	public function index()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'researcher'){ // if user type researcher 

				$data['control_num'] = $this->research_model->seriesIDResearch(); // load control num
				$data['classification'] = $this->admin_model->classificationList(); // load classification in admin model
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
				$data['classification'] = $this->admin_model->classificationList(); // load classification in admin model
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
				$data['research'] = $this->research_model->getResearchByResearcher(); // load research per researcher

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
	public function download()
	{
		$this->research_model->download(); // download research controller
	}
	public function dashboard()
	{
		if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'researcher'){ // if user type researcher
				// load view
				$this->load->view('templates/header');
				$this->load->view('research/dashboard');
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
		$query = $this->db->get_where('tbl_research', array('id'=> $_REQUEST['id']));
		$researchData = $query->result();
		echo '<div style="padding: 40px 90px;">';
		echo $researchData[0]->content;
		echo '</div>';
	}
}
