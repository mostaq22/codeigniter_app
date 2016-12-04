<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admincp extends CI_Controller {

	/*
	  	# Admin Login Page
	*/
	public function __construct()
	{
		parent::__construct();		
		
	}
	public function index()
	{
		/*check if the user is logged in then redirect to dashboard controller otherwise
		render the admin_login view */
		if ($this->auth_model->redirect_url_after_login()==FALSE)
		{
			$this->load->view('admin_template/admin_login');
		}
	}
	
}
