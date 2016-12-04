<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_category extends CI_Controller
{
	public function __construct()
    {
        parent::__construct(); 
        //load requires library
        $this->load->library(['form_validation','pagination','user_agent','table']);
        //load related model
        $this->load->model('menu_category_model');
    }
	public function index()
	{
		$data['render']=$this->menu_category_model->get($order_by = null);
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
        	$posted_data = $this->input->post(NULL, TRUE);
        	foreach ($posted_data as $key => $value) {
        		$data[$key] = $value;
        	}
        	//inject extra value
        	$data['category_slug'] = $data['category_slug'] = url_title('mg_'.uniqid(), 'underscore');
        	$data['category_type']  = 'menu';
        	$result = $this->menu_category_model->save($data);
        	($result?back_with_message('insert_success_message',$this->agent->referrer(),'success'):back_with_message('insert_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function edit($id)
	{
		$data['render']=$this->menu_category_model->find($id);
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
        	$posted_data = $this->input->post(NULL, TRUE);
        	foreach ($posted_data as $key => $value) 
        	{
        		$data[$key] = $value;
        	}
        	$result = $this->menu_category_model->update($this->input->post('id'),$data);
        	($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function delete($id)
	{
		$result = $this->menu_category_model->delete($id);
		($result?back_with_message('delete_success_message',$this->agent->referrer(),'success'):back_with_message('delete_fail_message',$this->agent->referrer(),'danger'));
	}
	public function show($id)
	{
		$data['render']=$this->menu_category_model->find($id);
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
		if (count($data)==1) {
			$result = $this->menu_category_model->update($id,$data);
			($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
		}
	}
	//validate callback method
	public function validate_controller_name()
	{
		$rows = $this->db->get_where('tbl_controller',['controller_name'=>$this->input->post('controller_name'),'id !='=>$this->input->post('id')])->num_rows();
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
