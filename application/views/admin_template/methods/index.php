<script type="text/javascript">
 $(document).ready(function() {
    $('#controller_method_lookup').change(function () {

        var lookup_data = $(this).val();
        var e_array = lookup_data.split('_');
        var current_url = $('#current_url').val();
        window.location.replace(current_url+"?c_id="+e_array[0]+"&m_id="+e_array[1]);
        
    });
    
});
</script>
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Methods</h5>
            <div class="ibox-tools">
                <a  title="Add new data" href="<?= site_url($this->router->fetch_class().'/add') ?>">
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
        <input type="hidden" id="current_url" value="<?= base_url(uri_string())?>"/>
        	<div class="row">
	            <div class="col-sm-5 m-b-xs">
	                <!-- print pagination-->
	            	<?=$render['pagination']?>
	            </div>
	            <div class="col-sm-4 m-b-xs">
	               
	            </div>
	            <div class="col-sm-3">
	               <?php 
	               $controller_method_option[''] = '';
	               if($this->input->get('c_id') and $this->input->get('m_id')){$controller_method=$this->input->get('c_id').'_'.$this->input->get('m_id');}else{$controller_method='';}
	               ?>
	            <?= form_dropdown('controller_method_lookup',$controller_method_option,$controller_method,'id="controller_method_lookup" class="searchable-option form-control"') ?>
	            </div>
	        </div>
	        <hr/>
        
        	<!-- Table Heading and reading value by key value pair-->
        	<?php $custom_fields = array(
        	'method_name'		=>	'Method Name',
        	'controller_name'	=> 'Controller Name',
        	'description'		=>	'Description'
        	);?>
        	<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<?php foreach ($custom_fields as $key => $value): ?>
								<th><?= $value ?></th>
							<?php endforeach; ?>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($render['result'] as $result):?>
							<tr>
								<!-- Custom Field Here -->
								<?php foreach ($custom_fields as $key => $value): ?>
								<td><?= $result->$key ?></td>
								<?php endforeach; ?>

								<!-- End Custom Field -->
								<td><?= anchor($this->router->fetch_class().'/change_status/'.$result->id.'/'.$result->active,($result->active=='Y'?'<i class="fa fa-check text-navy"></i>':'<i class="fa fa-times text-navy"></i>'))?></td>
								<td>
									<div class="btn-group">
			                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">Action <span class="caret"></span></button>
			                            <ul class="dropdown-menu">
			                                <li><?= anchor($this->router->fetch_class().'/show/'.$result->id,'<i class="fa fa-eye"></i> View')?></li>
			                                <li><?= anchor($this->router->fetch_class().'/edit/'.$result->id,'<i class="fa fa-edit"></i> Edit')?></li>
			                                <li><?= anchor($this->router->fetch_class().'/delete/'.$result->id,'<i class="fa fa-times"></i> Delete')?></li>
			                            </ul>
			                        </div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>        		
        	</div>

        </div>
    </div>
</div>
