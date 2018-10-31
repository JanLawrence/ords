<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index() // login page of admin
	{
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
        } else if($type == 'university president'){
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
            $this->db->where("username = '$user' AND user_type = 'admin' OR user_type = 'university president'");
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
    public function saveUser(){
        $this->admin_model->saveUser(); // save user controller
    }
    public function editUser(){
        $this->admin_model->editUser(); // edit user controller
    }
    public function changeResearchStatus(){
        $this->admin_model->changeResearchStatus(); // update status controller
    }
	public function researchList() 
	{
        if(!empty($this->session->userdata['user'])){ // if has session

            // if user type is equal to admin or president
            if($this->session->userdata['user']->user_type == 'admin' || $this->session->userdata['user']->user_type == 'university president'){
               

                if($this->session->userdata['user']->user_type == 'admin'){ // if user type is admin get getAllResearch method in admin model for research list
                    $data['research'] = $this->admin_model->getAllResearh();
                } else if($this->session->userdata['user']->user_type == 'university president'){  // if user type is president get getAllResearhApprovedAdmin method in admin model  for research list
                    $data['research'] = $this->admin_model->getAllResearhApprovedAdmin();
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
}
