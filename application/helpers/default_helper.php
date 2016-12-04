<?php 
/* 
	Please Don't put any custom code in this helper.
*/
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{	
	//control panel template function	
	function get_cp_header()
	{
		$ci =& get_instance();
		$data['main_menu'] = get_cp_menu();
		$ci->load->view('admin_template/layout/header',$data);
	}
	//control panel template function
	function get_cp_footer()
	{
		$ci =& get_instance();
		$ci->load->view('admin_template/layout/footer');
	}
	/*
		get_back function will receive two param one error code and redirect. 
		hints:- language file message
	*/
	function get_cp_menu($parent_id=0,$level=0,$menu_html=null)
	{
		$ci =& get_instance();
		
		if($level>0){
			$menu_html.='<ul class="nav nav-second-level">';
		}
		
		//First Level
		foreach (menu_query($parent_id) as $menu) {
			if ($menu->has_access!='NO') {			

			$menu_html.='
			<li '.($menu->controller_name==$ci->router->fetch_class()?'class="active"':'').'>
	            <a href="'.($menu->linked=='Y'?site_url($menu->menu_link_abs):$menu->menu_link).'">
	            '.$menu->menu_description.'
	            	<span class="nav-label">'.$menu->menu_name.'</span>
	            	'.($menu->child>0?'<span class="fa arrow"></span>':'').'
	            </a>';
	    //Second level
	        if($menu->child>0){
	        	$menu_html.='<ul class="nav nav-second-level collapse">';
	        	foreach (menu_query($menu->id) as $menu_second) {
	        		if ($menu_second->has_access!='NO') {	
	                $menu_html.='
	                <li '.($menu_second->controller_name==$ci->router->fetch_class()?'class="active"':'').'>
	                	<a href="'.($menu_second->linked=='Y'?site_url($menu_second->menu_link_abs):$menu_second->menu_link).'">'.$menu_second->menu_name.($menu_second->child>0?'<span class="fa arrow"></span>':'').'</a>
	                </li>';
	                if($menu->child>0){
			        	$menu_html.='<ul class="nav nav-third-level collapse">';
			        	foreach (menu_query($menu_second->id) as $menu_third) {
			        		if ($menu_third->has_access!='NO') {
			                $menu_html.='
			                <li '.($menu_third->controller_name==$ci->router->fetch_class()?'class="active"':'').'><a href="'.($menu_third->linked=='Y'?site_url($menu_third->menu_link_abs):$menu_third->menu_link).'">'.$menu_third->menu_name.'</a></li>';
			        	}	 
			        	}               
			            $menu_html.='</ul>';
			        }
	        	}	 
	        	}               
	            $menu_html.='</ul>';
	        }

		}
	}
		return $menu_html;		
	}
	function menu_query($parent_id)
	{
		$ci =& get_instance();
		$user_group_id = $ci->session->user_group;
		return $ci->db->query("
			select 
				tbl_menu.id,tbl_menu.menu_name,tbl_menu.menu_description,tbl_menu.parent_id,tbl_menu.linked,tbl_menu.menu_link,
				tbl_permissions.has_access,tbl_controller.controller_name,tbl_method.method_name,
				concat(tbl_controller.controller_name,'/',tbl_method.method_name) as menu_link_abs,
				(select count(*) from tbl_menu as child_count where child_count.parent_id=tbl_menu.id) as child
			from 
				tbl_category,tbl_menu
			LEFT JOIN tbl_controller ON tbl_menu.controller_id = tbl_controller.id
			LEFT JOIN tbl_method ON tbl_menu.method_id = tbl_method.id
			LEFT JOIN tbl_permissions ON tbl_menu.method_id = tbl_permissions.method_id and tbl_permissions.user_group_id={$user_group_id}
			where
				tbl_menu.parent_id = {$parent_id} and tbl_category.id = tbl_menu.category_id and 
				tbl_category.category_slug='mg_581ce671040d9' and tbl_category.category_type='menu'
			group by tbl_menu.id
		")->result();
		
	}
	function back_with_message($error_code,$redirect_url,$class='info')
	{
		$ci =& get_instance();
		$ci->session->set_flashdata('message','<div class="alert alert-'.$class.'">'.get_option($error_code).'</div>');
		redirect($redirect_url,'refresh');
	}
	function get_option($option_name)
	{
		$ci =& get_instance();
		return $ci->db->get_where('tbl_option',['option_name'=>$option_name])->row()->option_value;
	}
	function bootstrap_pagination($total_rows,$perpage=25)
	{
		$ci =& get_instance();
		$config['base_url'] = site_url($ci->router->fetch_class().'/'.$ci->router->fetch_method());
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $perpage;
        $config["uri_segment"] = 3;
        $config["num_links"] = 3;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $ci->pagination->initialize($config);
        return $ci->pagination->create_links();
	}
	function result_array_to_form_dropdown($array,$id,$value)
	{
		foreach ($array as $arrays)
		{
			$data[$arrays[$id]] = $arrays[$value];
		}
		return $data;
	}
	
	
}