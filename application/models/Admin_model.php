<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{
    public function __construct(){
        $this->user = isset($this->session->userdata['user']) ? $this->session->userdata['user'] : ''; //get session
    }
    public function userList(){
        // get data from tbl_user_info and tbl_user
        $this->db->select("ui.user_id,CONCAT(ui.last_name, ', ' ,ui.first_name, ' ', ui.middle_name) name, u.user_type,
            ui.first_name f_name,ui.last_name l_name, ui.middle_name m_name , ui.email, ui.position, u.username, u.password, ui.department_id, ui.specialization_id, 
            IF(s.specialization IS NOT NULL, s.specialization, '') specialization
        ")
        ->from("tbl_user_info ui")
        ->join("tbl_user u","ON u.id = ui.user_id","inner")
        ->join("tbl_specialization s","ON s.id = ui.specialization_id","left");
        $this->db->where("u.status", "yes");
        $this->db->order_by("ui.last_name");
        $query = $this->db->get();
    
        foreach($query->result() as $each){
            $each->password = $this->encryptpass->pass_crypt($each->password, 'd');
        }

        return $query->result();
    }
    public function saveUser(){
        $dept = isset($_POST['department']) && $_POST['usertype'] === 'researcher' ? $_POST['department'] : 0;
        $spec = isset($_POST['specialization']) && ($_POST['usertype'] === 'researcher' || $_POST['usertype'] === 'twg') ? $_POST['specialization'] : 0;

        $check = $this->db->get_where('tbl_user', array('username'=>$_POST['username'])); //check if username inputed is exisiting
        if(empty($check->result())){ // if not existing insert user
            //data that will be inserted to tbl_user
            $data = array(
                "username" => $_POST['username'],
                "password" => $this->encryptpass->pass_crypt($_POST['password']),
                "user_type" => $_POST['usertype'],
                "status" => 'yes',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
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
                "department_id" => $dept,
                "specialization_id" => $spec,
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_info',$data); //insert data to tbl_user_info

            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Added User',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        } else { // if existing print 1
            echo 1; 
        }
    }
    public function editUser(){
        $dept = isset($_POST['department']) && $_POST['usertype'] === 'researcher' ? $_POST['department'] : 0;
        $spec = isset($_POST['specialization']) && ($_POST['usertype'] === 'researcher' || $_POST['usertype'] === 'twg') ? $_POST['specialization'] : 0;
        
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
                $this->db->set('department_id', $dept);
                $this->db->set('specialization_id', $spec);
                $this->db->set('modified_by', $this->user->id);
                $this->db->set('date_modified', date('Y-m-d H:i:s'));
                $this->db->where('user_id', $_POST['id']);
                $this->db->update('tbl_user_info');

                $data = array(
                    "user_id" => $this->user->id,
                    "username" => '',
                    "transaction" => 'Updated User',
                    "created_by" => !empty($this->user) ? $this->user->id : 0,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
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

            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Updated User',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        }
    }   
    public function deleteUser(){
        $this->db->set('status', 'no');
        $this->db->set('modified_by', $this->user->id);
        $this->db->set('date_modified', date('Y-m-d H:i:s'));
        $this->db->where('id', $_POST['id']);
        $this->db->update('tbl_user');
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
    public function getAllResearhAdmin(){
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
    public function getAllResearhAdmin2(){
		$researcher = $this->user->id;//this is from the session declared in function __construct
        // get data from joined tables
        $this->db->select('r.*, rp.id research_progress_id, rp.levels,rp.`status`, ra.name file_name, ra.type file_type, ra.size file_size,
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number , rd.duration_date, d.department,  group_concat(agenda.agenda separator ", ") agenda')
        ->from('tbl_research_progress rp')
        ->join('tbl_research r', 'r.id = rp.research_id', 'left')
        ->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
        ->join('tbl_department d', 'd.id = ui.department_id', 'left')
        ->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
        ->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left')
        ->join('tbl_research_agenda research_agenda', 'research_agenda.research_id = r.id', 'left')
        ->join('tbl_priority_agenda agenda', 'research_agenda.agenda_id = agenda.id', 'left');
        $this->db->order_by('r.date_created','DESC');
        $this->db->group_by('r.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllResearhTwg(){
        $user = $this->user->id;//this is from the session declared in function __construct
        $getInfo = $this->db->get_where('tbl_user_info', array('user_id' => $user));
        $getInfo = $getInfo->result();
        // get data from joined tables
        $this->db->select('r.*, rp.id research_progress_id, rp.levels,rp.`status`, ra.name file_name, ra.type file_type, ra.size file_size,
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, rd.duration_date, d.department, group_concat(agenda.agenda separator ", ") agenda')
        ->from('tbl_research_progress rp')
        ->join('tbl_research r', 'r.id = rp.research_id', 'left')
        ->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
        ->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
        ->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left')
        ->join('tbl_research_agenda research_agenda', 'research_agenda.research_id = r.id', 'left')
        ->join('tbl_priority_agenda agenda', 'research_agenda.agenda_id = agenda.id', 'left');
        $this->db->where('rp.status','admin_approved');
        $this->db->where('ui.specialization_id', $getInfo[0]->specialization_id);
        $this->db->or_where('rp.status','twg_approved');
        $this->db->or_where('rp.status','twg_disapproved');
        $this->db->or_where('rp.status','twg_remarks');
        $this->db->order_by('r.date_created','DESC');
        $this->db->group_by('r.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllResearhRde(){
		$researcher = $this->user->id;//this is from the session declared in function __construct
        // get data from joined tables
        $this->db->select('r.*, rp.id research_progress_id, rp.levels,rp.`status`, ra.name file_name, ra.type file_type, ra.size file_size,
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, rd.duration_date, d.department, group_concat(agenda.agenda separator ", ") agenda')
        ->from('tbl_research_progress rp')
        ->join('tbl_research r', 'r.id = rp.research_id', 'left')
        ->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
        ->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
        ->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left')
        ->join('tbl_research_agenda research_agenda', 'research_agenda.research_id = r.id', 'left')
        ->join('tbl_priority_agenda agenda', 'research_agenda.agenda_id = agenda.id', 'left');
        $this->db->where('rp.status','admin_approved');
        $this->db->or_where('rp.status','twg_approved');
        $this->db->or_where('rp.status','twg_disapproved');
        $this->db->or_where('rp.status','twg_remarks');
        $this->db->or_where('rp.status','rde_approved');
        $this->db->or_where('rp.status','rde_disapproved');
        $this->db->or_where('rp.status','rde_remarks');
        $this->db->order_by('r.date_created','DESC');
        $this->db->group_by('r.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllResearhPres(){
		$researcher = $this->user->id;//this is from the session declared in function __construct
        // get data from joined tables
        $this->db->select('r.*, rp.id research_progress_id, rp.levels,rp.`status`, ra.name file_name, ra.type file_type, ra.size file_size,
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, rd.duration_date, d.department, group_concat(agenda.agenda separator ", ") agenda')
        ->from('tbl_research_progress rp')
        ->join('tbl_research r', 'r.id = rp.research_id', 'left')
        ->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
        ->join('tbl_research_attachment ra', 'ra.research_id = r.id', 'left')
        ->join('tbl_research_duration rd', 'rd.research_id = r.id', 'left')
        ->join('tbl_research_agenda research_agenda', 'research_agenda.research_id = r.id', 'left')
        ->join('tbl_priority_agenda agenda', 'research_agenda.agenda_id = agenda.id', 'left');
        $this->db->where('rp.status','rde_approved');
        $this->db->or_where('rp.status','pres_approved');
        $this->db->or_where('rp.status','pres_disapproved');
        $this->db->or_where('rp.status','pres_remarks');
        $this->db->order_by('r.date_created','DESC');
        $this->db->group_by('r.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function changeResearchStatus(){

        $this->db->set('status', $this->user->user_type.'_'.$_POST['status']);
        $this->db->where('id', $_POST['progress_id']);
        $this->db->update('tbl_research_progress');

        $data = array(
            'research_progress_id' => $_POST['progress_id'],
            'notif' => 'unread',
            'notif_type' => $_POST['status'],
            'notif_from' =>  $this->user->user_type,
            'notif_from_id' => '',
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_researcher_notif',$data); //insert data to tbl_researcher_notif
        if($_POST['status'] == 'approved'){
            if($this->user->user_type == 'rnd'){
                $data = array(
                    'research_progress_id' => $_POST['progress_id'],
                    'notif' => 'unread',
                    'status' => $_POST['status'],
                    "created_by" => $this->user->id,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_twg_notif',$data); //insert data to tbl_twg_notif
                if($_POST['status'] == 'approved'){
                    $data = array(
                        'research_progress_id' => $_POST['progress_id'],
                        'notif' => 'unread',
                        'status' => 'twg',
                        "created_by" => $this->user->id,
                        "date_created" => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('tbl_rde_notif',$data); //insert data to tbl_rde_notif
                }
            } else if($this->user->user_type == 'twg'){
                $data = array(
                    'research_progress_id' => $_POST['progress_id'],
                    'notif' => 'unread',
                    'status' => $_POST['status'],
                    "created_by" => $this->user->id,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_rde_notif',$data); //insert data to tbl_rde_notif
            } else if($this->user->user_type == 'rde'){
                $data = array(
                    'research_progress_id' => $_POST['progress_id'],
                    'notif' => 'unread',
                    'status' => $_POST['status'],
                    "created_by" => $this->user->id,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_pres_notif',$data); //insert data to tbl_pres_notif
            }
            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Approved Research',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        } else {
            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Disapproved Research',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        }
    }
    public function classificationList(){
        $query = $this->db->get('tbl_research_classification');
        return $query->result();
    }
    public function agendaList(){
        $query = $this->db->get('tbl_priority_agenda');
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

            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Added Classification',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
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

                $data = array(
                    "user_id" => $this->user->id,
                    "username" => '',
                    "transaction" => 'Updated Classfication',
                    "created_by" => !empty($this->user) ? $this->user->id : 0,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
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

            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Updated Classfication',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        }
    }
    public function deptList(){
        $query = $this->db->get('tbl_department');
        return $query->result();
    }
    public function saveDept(){
        $check = $this->db->get_where('tbl_department', array('department'=>$_POST['department'])); //check if department inputed is exisiting
        if(empty($check->result())){ // if not existing insert department
            //data that will be inserted to tbl_department
            $data = array(
                "department" => $_POST['department'],
                "created_by" => $this->user->id,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_department',$data); //insert data to tbl_department

            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Added Department',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        } else { // if existing print 1
            echo 1; 
        }
    }
    public function editDept(){

        $checkById = $this->db->get_where('tbl_department', array('id' => $_POST['id'])); //get data by department id
        $checkById= $checkById->result();
        $check = $this->db->get_where('tbl_department', array('department' => $_POST['department'])); //check if department inputed is exisiting
        if(!empty($check->result())){ // if existing department
            if($checkById[0]->department == $_POST['department']){ // if inputed is same in data by department id
                //data that will be updated to tbl_department
                $this->db->set('department', $_POST['department']);
                $this->db->set('modified_by', $this->user->id);
                $this->db->set('date_modified', date('Y-m-d H:i:s'));
                $this->db->where('id', $_POST['id']);
                $this->db->update('tbl_department'); //update data to tbl_department
                $data = array(
                    "user_id" => $this->user->id,
                    "username" => '',
                    "transaction" => 'Updated Department',
                    "created_by" => !empty($this->user) ? $this->user->id : 0,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
            } else {
                echo 1;
            }
        } else {
            //data that will be updated to tbl_department
            $this->db->set('department', $_POST['department']);
            $this->db->set('modified_by', $this->user->id);
            $this->db->set('date_modified', date('Y-m-d H:i:s'));
            $this->db->where('id', $_POST['id']);
            $this->db->update('tbl_department'); //update data to tbl_department
            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Updated Department',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        }
    }
    public function saveAgenda(){
        $check = $this->db->get_where('tbl_priority_agenda', array('agenda'=>$_POST['agenda'])); //check if agenda inputed is exisiting
        if(empty($check->result())){ // if not existing insert agenda
            //data that will be inserted to tbl_priority_agenda
            $data = array(
                "agenda" => $_POST['agenda'],
                "created_by" => $this->user->id,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_priority_agenda',$data); //insert data to tbl_priority_agenda

            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Added Agenda',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        } else { // if existing print 1
            echo 1; 
        }
    }
    public function editAgenda(){

        $checkById = $this->db->get_where('tbl_priority_agenda', array('id' => $_POST['id'])); //get data by agenda id
        $checkById= $checkById->result();
        $check = $this->db->get_where('tbl_priority_agenda', array('agenda' => $_POST['agenda'])); //check if agenda inputed is exisiting
        if(!empty($check->result())){ // if existing agenda
            if($checkById[0]->agenda == $_POST['agenda']){ // if inputed is same in data by agenda id
                //data that will be updated to tbl_priority_agenda
                $this->db->set('agenda', $_POST['agenda']);
                $this->db->set('modified_by', $this->user->id);
                $this->db->set('date_modified', date('Y-m-d H:i:s'));
                $this->db->where('id', $_POST['id']);
                $this->db->update('tbl_priority_agenda'); //update data to tbl_priority_agenda
                $data = array(
                    "user_id" => $this->user->id,
                    "username" => '',
                    "transaction" => 'Updated Agenda',
                    "created_by" => !empty($this->user) ? $this->user->id : 0,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
            } else {
                echo 1;
            }
        } else {
            //data that will be updated to tbl_priority_agenda
            $this->db->set('agenda', $_POST['agenda']);
            $this->db->set('modified_by', $this->user->id);
            $this->db->set('date_modified', date('Y-m-d H:i:s'));
            $this->db->where('id', $_POST['id']);
            $this->db->update('tbl_priority_agenda'); //update data to tbl_priority_agenda
            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Updated Agenda',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        }
    }
    public function specializationList(){
        $query = $this->db->get('tbl_specialization');
        return $query->result();
    }
    public function saveSpecialization(){
        $check = $this->db->get_where('tbl_specialization', array('specialization'=>$_POST['specialization'])); //check if specialization inputed is exisiting
        if(empty($check->result())){ // if not existing insert specialization
            //data that will be inserted to tbl_specialization
            $data = array(
                "specialization" => $_POST['specialization'],
                "created_by" => $this->user->id,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_specialization',$data); //insert data to tbl_specialization
            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Added Specialization',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        } else { // if existing print 1
            echo 1; 
        }
    }
    public function editSpecialization(){
        $checkById = $this->db->get_where('tbl_specialization', array('id' => $_POST['id'])); //get data by specialization id
        $checkById= $checkById->result();
        $check = $this->db->get_where('tbl_specialization', array('specialization' => $_POST['specialization'])); //check if specialization inputed is exisiting
        if(!empty($check->result())){ // if existing specialization
            if($checkById[0]->specialization == $_POST['specialization']){ // if inputed is same in data by specialization id
                //data that will be updated to tbl_specialization
                $this->db->set('specialization', $_POST['specialization']);
                $this->db->set('modified_by', $this->user->id);
                $this->db->set('date_modified', date('Y-m-d H:i:s'));
                $this->db->where('id', $_POST['id']);
                $this->db->update('tbl_specialization'); //update data to tbl_specialization
                $data = array(
                    "user_id" => $this->user->id,
                    "username" => '',
                    "transaction" => 'Updated Specialization',
                    "created_by" => !empty($this->user) ? $this->user->id : 0,
                    "date_created" => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
            } else {
                echo 1;
            }
        } else {
            //data that will be updated to tbl_specialization
            $this->db->set('specialization', $_POST['specialization']);
            $this->db->set('modified_by', $this->user->id);
            $this->db->set('date_modified', date('Y-m-d H:i:s'));
            $this->db->where('id', $_POST['id']);
            $this->db->update('tbl_specialization'); //update data to tbl_specialization
            $data = array(
                "user_id" => $this->user->id,
                "username" => '',
                "transaction" => 'Updated Specialization',
                "created_by" => !empty($this->user) ? $this->user->id : 0,
                "date_created" => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
        }
    }
    public function setDuration(){
        //data that will be inserted to tbl_research_notes
       $data = array(
           "research_id" => $_POST['id'],
           "duration_date" => $_POST['date'],
           "created_by" => $this->user->id,
           "date_created" => date('Y-m-d H:i:s')
       );
       $this->db->insert('tbl_research_duration',$data); //insert data to tbl_research_notes

        $data = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Updated Research Duration',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
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
        
        $data = array(
            'research_progress_id' => $_POST['progress_id'],
            'notif' => 'unread',
            'notif_type' => 'remarks',
            'notif_from' =>  $this->user->user_type,
            'notif_from_id' => '',
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_researcher_notif',$data); //insert data to tbl_researcher_notif

        $query = $this->db->get_where('tbl_research_progress', array('id' => $_POST['progress_id']));
        $progress = $query->result();

        $this->db->set('levels', $progress[0]->levels++);
        $this->db->set('status', $this->user->user_type.'_remarks');
        $this->db->where('id', $_POST['progress_id']);
        $this->db->update('tbl_research_progress');

        $data = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Added Notes Research',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
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
        //data that will be inserted to tbl_calendar_activity
        $data = array(
            "event" => $_POST['remarks'],
            "event_date" => $_POST['date'], 
            "created_by" => $this->user->id,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_calendar_activity',$data); //insert data to tbl_user
        $userid = $this->db->insert_id(); // getting the id of the inserted data
        $data = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Added Event',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
    }
    public function deleteEvent(){
        $this->db->delete('tbl_calendar_activity', array('id' => $_POST['id'])); 
    }
    public function updateEvent(){
        //data that will be inserted to tbl_calendar_activity
        $this->db->set('event', $_POST['remarks']);
        $this->db->set('event_date', $_POST['date']);
        $this->db->set('modified_by', $this->user->id);
        $this->db->set('date_modified', date('Y-m-d H:i:s'));
        $this->db->where('id', $_POST['id']);
        $this->db->update('tbl_calendar_activity');
        $data = array(
            "user_id" => $this->user->id,
            "username" => '',
            "transaction" => 'Updated Event',
            "created_by" => !empty($this->user) ? $this->user->id : 0,
            "date_created" => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
    }
    public function getEventByDate(){
        // get event data per date
        $this->db->select('ca.*, SUBSTRING(ca.event,1,20) sub_event')
			->from('tbl_calendar_activity ca');
		$this->db->where('ca.event_date', $_POST['date']);
		$query = $this->db->get();
        echo json_encode($query->result());
    }
    public function notifications(){
        $user = $this->user->id;//this is from the session declared in function __construct
        if($this->user->user_type == 'rnd'){

            // get data from joined tables
            $this->db->select('an.*, rp.levels, r.title, r.details, 
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, u.user_type')
			->from('tbl_admin_notif an')
			->join('tbl_research_progress rp', 'rp.id = an.research_progress_id', 'left')
			->join('tbl_research r', 'r.id = rp.research_id', 'left')
			->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
			->join('tbl_user u', 'u.id = ui.user_id', 'left');
            $this->db->where('an.notif','unread');
            $this->db->order_by('an.id','DESC');
            $this->db->group_by('r.id');
            $query = $this->db->get();
            return $query->result();
        } else if($this->user->user_type == 'researcher') {
            $this->db->select('rn.*, rn.notif_type status, rp.levels, r.title, r.details, 
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, u.user_type')
			->from('tbl_researcher_notif rn')
			->join('tbl_research_progress rp', 'rp.id = rn.research_progress_id', 'left')
			->join('tbl_research r', 'r.id = rp.research_id', 'left')
            ->join('tbl_user_info ui', 'ui.user_id = rn.created_by', 'left')
            ->join('tbl_user u', 'u.id = ui.user_id', 'left');
            $this->db->where('rn.notif','unread');
            // $this->db->where('u.id',$user);
            $this->db->order_by('rn.id','DESC');
            $this->db->group_by('r.id');
            $query = $this->db->get();
            return $query->result();
        } else if($this->user->user_type == 'twg'){
            $getInfo = $this->db->get_where('tbl_user_info', array('user_id' => $user));
            $getInfo = $getInfo->result();
            // get data from joined tables
            $this->db->select('an.*, rp.levels, r.title, r.details, 
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, u.user_type')
			->from('tbl_twg_notif an')
			->join('tbl_research_progress rp', 'rp.id = an.research_progress_id', 'left')
			->join('tbl_research r', 'r.id = rp.research_id', 'left')
            ->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
            ->join('tbl_user u', 'u.id = ui.user_id', 'left');
            $this->db->where('an.notif','unread');
            $this->db->where('ui.specialization_id', $getInfo[0]->specialization_id);
            $this->db->order_by('an.id','DESC');
            $this->db->group_by('r.id');
            $query = $this->db->get();
            return $query->result();
        } else if($this->user->user_type == 'rde'){

            // get data from joined tables
            $this->db->select('an.*, rp.levels, r.title, r.details, 
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, u.user_type')
			->from('tbl_rde_notif an')
			->join('tbl_research_progress rp', 'rp.id = an.research_progress_id', 'left')
			->join('tbl_research r', 'r.id = rp.research_id', 'left')
            ->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
            ->join('tbl_user u', 'u.id = ui.user_id', 'left');
            $this->db->where('an.notif','unread');
            $this->db->order_by('an.id','DESC');
            $this->db->group_by('r.id');
            $query = $this->db->get();
            return $query->result();
        } else if($this->user->user_type == 'pres'){

            // get data from joined tables
            $this->db->select('an.*, rp.levels, r.title, r.details, 
            CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) researcher, r.series_number, u.user_type')
			->from('tbl_pres_notif an')
			->join('tbl_research_progress rp', 'rp.id = an.research_progress_id', 'left')
			->join('tbl_research r', 'r.id = rp.research_id', 'left')
            ->join('tbl_user_info ui', 'ui.user_id = r.created_by', 'left')
            ->join('tbl_user u', 'u.id = ui.user_id', 'left');
            $this->db->where('an.notif','unread');
            $this->db->order_by('an.id','DESC');
            $this->db->group_by('r.id');
            $query = $this->db->get();
            return $query->result();
        }
    }
    public function readNotifs(){
        if($this->user->user_type == 'rnd'){
            //data that will be inserted to tbl_admin_notif
            $this->db->set('notif', 'read');
            $this->db->update('tbl_admin_notif');
        } else if($this->user->user_type == 'researcher') {
            //data that will be inserted to tbl_researcher_notif
            $this->db->set('notif', 'read');
            $this->db->update('tbl_researcher_notif');
        } else if($this->user->user_type == 'twg') {
            //data that will be inserted to tbl_twg_notif
            $this->db->set('notif', 'read');
            $this->db->update('tbl_twg_notif');
        } else if($this->user->user_type == 'rde') {
            //data that will be inserted to tbl_rde_notif
            $this->db->set('notif', 'read');
            $this->db->update('tbl_rde_notif');
        } else if($this->user->user_type == 'pres') {
            //data that will be inserted to tbl_pres_notif
            $this->db->set('notif', 'read');
            $this->db->update('tbl_pres_notif');
        }
    }
    public function saveMessage(){
         //data that will be inserted to tbl_contact
         $data = array(
            "name" => $_POST['name'], 
            "email" => $_POST['email'], 
            "message" => $_POST['message'], 
            "created_by" => 0,
            "date_created" => date('Y-m-d H:i:s')
        );

        $id = $this->db->insert('tbl_contact',$data); //insert data to tbl_contact

        // $data = array(
        //     "user_id" => $this->user->id,
        //     "username" => '',
        //     "transaction" => 'Added Contact',
        //     "created_by" => !empty($this->user) ? $this->user->id : 0,
        //     "date_created" => date('Y-m-d H:i:s')
        // );
        // $this->db->insert('tbl_user_logs',$data); //insert data to tbl_user_logs
    }
    public function logsList(){
        $this->db->select('ul.date_created, CONCAT(ui.last_name,", ",ui.first_name," ",ui.middle_name) name, ul.transaction')
        ->from('tbl_user_logs ul')
        ->join('tbl_user u', "u.id = ul.created_by", "left")
        ->join('tbl_user_info ui', "ui.user_id = u.id", "left");
        $this->db->order_by('ul.date_created DESC');
        $query = $this->db->get();
        return $query->result();
    }
}