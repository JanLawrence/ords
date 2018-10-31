<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{
    public function __construct(){
        $this->user = isset($this->session->userdata['user']) ? $this->session->userdata['user'] : ''; //get session
    }
    public function userList(){
        // get data from tbl_user_info and tbl_user
        $this->db->select("ui.user_id,CONCAT(ui.last_name, ', ' ,ui.first_name, ' ', ui.middle_name) name, u.user_type,
            ui.first_name f_name,ui.last_name l_name, ui.middle_name m_name , ui.email, ui.position, u.username, u.password
        ")
        ->from("tbl_user_info ui")
        ->join("tbl_user u","ON u.id = ui.user_id","inner");
        $this->db->order_by("ui.last_name");
        $query = $this->db->get();
    
        foreach($query->result() as $each){
            $each->password = $this->encryptpass->pass_crypt($each->password, 'd');
        }

        return $query->result();
    }
    public function saveUser(){
        //data that will be inserted to tbl_user
        $data = array(
            "username" => $_POST['username'],
            "password" => $this->encryptpass->pass_crypt($_POST['password']),
            "user_type" => $_POST['usertype'],
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user',$data); //insert data to tbl_user
        $userid = $this->db->insert_id(); // getting the id of the inserted data
        
        //data that will be inserted to tbl_user_info
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
    public function editUser(){

        //data that will be updated to tbl_user
        $this->db->set('username', $_POST['username']);
        $this->db->set('password', $this->encryptpass->pass_crypt($_POST['password']));
        $this->db->set('user_type', $_POST['usertype']);
        $this->db->set('modified_by', $this->user->id);
        $this->db->set('date_modified', date('Y-m-d H:i:s'));
        $this->db->where('id', $_POST['id']);
        $this->db->update('tbl_user');
        
        //data that will be updated to tbl_user_info
        $this->db->set('first_name', $_POST['fname']);
        $this->db->set('middle_name', $_POST['mname']);
        $this->db->set('last_name', $_POST['lname']);
        $this->db->set('email', $_POST['email']);
        $this->db->set('position', $_POST['position']);
        $this->db->set('modified_by', $this->user->id);
        $this->db->set('date_modified', date('Y-m-d H:i:s'));
        $this->db->where('user_id', $_POST['id']);
        $this->db->update('tbl_user_info');
    }
    public function getAllResearh(){
        $researcher = $this->user->id; //this is from the session declared in function __construct

        // get data from joined tables
        $this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rs.status, rs.admin_status, rs.president_status,
            ui.user_id,CONCAT(ui.last_name, ", " ,ui.first_name, " ", ui.middle_name) name
        ')
			->from('tbl_research r')
			->join('tbl_research_status rs', 'rs.research_id = r.id', 'inner')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
			->join('tbl_user_info ui', 'r.created_by = ui.user_id', 'inner');
		$this->db->order_by('r.date_created','DESC');
		$query = $this->db->get();
        return $query->result();
	}
    public function getAllResearhApprovedAdmin(){
		$researcher = $this->user->id;//this is from the session declared in function __construct
        // get data from joined tables
        $this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rs.status, rs.admin_status, rs.president_status,
            ui.user_id,CONCAT(ui.last_name, ", " ,ui.first_name, " ", ui.middle_name) name
        ')
			->from('tbl_research r')
			->join('tbl_research_status rs', 'rs.research_id = r.id', 'inner')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
			->join('tbl_user_info ui', 'r.created_by = ui.user_id', 'inner');
		$this->db->where('rs.admin_status','approved');
		$this->db->order_by('r.date_created','DESC');
		$query = $this->db->get();
        return $query->result();
	}
}