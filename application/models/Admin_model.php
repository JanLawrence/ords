<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{
    public function __construct(){
        $this->user = isset($this->session->userdata['user']) ? $this->session->userdata['user'] : ''; //get session
    }
    public function userList(){
        $this->db->select("ui.user_id,CONCAT(ui.last_name, ', ' ,ui.first_name, ' ', ui.middle_name) name, u.user_type")
        ->from("tbl_user_info ui")
        ->join("tbl_user u","ON u.id = ui.user_id","inner");
        $this->db->order_by("ui.last_name");
        $query = $this->db->get();
        return $query->result();
    }
    public function saveUser(){
        //data that will be inserted to tbl_subject
        $data = array(
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "user_type" => $_POST['usertype'],
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user',$data); //insert data to tbl_user
        $userid = $this->db->insert_id(); // getting the id of the inserted data

        $data = array(
            "user_id" => $userid,
            "first_name" => $_POST['fname'],
            "middle_name" => $_POST['mname'],
            "last_name" => $_POST['lname'],
            "email" => $_POST['email'],
            "position" => $_POST['position'],
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_info',$data); //insert data to tbl_user_info
    }
}