<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends CI_Controller {

    public function index()
	{
        if(!empty($this->session->userdata['user'])){ // if empty session
            $this->load->view('templates/header'); 
            $this->load->view('contactus');
            $this->load->view('templates/footer');
        }
    }
}