<?php
/**
* This Class Will Called As Hook For Authentication
*/
class Authentication
{
	private $css = "<style>
	pre{
		border:1px solid #ddd000;
		padding:2px;
		text-align:center;
		color:red;
	}
	</style>
	";
	public function authorize()
	{
		$ci =& get_instance();
		$message=null;
		//get contoller and method name		
		$controller_name = $ci->router->fetch_class();
		$method_name = $ci->router->fetch_method();

		//query for class and method
		$ci->db->select('
			tbl_controller.controller_name,
			tbl_controller.active as controller_status,
			tbl_method.method_name,
			tbl_method.active as method_status,
			tbl_method.need_logged_in,
			tbl_permissions.has_access');
		$ci->db->from('tbl_method,tbl_permissions,tbl_controller');
		$ci->db->where('tbl_method.id = tbl_permissions.method_id and tbl_controller.id = tbl_method.controller_id');
		if ($ci->session->logged_in==TRUE) {
			//user group
			$ci->db->where(['tbl_permissions.user_group_id'=>$ci->session->user_group]);
		}
		//method 
		$ci->db->where(['tbl_method.method_name'=>$method_name]);
		//controller 
		$ci->db->where(['tbl_controller.controller_name'=>$controller_name]);
		$result = $ci->db->get()->row_array();

		if ($result==null or !$result or $result==false) {
			$message = 'Page not found.';
		}
		elseif ($result['controller_status']=='N') {
			$message = 'The module is disable';
		}
		elseif ($result['method_status']=='N') {
			$message = 'The page is disable';
		}
		elseif ($ci->session->logged_in==FALSE AND $result['need_logged_in']=='Y') {
			$message = 'You have to login to access this page.';
		}
		elseif ($ci->session->logged_in==TRUE AND $result['has_access']=='NO') {
			$message = 'You don\'t have permission to access this page.';
		}
		if ($message) {
			echo $this->css;
			echo '<pre>';
			echo '<p>'.$message.'</p>';
			echo '</pre>';
			exit();	
		}

	}	
}