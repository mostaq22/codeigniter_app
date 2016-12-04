<script type="text/javascript">
 $(document).ready(function() {
// $("#menu_link_option").prop("disabled", true);
    $('#linked').change(function () {

        var c_id = $(this).val();
        if($(this).is(":checked")) {
            $("#menu_link").prop('disabled', true);
            $("#menu_link_option").prop("disabled", false);
        }
        else{
            $("#menu_link").prop('disabled', false);
            $("#menu_link_option").prop("disabled", true);
        }
    });
    
});
</script>
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Edit</h5>
            <div class="ibox-tools">
                <a  href="<?= site_url($this->router->fetch_class().'/add') ?>">
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
            <!-- 
            *************************************
            Only Text Fields Will Include Here 
            *************************************
            -->
        	<?php 
            	 $item_to_displayed = array(
                    'menu_name'         =>  'Menu Name',
                    'menu_description'  =>  'Description',
                    'menu_order'        =>  'Menu Order',
                );
            ?>
        	<?= form_open($this->router->fetch_class().'/update', 'class="form-horizontal"',['id'=>$render['id']])?>
            <!-- 
            *************************************
            Only Text Fields Will Include Here 
            *************************************
            -->
            <?php foreach($item_to_displayed as $key=>$value):?>                            
                <div class="form-group"><label class="col-lg-2 control-label"><?= $value ?></label>
                    <div class="col-lg-10">
                        <?= form_input(['name'=>$key,'value'=>$render[$key],'placeholder'=>$value,'id'=>$key,'class'=>'form-control'])?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
            <?php endforeach; ?> 


            <!-- Extra Fields -->
                <div class="form-group"><label class="col-lg-2 control-label">Parent Menu</label>
                        <div class="col-lg-10">
                            <?= form_dropdown('parent_id',$menu_options,$render['parent_id'],'id="parent_id" class="searchable-option form-control"') ?>
                        </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-lg-2 control-label">Menu Category</label>
                    <div class="col-lg-10">
                        <?= form_dropdown('category_id',$menu_category,$render['category_id'],'id="category_id" class="searchable-option form-control"') ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Status</label>
                    <div class="col-lg-10">
                        <?= form_dropdown('active',['Y'=>'Active','N'=>'Inactive'],$render['active'],'class="form-control m-b",id="active"')?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Need Logged In</label>
                    <div class="col-lg-10">
                        <?= form_dropdown('need_logged_in',['Y'=>'Yes','N'=>'No'],$render['need_logged_in'],'class="form-control m-b",id="active"')?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Menu Link</label>
                    <div class="col-lg-4">
                    <?php //if($render['linked']=='Y') {$disabled_array['disabled']='disabled';}else{$disabled_array=null;}?>
                        <?= form_input(['name'=>'menu_link','id'=>'menu_link','class'=>'form-control','value'=>($render['linked']=='N'?$render['menu_link']:''),($render['linked']=='Y'?'disabled':'did')=>'disabled'])?>
                    </div>
                    <div class="col-lg-2">
                        <?= form_hidden('linked','N') ?>
                        <label><?= form_checkbox(['name'=>'linked','id'=>'linked','value'=>'Y','checked'=>($render['linked']=='Y'?true:false)])?> linked ?</label>
                    </div>
                    <div class="col-lg-4">
                        <?= form_dropdown('menu_link_option',$menu_link_option,$render['controller_id'].'_'.$render['method_id'],'id="menu_link_option" class="searchable-option form-control"') ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            <?= form_close()?>
			

        </div>
    </div>
</div>
