<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_group extends CI_Controller
{
	public function __construct()
    {
        parent::__construct(); 
        //load requires library
        $this->load->library(['form_validation','pagination','user_agent','table']);
        //load related model
        $this->load->model('user_group_model');
    }
	public function index()
	{
		$data['render']=$this->user_group_model->get($order_by = 'controller_name');
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data,TRUE);
		$this->load->view('admin_template/layout/content',$template);
	}

	public function add()
	{
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data=null,TRUE);
		$this->load->view('admin_template/layout/content',$template);
	}
	public function insert()
	{
		if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('message',validation_errors('<div class="alert alert-danger">','</div>'));
			redirect($this->agent->referrer(),'refresh');			
        }
        else
        {
        	$access_flag = $this->input->post('access_flag');
        	unset($_POST['access_flag']);
        	foreach ($_POST as $key => $value) {
        		$data[$key] = $value;
        	}
        	$result = $this->user_group_model->save($data);

        	//Insert Permission against this user group and has_access to NO
        	if($result)
        	{	
        		$permissions = $this->user_group_model->insert_permission_to_user_group($this->db->insert_id(),$access_flag);
        	}        	
        	($result AND $permissions ?back_with_message('insert_success_message',$this->agent->referrer(),'success'):back_with_message('insert_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function edit($id)
	{
		$data['render']=$this->user_group_model->find($id);		
		
		if ($data['render']) 
		{
			$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
			$template['content'] = $this->load->view($view_name,$data,TRUE);
		}
		else
		{
			$template['content'] = '<div class="alert alert-danger">Data Not Found </div>';
		}
		$this->load->view('admin_template/layout/content',$template);
	}
	public function update()
	{
		if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('message',validation_errors('<div class="alert alert-danger">','</div>'));
			redirect($this->agent->referrer(),'refresh');			
        }
        else
        {
        	foreach ($_POST as $key => $value) 
        	{
        		$data[$key] = $value;
        	}
        	$result = $this->user_group_model->update($this->input->post('id'),$data);
        	($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function delete($id)
	{
		$result = $this->user_group_model->delete($id);
		($result?back_with_message('delete_success_message',$this->agent->referrer(),'success'):back_with_message('delete_fail_message',$this->agent->referrer(),'danger'));
	}
	public function show($id)
	{
		$data['render']=$this->user_group_model->find($id);
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data,TRUE);
		$this->load->view('admin_template/layout/content',$template);
	}

	public function change_status($id,$status_id)
	{
		if ($status_id=='Y')
		{
			$data['active'] = 'N';
		}
		else
		{
			$data['active'] = 'Y';
		}
		$result = $this->user_group_model->update($id,$data);
		($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
	}
	//validate callback method
	public function validate_user_group_name()
	{
		$rows = $this->db->get_where('tbl_user_group',['user_group_name'=>$this->input->post('user_group_name'),'id !='=>$this->input->post('id')])->num_rows();
		if ($rows >= 1)
        {
            $this->form_validation->set_message('validate_user_group_name', 'The {field} field must be unique.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
	}
	
}
