<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index() // login page of researcher
	{
        if(empty($this->session->userdata['user'])){ // if empty session

            //declared validations for username and password
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'callback_validate'); // validation is on validate method


            if($this->form_validation->run() == TRUE){  // validation success set session
                // get tbl_user data to be set to "user" session
                $user = $this->input->post('username');
                $query = $this->db->get_where('tbl_user', array('username' => $user));
                $data = $query->result();
                $this->session->set_userdata('user', $data[0]);
                // set session and redirect based on user_type
                $userSession = $this->session->userdata['user'];
                $this->redirect_login($userSession->user_type);
            } else {
                $data['deptList'] = $this->admin_model->deptList();
                $data['specialization'] = $this->admin_model->specializationList();
                $this->load->view('home/login', $data);  // redirect to login page if validation failed
            }
        } else { // if there is a session redirect to specific link in redirect_admin method
            $userSession = $this->session->userdata['user'];
            $this->redirect_login($userSession->user_type);
        }
    }
    public function redirect_login($type){  // redirect based on user_type 
        if($type == 'researcher'){
            redirect('research');
        } else if($type == 'admin'){
            redirect('admin/addUser');
        } else if($type == 'pres'){
            redirect('admin/researchList');
        } else if($type == 'twg'){
            redirect('admin/researchList');
        } else if($type == 'rde'){
            redirect('admin/researchList');
        } else if($type == 'rnd'){
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
            $this->db->where("username = '$user' AND status = 'yes'");
            $query = $this->db->get();
            $data = $query->result();

            if(empty($data)){ // if empty query ($data) validation false (invalid username)
                $this->form_validation->set_message('validate', 'Invalid Username'.$user);
                return FALSE;
            } else {  // if not empty $data (query)
                if($pass != ''){   // if password is inputed
                    if($pass == $this->encryptpass->pass_crypt($data[0]->password, 'd')){  // if pass is equal to password in db validation passed
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
        } else {  // if username is not inputed validation false (invalid username)
            $this->form_validation->set_message('validate', 'Invalid Username');
            return FALSE;
        }
    }
    public function logout(){
        $session = $this->session->userdata['user'];
        //destroy session
        $this->session->sess_destroy();
        //redirect to homepage
        if($session->user_type== 'admin' || $session->user_type== 'pres'  || $session->user_type== 'twg' || $session->user_type== 'rde' || $session->user_type== 'rnd'){
            redirect('admin');
        } else if($session->user_type== 'researcher'){
            redirect('');
        }
    }
    function changepass(){
        $oldpass = $_POST['oldpass'];
        $pass = $_POST['pass'];
        $confirmpass = $_POST['confirmpass'];
        $userData = $this->session->userdata['user'];
        $realpass = $this->encryptpass->pass_crypt($userData->password, 'd');
        if($realpass == $oldpass){

            $this->db->set('password', $this->encryptpass->pass_crypt($_POST['pass']));
            $this->db->where('username', $userData->username);
            $this->db->update('tbl_user'); //update status to logged in from tbl_user
   
            $query = $this->db->get_where('tbl_user', array('username' => $userData->username));
            $data = $query->result();
            $this->session->set_userdata('user', $data[0]);


        } else {
            echo 1;
        }
    }
    function accountupdate(){
        //data that will be updated to tbl_user
        $this->db->set('username', $_POST['username']);
        $this->db->where('id', $_POST['id']);
        $this->db->update('tbl_user');

        //data that will be updated to tbl_user_info
        $this->db->set('first_name', $_POST['fname']);
        $this->db->set('middle_name', $_POST['mname']);
        $this->db->set('last_name', $_POST['lname']);
        $this->db->set('email', $_POST['email']);
        $this->db->where('user_id', $_POST['id']);
        $this->db->update('tbl_user_info');

        
        $query = $this->db->get_where('tbl_user', array('username' => $_POST['username']));
        $data = $query->result();
        $this->session->set_userdata('user', $data[0]);
    }
}
