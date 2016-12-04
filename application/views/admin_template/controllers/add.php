<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add</h5>
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
                    <?php //text input field here.
                            $item_to_displayed = array(
                                'controller_name'   =>  'Controller Name',
                                'description'       =>  'Controller Description',
                            );
                        ?>
                    	
                        <?= form_open($this->router->fetch_class().'/insert', 'class="form-horizontal"')?>

                        <?php foreach($item_to_displayed as $key=>$value):?>
                            
                            <div class="form-group"><label class="col-lg-2 control-label"><?= $value ?></label>
                                <div class="col-lg-10">
                                    <?= form_input(['name'=>$key,'placeholder'=>$value,'id'=>$key,'class'=>'form-control'])?>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        <?php endforeach; ?> 
                            <!-- Extra Field -->
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Status</label>
                                <div class="col-lg-10">
                                    <?= form_dropdown('active',['Y'=>'Active','N'=>'Inactive'],'Y','class="form-control m-b",id="active"')?>
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
