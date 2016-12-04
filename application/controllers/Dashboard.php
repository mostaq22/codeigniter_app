<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/*
	  	# Admin Dashboard
	*/
	public function index()
	{
		$template['content'] = $this->load->view('admin_template/dashboard',$data=null,TRUE);
		$this->load->view('admin_template/layout/content',$template);
	}
	
}
