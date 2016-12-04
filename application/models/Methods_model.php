<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Methods_model extends CI_Model
{
	private $table_name = 'tbl_method';
	private $primary_key = 'id';
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get($order_by)
	{
		$limit = 25;
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->db->select($this->table_name.'.*,tbl_controller.controller_name');
		$this->db->join('tbl_controller', 'tbl_controller.id = '.$this->table_name.'.controller_id');
		$this->query_string_clause();
		$this->db->order_by('tbl_controller.controller_name,tbl_method.method_name','ASC');
		$data['result'] = $this->db->get($this->table_name,$limit,$start)->result();
		$data['pagination'] = bootstrap_pagination($this->count_record(),$limit);			
		return $data;
	}
	public function save($data)
	{
		$data['inserted_at'] = date('Y-m-d H:i:s');
		$data['inserted_by'] = $this->session->user_id;
		$this->db->trans_begin();
		$this->db->insert($this->table_name,$data);
		$this->insert_permission_to_user_group($this->db->insert_id(),'NO');
		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    return FALSE;
		}
		else
		{
		    $this->db->trans_commit();
		    return TRUE;
		}
	}
	public function find($id)
	{
		return $this->db->get_where($this->table_name,[$this->primary_key=>$id])->row_array();
	}
	public function count_record()
	{
		$this->query_string_clause();
		$this->db->from($this->table_name);
		return $this->db->count_all_results();
	}
	public function query_string_clause()
	{
		//search query string 
		if($this->input->get('c_id')){$this->db->where(['controller_id'=> $this->input->get('c_id')]);}
		if($this->input->get('m_id')){$this->db->where([$this->table_name.'.id'=> $this->input->get('m_id')]);}
	}
	public function update($id,$data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->user_id;
		$this->db->where($this->primary_key, $id);
		return $this->db->update($this->table_name,$data);
	}
	public function delete($id)
	{
		return $this->db->delete($this->table_name,[$this->primary_key=>$id]);
	}
	//controller option 
	public function get_all_controller()
	{
		return result_array_to_form_dropdown($this->db->get_where('tbl_controller',['active'=>1])->result_array(),'id','controller_name');
	}
	//insert permission to user group 
	public function insert_permission_to_user_group($method_id,$access_flag)
	{
		return $this->db->query("
			insert into tbl_permissions (user_group_id,method_id,has_access,inserted_at,inserted_by)
			select tbl_user_group.id,{$method_id},'{$access_flag}',now(),'{$this->session->user_id}' from tbl_user_group
		");
	}
	//get controller/method 
	public function get_controller_method()
	{
		$this->db->select("CONCAT(tbl_controller.id,'_',tbl_method.id) as id,CONCAT(tbl_controller.controller_name,'/',tbl_method.method_name) as name");
		$result = $this->db->order_by('name asc')->get_where('tbl_controller,tbl_method','tbl_controller.id = tbl_method.controller_id')->result_array();
		return result_array_to_form_dropdown($result,'id','name');
	}
	
}
?>