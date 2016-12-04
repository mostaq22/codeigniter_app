<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?=ucfirst($this->router->fetch_class())?></h5>
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
            <ul class="nav nav-tabs">
                <?php foreach($menu_category as $category):?>
                    <li class="<?=($this->uri->segment(3)==$category->id?'active':null)?>">
                        <a  href="<?= site_url($this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$category->id)?>" aria-expanded="false"><?= $category->category_name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        	<!-- Table Heading and reading value by key value pair-->
        	<?php $custom_fields = array(
        	'menu_name'		    =>	'Menu Name',
        	'category_name'		=>  'Category',
            'menu_description'  =>  'Description',
        	);?>
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
