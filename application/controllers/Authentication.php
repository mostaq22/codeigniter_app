<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');        
    }
	
	public function login()
	{
        //load user agent library to redirect user in previous url.
        $this->load->library('user_agent');
        if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('message',validation_errors('<div class="alert alert-danger">','</div>'));
			redirect($this->agent->referrer(),'refresh');			
        }
        else
        {
        	//let's verify the user with the login credentials eg. email,password...etc. 
        	$user_email 	= $this->input->post('email');
        	$user_password	= $this->input->post('password');

	        $varification = $this->auth_model->login_validate(['user_email'=>$user_email,'user_password'=>$user_password]);
	        
	        if ($varification->status==FALSE)
	        {
	        	back_with_message('login_fail_message',$this->agent->referrer(),'danger');	
	        }
	        else if($varification->status==TRUE AND $varification->content->verified=='N')
	        {
	        	back_with_message('user_not_verified_message',$this->agent->referrer(),'danger');
	        }
	        //custom condition can be draw here.
	        else if($varification->status==TRUE AND $varification->content)
	        {
	        	//unset the password from the varification object
	        	unset($varification->content->user_password);
	        	// set session through loop here. keep it secure 
	        	foreach ($varification->content as $key => $value) 
	        	{
	        		$this->session->set_userdata($key,$value);
	        	}
	        	$this->session->set_userdata('logged_in',TRUE);
	        	$this->auth_model->redirect_url_after_login();	        	
	        }
        }
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('');
	}
	
}
