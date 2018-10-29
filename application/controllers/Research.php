<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research extends CI_Controller {
	
	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('research/research');
		$this->load->view('templates/footer');
	}
	public function add()
	{
		$this->research_model->add();
	}
	public function researchList()
	{
		$this->load->view('templates/header');
		$this->load->view('research/research-list');
		$this->load->view('templates/footer');
	}
}
