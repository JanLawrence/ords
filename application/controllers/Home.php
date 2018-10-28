<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
	{
        if(empty($this->session->userdata['user'])){
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'callback_validate');

            if($this->form_validation->run() == TRUE){ // validation success
                // get tbl_credential data to be set to "user" session
                $user = $this->input->post('username');
                $query = $this->db->get_where('tbl_user', array('username' => $user));
                $data = $query->result();
                $this->session->set_userdata('user', $data[0]);
                // redirect based on user_type
                $userSession = $this->session->userdata['user'];
                $this->redirect_login($userSession->user_type);
            } else {
                $this->load->view('home/login');
            }
        } else {
            $userSession = $this->session->userdata['user'];
            $this->redirect_login($userSession->user_type);
        }
    }
    public function redirect_login($type){
        if($type == 'researcher'){
            redirect('research');
        } else {
            show_404();
        }
    }
    public function validate($pass){ // validate username and password, will be used in callback for form validation
        $user = $this->input->post('username');
        if($user != ''){
            $this->db->select('*')
                    ->from('tbl_user');
            $this->db->where("username = '$user' AND user_type = 'researcher'");
            $query = $this->db->get();
            $data = $query->result();
            if(empty($data)){
                $this->form_validation->set_message('validate', 'Invalid Usernamess '.$user);
                return FALSE;
            } else {
                if($pass != ''){
                    if($pass == $this->encryptpass->pass_crypt($data[0]->password, 'd')){
                        return TRUE;
                    } else {
                        $this->form_validation->set_message('validate', 'Invalid Password');
                        return FALSE;
                    }
                } else {
                    $this->form_validation->set_message('validate', 'Invalid Password');
                    return FALSE;
                }
            }
        } else {
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
