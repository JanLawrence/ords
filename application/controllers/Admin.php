<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index() // login page of admin
	{
        redirect(base_url());
        if(empty($this->session->userdata['user'])){ // if empty session

            //declared validations for username and password
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'callback_validate'); // validation is on validate method

            if($this->form_validation->run() == TRUE){ // validation success set session
                // get tbl_user data to be set to "user" session
                $user = $this->input->post('username');
                $query = $this->db->get_where('tbl_user', array('username' => $user));
                $data = $query->result();
                $this->session->set_userdata('user', $data[0]);
                // set session and redirect based on user_type
                $userSession = $this->session->userdata['user'];
                $this->redirect_admin($userSession->user_type);
            } else {
                $this->load->view('admin/login'); // redirect to login page if validation failed
            }
        } else { // if there is a session redirect to specific link in redirect_admin method
            $userSession = $this->session->userdata['user']; 
            $this->redirect_admin($userSession->user_type);
        }
    }
    public function redirect_admin($type){ // redirect based on user_type 
        if($type == 'admin'){
            redirect('admin/addUser');
        } else if($type == 'pres' || $type == 'twg' || $type == 'rde' || $type = 'rnd'){
            redirect('admin/researchList');
        } else {
            show_404(); // show 404 error page
        }
    }
    public function validate($pass){ // validate username and password, will be used in callback for form validation
        $user = $this->input->post('username');
        if($user != ''){ // if username is inputed
            // query user by username and user type is equal to admin or president
            $this->db->select('*')
                    ->from('tbl_user');
            $this->db->where("username = '$user' AND user_type = 'admin' OR user_type = 'pres' OR user_type = 'twg' OR user_type = 'rde'");
            $query = $this->db->get();
            $data = $query->result();

            
            if(empty($data)){ // if empty query ($data) validation false (invalid username)
                $this->form_validation->set_message('validate', 'Invalid Username '.$user);
                return FALSE;
            } else { // if not empty $data (query)
                if($pass != ''){   // if password is inputed
                    if($pass == $this->encryptpass->pass_crypt($data[0]->password, 'd')){ // if pass is equal to password in db validation passed
                        return TRUE;
                    } else {
                        $this->form_validation->set_message('validate', 'Invalid Password'); // if pass is not equal to password in db validation failed
                        return FALSE;
                    }
                } else { // if password is not inputed validation false (invalid pass)
                    $this->form_validation->set_message('validate', 'Invalid Password');
                    return FALSE;
                }
            }
        } else { // if username is not inputed validation false (invalid username)
            $this->form_validation->set_message('validate', 'Invalid Username');
            return FALSE;
        }
    }
	public function addUser()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'admin'){ // if user type admin 

                // load view
                $data['userList'] = $this->admin_model->userList();
                $data['deptList'] = $this->admin_model->deptList();
                $data['specialization'] = $this->admin_model->specializationList();
                $this->load->view('templates/header');
                $this->load->view('admin/add-user',$data);
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }
        
    }
	public function classification()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'admin'){ // if user type admin 

                // load view
                $data['classification'] = $this->admin_model->classificationList();
                $this->load->view('templates/header');
                $this->load->view('admin/classification',$data);
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }
        
    }
	public function calendar()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'admin'){ // if user type admin 

                // load view
                $this->load->view('templates/header');
                $this->load->view('admin/calendar');
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }
        
    }
	public function dashboard()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'twg' || $this->session->userdata['user']->user_type == 'pres' || $this->session->userdata['user']->user_type == 'twg' || $this->session->userdata['user']->user_type == 'rde' || $this->session->userdata['user']->user_type == 'rnd' || $this->session->userdata['user']->user_type == 'staff'){ // if user type admin 

                // load view
                $data['submitted'] = $this->admin_model->submittedResearch();
				$data['forapproval'] = $this->admin_model->forApprovalResearch();
				$data['attachment'] = $this->admin_model->attachmentResearch();
                $this->load->view('templates/header');
                $this->load->view('admin/dashboard', $data);
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }
        
    }
    public function addEvent(){
        $this->admin_model->addEvent();
    }
    public function updateEvent(){
        $this->admin_model->updateEvent();
    }
    public function deleteEvent(){
        $this->admin_model->deleteEvent();
    }
    public function getEventByDate(){
        $this->admin_model->getEventByDate();
    }
    public function saveClassification(){
        $this->admin_model->saveClassification(); // save Classification controller
    }
    public function editClassification(){
        $this->admin_model->editClassification(); // edit Classification controller
    }
    public function setUser(){
        $this->admin_model->setUser(); // save user controller
    }
    public function saveUser(){
        $this->admin_model->saveUser(); // save user controller
    }
    public function registerUser(){
        $this->admin_model->registerUser(); // save user controller
    }
    public function editUser(){
        $this->admin_model->editUser(); // edit user controller
    }
    public function addNotes(){
        $this->admin_model->addNotes(); // add notes controller
    }
    public function viewNotesPerResearch(){
       $data['notes'] = $this->admin_model->viewNotesPerResearch($_REQUEST['research']);
       $this->load->view('admin/ajax/notes', $data);
    }
    public function changeResearchStatus(){
        $this->admin_model->changeResearchStatus(); // update status controller
    }
    public function setDuration(){
        $this->admin_model->setDuration(); // setDuration controller
    }
    public function deleteUser(){
        $this->admin_model->deleteUser(); // deleteUser controller
    }
	public function researchList() 
	{
        if(!empty($this->session->userdata['user'])){ // if has session

            // if user type is equal to admin or president
            $from = isset($_GET['from']) && $_GET['from'] != '' ? $_GET['from'] : '';
            $to = isset($_GET['to']) &&  $_GET['to'] != '' ? $_GET['to'] : '';
            $status = isset($_GET['status']) &&  $_GET['status'] != '' ? $_GET['status'] : '';
            if($this->session->userdata['user']->user_type == 'rnd' || $this->session->userdata['user']->user_type == 'pres' || $this->session->userdata['user']->user_type == 'twg' || $this->session->userdata['user']->user_type == 'rde' || $this->session->userdata['user']->user_type == 'staff'){
                if($this->session->userdata['user']->user_type == 'rnd' || $this->session->userdata['user']->user_type == 'staff'){
                    $data['research'] = $this->admin_model->getAllResearhAdmin2($from, $to, $status);
                } else if($this->session->userdata['user']->user_type == 'twg'){ 
                    $data['research'] = $this->admin_model->getAllResearhTwg($from, $to, $status);
                } else if($this->session->userdata['user']->user_type == 'rde'){ 
                    $data['research'] = $this->admin_model->getAllResearhRde($from, $to, $status);
                } else if($this->session->userdata['user']->user_type == 'pres'){ 
                    $data['research'] = $this->admin_model->getAllResearhPres($from, $to, $status);
                }
                // load view
                $this->load->view('templates/header');
                $this->load->view('admin/research-list', $data);
                $this->load->view('templates/footer');
            } else {
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        } 
	}
	public function department()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'admin'){ // if user type admin 

                // load view
                $data['department'] = $this->admin_model->deptList();
                $this->load->view('templates/header');
                $this->load->view('admin/department',$data);
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }
        
    }
    public function saveDept(){
        $this->admin_model->saveDept(); // save Departmenr controller
    }
    public function editDept(){
        $this->admin_model->editDept(); // edit Departmenr controller
    }
	public function agenda()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'admin'){ // if user type admin 

                // load view
                $data['agenda'] = $this->admin_model->agendaList();
                $this->load->view('templates/header');
                $this->load->view('admin/agenda',$data);
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }
        
    }
    public function saveAgenda(){
        $this->admin_model->saveAgenda(); // save Departmenr controller
    }
    public function editAgenda(){
        $this->admin_model->editAgenda(); // edit Departmenr controller
    }
    public function readNotifs(){
        $this->admin_model->readNotifs();
    }
    public function specialization()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'admin'){ // if user type admin 

                // load view
                $data['specialization'] = $this->admin_model->specializationList();
                $this->load->view('templates/header');
                $this->load->view('admin/specialization',$data);
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }   
    }
    public function saveSpecialization(){
        $this->admin_model->saveSpecialization(); // save Specialization controller
    }
    public function editSpecialization(){
        $this->admin_model->editSpecialization(); // edit Specialization controller
    }
    public function saveMessage(){
        $this->admin_model->saveMessage(); // save message controller
    }
    public function downloadNote(){
        $this->admin_model->downloadNote(); // save message controller
    }
    public function userLogs()
	{
        if(!empty($this->session->userdata['user'])){ // if has session
            if($this->session->userdata['user']->user_type == 'admin'){ // if user type admin 
                $from = isset($_GET['from']) && $_GET['from'] != '' ? $_GET['from'] : '';
                $to = isset($_GET['to']) && $_GET['to'] != '' ? $_GET['to'] : '';
                // load view
                $data['logs'] = $this->admin_model->logsList($from, $to);
                $this->load->view('templates/header');
                $this->load->view('admin/logs',$data);
                $this->load->view('templates/footer');
                
            } else { 
                show_404(); // show 404 error page
            }
        } else {
            show_404(); // show 404 error page
        }   
    }
}
