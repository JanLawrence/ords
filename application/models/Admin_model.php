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

        $check = $this->db->get_where('tbl_user', array('username'=>$_POST['username'])); //check if username inputed is exisiting
        if(empty($check->result())){ // if not existing insert user
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
        } else { // if existing print 1
            echo 1; 
        }
    }
    public function editUser(){

        $checkById = $this->db->get_where('tbl_user', array('id' => $_POST['id'])); //get data by user id
        $checkById= $checkById->result();
        $check = $this->db->get_where('tbl_user', array('username' => $_POST['username'])); //check if username inputed is exisiting
        if(!empty($check->result())){ // if existing classification
            if($checkById[0]->username == $_POST['username']){ // if inputed is same in data by user id
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
            } else {
                echo 1;
            }
        } else {
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
    }   
    public function getAllResearh(){
        $researcher = $this->user->id; //this is from the session declared in function __construct

        // get data from joined tables
        $this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rs.status, rs.admin_status, rs.president_status,
            ui.user_id,CONCAT(ui.last_name, ", " ,ui.first_name, " ", ui.middle_name) name, rc.classification
        ')
			->from('tbl_research r')
			->join('tbl_research_status rs', 'rs.research_id = r.id', 'inner')
            ->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
            ->join('tbl_research_classification rc', 'rc.id = r.classification_id', 'left')
			->join('tbl_user_info ui', 'r.created_by = ui.user_id', 'inner');
		$this->db->order_by('r.date_created','DESC');
		$query = $this->db->get();
        return $query->result();
	}
    public function getAllResearhApprovedAdmin(){
		$researcher = $this->user->id;//this is from the session declared in function __construct
        // get data from joined tables
        $this->db->select('r.*, ra.name file_name, ra.type file_type, ra.size file_size, rs.status, rs.admin_status, rs.president_status,
            ui.user_id,CONCAT(ui.last_name, ", " ,ui.first_name, " ", ui.middle_name) name, rc.classification
        ')
			->from('tbl_research r')
			->join('tbl_research_status rs', 'rs.research_id = r.id', 'inner')
			->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
			->join('tbl_research_classification rc', 'rc.id = r.classification_id', 'left')
			->join('tbl_user_info ui', 'r.created_by = ui.user_id', 'inner');
		$this->db->where('rs.admin_status','approved');
		$this->db->order_by('r.date_created','DESC');
		$query = $this->db->get();
        return $query->result();
    }
    public function changeResearchStatus(){
        if($this->user->user_type == 'admin'){

            if($_POST['status'] == 'disapproved'){
                $this->db->set('status', $_POST['status']);
            }
            $this->db->set('admin_status', $_POST['status']);
            $this->db->set('admin_id', $this->user->id);
            $this->db->set('admin_date_modified', date('Y-m-d H:i:s'));
            $this->db->set('modified_by', $this->user->id);
            $this->db->set('date_modified', date('Y-m-d H:i:s'));
            $this->db->where('research_id', $_POST['id']);
            $this->db->update('tbl_research_status');
            
        } else if ($this->user->user_type == 'university president'){
            $this->db->set('status', $_POST['status']);
            $this->db->set('president_status', $_POST['status']);
            $this->db->set('president_id', $this->user->id);
            $this->db->set('president_date_modified', date('Y-m-d H:i:s'));
            $this->db->set('modified_by', $this->user->id);
            $this->db->set('date_modified', date('Y-m-d H:i:s'));
            $this->db->where('research_id', $_POST['id']);
            $this->db->update('tbl_research_status');
        }
    }
    public function classificationList(){
        $query = $this->db->get('tbl_research_classification');
        return $query->result();
    }
    public function saveClassification(){
        $check = $this->db->get_where('tbl_research_classification', array('classification'=>$_POST['classification'])); //check if classification inputed is exisiting
        if(empty($check->result())){ // if not existing insert classification
            //data that will be inserted to tbl_research_classification
            $data = array(
                "classification" => $_POST['classification'],
                "created_by" => $this->user->id,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_research_classification',$data); //insert data to tbl_research_classification
        } else { // if existing print 1
            echo 1; 
        }
    }
    public function editClassification(){

        $checkById = $this->db->get_where('tbl_research_classification', array('id' => $_POST['id'])); //get data by classification id
        $checkById= $checkById->result();
        $check = $this->db->get_where('tbl_research_classification', array('classification' => $_POST['classification'])); //check if classification inputed is exisiting
        if(!empty($check->result())){ // if existing classification
            if($checkById[0]->classification == $_POST['classification']){ // if inputed is same in data by classification id
                //data that will be updated to tbl_research_classification
                $this->db->set('classification', $_POST['classification']);
                $this->db->set('modified_by', $this->user->id);
                $this->db->set('date_modified', date('Y-m-d H:i:s'));
                $this->db->where('id', $_POST['id']);
                $this->db->update('tbl_research_classification'); //update data to tbl_research_classification
            } else {
                echo 1;
            }
        } else {
            //data that will be updated to tbl_research_classification
            $this->db->set('classification', $_POST['classification']);
            $this->db->set('modified_by', $this->user->id);
            $this->db->set('date_modified', date('Y-m-d H:i:s'));
            $this->db->where('id', $_POST['id']);
            $this->db->update('tbl_research_classification'); //update data to tbl_research_classification
        }
    }
    public function addNotes(){
         //data that will be inserted to tbl_research_notes
         $data = array(
            "research_id" => $_POST['id'],
            "user_id" => $this->user->id,
            "notes" => $_POST['notes'],
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_research_notes',$data); //insert data to tbl_research_notes
    }
    public function viewNotesPerResearch($id){

        // get notes data per research from joined tables
        $this->db->select('rn.*, u.user_type')
			->from('tbl_research_notes rn')
			->join('tbl_user u', 'u.id = rn.user_id', 'inner');
		$this->db->where('rn.research_id', $id);
		$this->db->order_by('rn.date_created','DESC');
		$query = $this->db->get();
        return $query->result();
    }
    public function addEvent(){
        //data that will be inserted to tbl_user
        $data = array(
            "event" => $_POST['remarks'],
            "event_date" => $_POST['date'], 
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_calendar_activity',$data); //insert data to tbl_user
        $userid = $this->db->insert_id(); // getting the id of the inserted data
    }
    public function updateEvent(){
        //data that will be inserted to tbl_user
        $data = array(
            $this->db->set('classification', $_POST['remarks']);
            "event" => $_POST['remarks'],
            "event_date" => $_POST['date'], 
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_calendar_activity',$data); //insert data to tbl_user
        $userid = $this->db->insert_id(); // getting the id of the inserted data
    }
    public function getEventByDate(){
        // get event data per date
        $this->db->select('ca.*, SUBSTRING(ca.event,1,20) sub_event')
			->from('tbl_calendar_activity ca');
		$this->db->where('ca.event_date', $_POST['date']);
		$query = $this->db->get();
        echo json_encode($query->result());
    }
}