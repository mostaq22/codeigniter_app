<div class="col-lg-12">
    <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Controllers</h5>
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
            <div class="row">
                <div class="col-sm-5 m-b-xs">
                <select class="input-sm form-control input-s-sm inline searchable-option">
                    <option value="0">Option 1</option>
                    <option value="1">Option 2</option>
                    <option value="2">Option 3</option>
                    <option value="3">Option 4</option>
                </select>
                </div>
                <div class="col-sm-4 m-b-xs">
                   
                </div>
                <div class="col-sm-3">
                    <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                </div>
            </div>
            <!-- print pagination-->
            	<?=$render['pagination']?>
            	<!-- Table Heading and reading value by key value pair-->
            	<?php $custom_fields = array(
                'controller_name'   => 'Controller Name',
            	'method_count'	    => 'Number of Methods',
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
