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
                $this->load->view('home/login');  // redirect to login page if validation failed
            }
        } else { // if there is a session redirect to specific link in redirect_admin method
            $userSession = $this->session->userdata['user'];
            $this->redirect_login($userSession->user_type);
        }
    }
    public function redirect_login($type){  // redirect based on user_type 
        if($type == 'researcher'){
            redirect('research');
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
            $this->db->where("username = '$user' AND user_type = 'researcher'");
            $query = $this->db->get();
            $data = $query->result();

            if(empty($data)){ // if empty query ($data) validation false (invalid username)
                $this->form_validation->set_message('validate', 'Invalid Usernamess '.$user);
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
        if($session->user_type== 'admin' || $session->user_type== 'university president'){
            redirect('admin');
        } else if($session->user_type== 'researcher'){
            redirect('');
        }
    }
}
