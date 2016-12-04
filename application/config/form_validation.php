<?php

$config = array(
        'authentication/login' => array
        (
            array
            (
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|xss_clean|valid_email',
            ),
            array
            (
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|xss_clean',
            ),
        ),
        'controllers/insert' => array
        (
             array
            (
                'field' => 'controller_name',
                'label' => 'Controller Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean|is_unique[tbl_controller.controller_name]',
            ),
            array
            (
                'field' => 'description',
                'label' => 'Controller Description',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),
            array
            (
                'field' => 'active',
                'label' => 'Status',
                'rules' => 'trim|required|xss_clean',
            ),
        ),
        'controllers/update' => array
        (
             array
            (
                'field' => 'controller_name',
                'label' => 'Controller Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean|callback_validate_controller_name',
            ),
            array
            (
                'field' => 'description',
                'label' => 'Controller Description',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),
            array
            (
                'field' => 'active',
                'label' => 'Status',
                'rules' => 'trim|required|xss_clean',
            ),
        ),
        'methods/insert' => array
        (
            array
            (
                'field' => 'method_name',
                'label' => 'Method Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),
            array
            (
                'field' => 'description',
                'label' => 'Method Description',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),
            array
            (
                'field' => 'controller_id',
                'label' => 'Controller Name',
                'rules' => 'trim|required|xss_clean',
            ),
            array
            (
                'field' => 'active',
                'label' => 'Status',
                'rules' => 'trim|required|xss_clean',
            ),
        ),
        'methods/update' => array
        (
             array
            (
                'field' => 'method_name',
                'label' => 'Method Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean|callback_validate_method_name',
            ),
            array
            (
                'field' => 'description',
                'label' => 'Method Description',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),
            array
            (
                'field' => 'controller_id',
                'label' => 'Controller Name',
                'rules' => 'trim|required|xss_clean',
            ),
            array
            (
                'field' => 'active',
                'label' => 'Status',
                'rules' => 'trim|required|xss_clean',
            ),
        ),

        'user_group/insert' => array
        (
            array
            (
                'field' => 'user_group_name',
                'label' => 'User Group Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean|is_unique[tbl_user_group.user_group_name]',
            ),
            array
            (
                'field' => 'active',
                'label' => 'Status',
                'rules' => 'trim|required|xss_clean',
            ),
        ),
        'user_group/update' => array
        (
            array
            (
                'field' => 'user_group_name',
                'label' => 'User Group Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean|callback_validate_user_group_name',
            ),
            array
            (
                'field' => 'active',
                'label' => 'Status',
                'rules' => 'trim|required|xss_clean',
            ),
        ),
        'menu_category/insert' => array
        (
            array
            (
                'field' => 'category_name',
                'label' => 'Category Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),            
        ),
        'menu_category/update' => array
        (
            array
            (
                'field' => 'category_name',
                'label' => 'Category Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),            
        ),
        'menu/insert' => array
        (
            array
            (
                'field' => 'menu_name',
                'label' => 'Menu Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),
            array
            (
                'field' => 'category_id',
                'label' => 'Menu Category',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),         
        ),
        'menu/update' => array
        (
             array
            (
                'field' => 'menu_name',
                'label' => 'Menu Name',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),
            array
            (
                'field' => 'category_id',
                'label' => 'Menu Category',
                'rules' => 'trim|required|strip_image_tags|xss_clean',
            ),            
        ),
);


?>