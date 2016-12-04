<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller {

	public function __construct()
    {
        parent::__construct(); 
        //load requires library
        $this->load->library(['form_validation','pagination','user_agent']);
        //load related model
        $this->load->model('permissions_model');
    }
	public function index()
	{
		$data['render']=$this->permissions_model->get($order_by = 'controller_name');
		$data['panel_class'] = array('default','primary','success','info','warning','danger');
		//all user group
		$data['user_group'] = $this->db->get('tbl_user_group')->result();
		
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data,TRUE);
		$this->load->view('admin_template/layout/content',$template);
	}
	public function update_permissions()
	{
		foreach ($this->input->input_stream('permissions',TRUE) as $key=>$value) {
			$data[]	 = array(
				'id'=> $key,
				'has_access'=>$value
			);
		}
		if (count($data)>0) {
			$result = $this->permissions_model->update_permissions_batch($data);
			($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
		}		
	}
}
