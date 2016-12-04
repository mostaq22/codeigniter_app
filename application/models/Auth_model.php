<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	private $table_name = 'tbl_user';
	//login_validate is a validation function . It will receive an array as param
	public function login_validate($data)
	{
		if ($data)
		{			
			$user_information = $this->db->get_where($this->table_name,['user_email'=>$data['user_email']])->row();
			if (count($user_information)==1)
			{
				if($this->verify_password_hash($data['user_password'],$user_information->user_password))
				{
					return $this->validation_return(TRUE,$user_information);
				}
				else
				{
					return $this->validation_return(FALSE,NULL);
				}
			}
			else
			{
				return $this->validation_return(FALSE,NULL);
			}
		}
	}
	public function redirect_url_after_login()
	{
		// get current looged in user url after login 
		if ($this->session->logged_in==TRUE)
		{
			$redirect_url = $this->db->get_where('tbl_user_group',['id'=>$this->session->user_group])->row()->redirect_url_after_login;
			if ($redirect_url)
			{
				redirect($redirect_url,'refresh');
			}
			else
			{
				redirect(get_option('default_url_after_login'),'refresh');
			}
		}
		else
		{
			return FALSE;
		}
		
	}
	private function hash_password($password)
	{
		return password_hash($password, PASSWORD_BCRYPT);
	}
	private function verify_password_hash($password, $hash)
	{
		return password_verify($password, $hash);
	}
	private function validation_return($status_flag,$information)
	{
		$validation = new stdClass();
		$validation->status = $status_flag;
		$validation->content = $information;
		return $validation;
	}
	
}
?>