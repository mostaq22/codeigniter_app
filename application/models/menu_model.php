<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	private $table_name = 'tbl_menu';
	private $primary_key = 'id';
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	public function get($category_id)
	{
		$limit = 25;
		$this->db->select($this->table_name.'.*,tbl_category.category_name');
		$this->db->where(['category_id'=>$category_id]);
		$this->db->join("tbl_category","tbl_category.id = ".$this->table_name.".category_id and tbl_category.category_type='menu'");
		$this->db->order_by($this->table_name.'.menu_name','ASC');
		$data['result'] = $this->db->get($this->table_name)->result();
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
		$this->db->select('tbl_menu.*,tbl_category.category_name,tbl_parent_menu.menu_name as parent_menu');
		$this->db->join('tbl_menu as tbl_parent_menu','tbl_parent_menu.id = '.$this->table_name.'.parent_id','left');
		$this->db->where($this->table_name.'.'.$this->primary_key.'='.$id.' and tbl_category.id ='.$this->table_name.'.category_id');
		return $this->db->get_where($this->table_name.',tbl_category')->row_array();
	}
	public function count_record()
	{
		return $this->db->count_all($this->table_name);
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
	//get menu category option 
	public function get_all_category()
	{
		return result_array_to_form_dropdown($this->db->get_where('tbl_category',['category_type'=>'menu'])->result_array(),'id','category_name');
	}
	//get menu option 
	public function get_all_menu()
	{
		return result_array_to_form_dropdown($this->db->order_by('menu_name','asc')->get($this->table_name)->result_array(),'id','menu_name');
	}
	//get controller/method 
	public function get_controller_method()
	{
		$this->db->select("CONCAT(tbl_controller.id,'_',tbl_method.id) as id,CONCAT(tbl_controller.controller_name,'/',tbl_method.method_name) as name");
		$result = $this->db->order_by('name asc')->get_where('tbl_controller,tbl_method','tbl_controller.id = tbl_method.controller_id')->result_array();
		return result_array_to_form_dropdown($result,'id','name');
	}
	//insert permission to user group 
	public function insert_permission_to_user_group($method_id,$access_flag)
	{
		return $this->db->query("
			insert into tbl_permissions (user_group_id,method_id,has_access,inserted_at,inserted_by)
			select tbl_user_group.id,{$method_id},'{$access_flag}',now(),'{$this->session->user_id}' from tbl_user_group
		");
	}

	
}
?>