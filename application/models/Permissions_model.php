<?php
class Permissions_model extends CI_Model
{
	private $table_name = 'tbl_permissions';
	public function get()
	{
		if ($this->uri->segment(3)) 
		{
			$data = $this->db->order_by('controller_name','ASC')->get_where('tbl_controller',['active'=>'Y'])->result_array();
			$incremental_operand = 0; 
			foreach ($data as $value) 
			{
				$this->db->select('tbl_permissions.*,tbl_method.method_name,tbl_method.description');
				$this->db->where('tbl_method.id = tbl_permissions.method_id');
				$this->db->where('tbl_permissions.user_group_id = '.$this->uri->segment(3));
				$this->db->group_by('method_id');
				$data[$incremental_operand]['permission'] = $this->db->get_where('tbl_permissions,tbl_method',['active'=>'Y','controller_id'=>$value['id']])->result_array();
				$incremental_operand++;
			}			
			return $data;
		}
	}
	public function update_permissions_batch($data)
	{
		$this->db->trans_begin();
		$this->db->update_batch($this->table_name, $data, 'id');
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
}
?>