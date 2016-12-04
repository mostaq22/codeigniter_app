<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>View</h5>
                        <div class="ibox-tools">
                            <a href="<?= site_url($this->router->fetch_class().'/add') ?>">
                                <i class="fa fa-plus"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                    	<?php 
                        	$item_to_displayed = array(
                        		'user_group_name'           => 'User Group Name',
                                'redirect_url_after_login'  =>  'Redirect Url After Login',
                        		'active'			=>	'Active'
                        	);
                        ?>
                    	<table class="table table-bordered">
                    	<?php foreach($item_to_displayed as $key=>$value):?>
                    		<tr>
                    			<th><?= $value ?></th>
                    			<td><?= $render[$key]?></td>
                    		</tr>
                    	<?php endforeach; ?>                    		
                    	</table>
						

                    </div>
                </div>
            </div>
