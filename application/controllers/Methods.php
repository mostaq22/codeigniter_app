<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Methods extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();        
        //load requires library
        $this->load->library(['form_validation','pagination','user_agent','table']);
        //load related model
        $this->load->model('methods_model');
    }
	public function index()
	{
		$data['controller_method_option'] = $this->methods_model->get_controller_method();
		$data['render']=$this->methods_model->get($order_by = 'controller_name');
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data,TRUE);
		$this->load->view('admin_template/layout/content',$template);
	}

	public function add()
	{
		//get all controller in form_dropdown array format
		$data['controller_option'] = $this->methods_model->get_all_controller();
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data,TRUE);
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
        	foreach ($_POST as $key => $value) {
        		$data[$key] = $value;
        	}
        	$result = $this->methods_model->save($data);
        	($result?back_with_message('insert_success_message',$this->agent->referrer(),'success'):back_with_message('insert_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function edit($id)
	{
		//get all controller in form_dropdown array format
		$data['controller_option'] = $this->methods_model->get_all_controller();
		$data['render']=$this->methods_model->find($id);
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data,TRUE);
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
        	$result = $this->methods_model->update($this->input->post('id'),$data);
        	($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function delete($id)
	{
		$result = $this->methods_model->delete($id);
		($result?back_with_message('delete_success_message',$this->agent->referrer(),'success'):back_with_message('delete_fail_message',$this->agent->referrer(),'danger'));
	}
	public function show($id)
	{
		$data['render']=$this->methods_model->find($id);
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
		$result = $this->methods_model->update($id,$data);
		($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
	}
	//validate callback method
	public function validate_method_name()
	{
		$rows = $this->db->get_where('tbl_method',['method_name'=>$this->input->post('method_name'),'id !='=>$this->input->post('id')])->num_rows();
		if ($rows >= 1)
        {
            $this->form_validation->set_message('validate_controller_name', 'The {field} field must be unique.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
	}
	
}
