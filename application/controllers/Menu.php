<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();        
        //load requires library
        $this->load->library(['form_validation','pagination','user_agent']);
        //load related model
        $this->load->model('menu_model');
    }
	public function index($category_id=null)
	{
		$data['menu_category'] = $this->db->get_where('tbl_category',['category_type'=>'menu'])->result();
		$data['render'] = $this->menu_model->get($category_id);
		/*echo '<pre>';
		print_r($data['render']);
		echo '</pre>';*/
		$view_name = 'admin_template/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		$template['content'] = $this->load->view($view_name,$data,TRUE);
		$this->load->view('admin_template/layout/content',$template);
	}

	public function add()
	{
		$data['menu_category'] = $this->menu_model->get_all_category();
		$data['menu_options'] = $this->menu_model->get_all_menu();
		$data['menu_link_option'] = $this->menu_model->get_controller_method();
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
        	$posted_data = $this->input->post(NULL, TRUE);
        	foreach ($posted_data as $key => $value) {
        		$data[$key] = $value;
        	}
        	$controller_method = explode('_',$this->input->post('menu_link_option',TRUE));
        	$data['controller_id'] = $controller_method[0];
        	$data['method_id'] = $controller_method[1];
        	unset($data['menu_link_option']);
        	$result = $this->menu_model->save($data);
        	($result?back_with_message('insert_success_message',$this->agent->referrer(),'success'):back_with_message('insert_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function edit($id)
	{
		$data['menu_category'] = $this->menu_model->get_all_category();
		$data['menu_options'] = $this->menu_model->get_all_menu();
		$data['menu_link_option'] = $this->menu_model->get_controller_method();
		$data['render']=$this->menu_model->find($id);
		$data['menu_link_option'] = $this->menu_model->get_controller_method();
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
        	$controller_method = explode('_',$this->input->post('menu_link_option',TRUE));
        	$data['controller_id'] = $controller_method[0];
        	$data['method_id'] = $controller_method[1];
        	unset($data['menu_link_option']);
        	$result = $this->menu_model->update($this->input->post('id'),$data);
        	($result?back_with_message('update_success_message',$this->agent->referrer(),'success'):back_with_message('update_fail_message',$this->agent->referrer(),'danger'));
        }
	}
	public function delete($id)
	{
		$result = $this->menu_model->delete($id);
		($result?back_with_message('delete_success_message',$this->agent->referrer(),'success'):back_with_message('delete_fail_message',$this->agent->referrer(),'danger'));
	}
	public function show($id)
	{
		$data['render']=$this->menu_model->find($id);
		// echo '<pre>';
		// echo $this->db->last_query();
		// print_r($data);
		// echo '</pre>';
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
		$result = $this->menu_model->update($id,$data);
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
