<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research extends CI_Controller {
	
	public function index()
	{
		$data['control_num'] = $this->research_model->seriesIDResearch();
		$this->load->view('templates/header');
		$this->load->view('research/research', $data);
		$this->load->view('templates/footer');
	}
	public function researchEdit()
	{
		$data['research'] = $this->research_model->getResearch($_REQUEST['id']);
		$data['control_num'] = $this->research_model->seriesIDResearch();
		$this->load->view('templates/header');
		$this->load->view('research/research-edit', $data);
		$this->load->view('templates/footer');
	}
	public function add()
	{
		$this->research_model->add();
	}
	public function edit()
	{
		$this->research_model->edit();
	}
	public function researchList()
	{
		$data['research'] = $this->research_model->getResearchByResearcher();
		$this->load->view('templates/header');
		$this->load->view('research/research-list', $data);
		$this->load->view('templates/footer');
	}
	public function download()
	{
		$this->research_model->download();
	}
	public function showContent()
	{
		$query = $this->db->get_where('tbl_research', array('id'=> $_REQUEST['id']));
		$researchData = $query->result();
		echo '<div style="padding: 40px 90px;">';
		echo $researchData[0]->content;
		echo '</div>';
	}
}
