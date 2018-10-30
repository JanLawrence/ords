<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{
    public function __construct(){
        $this->user = isset($this->session->userdata['user']) ? $this->session->userdata['user'] : ''; //get session
    }
    public function saveUser(){
        echo 'asdasd';
        exit;
    }
}