<script type="text/javascript">
 $(document).ready(function() {
    $('.controller').change(function () {
        var c_id = $(this).val();
        if($(this).is(":checked")) {
            $(".controller_"+c_id).prop('checked', true);
        }
        else{
            $(".controller_"+c_id).prop('checked', false);  
        }
    });
    $('#permission_submission').click(function(){
        $('#update_permissions').submit();
    });
});
</script>
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Permissions</h5>
            <div class="ibox-tools">
                <button type="submit" id="permission_submission" class="btn btn-info btn-xs">Update Permissions</button>   
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                        <?php foreach($user_group as $u_group):?>
                            <li class="<?=($this->uri->segment(3)==$u_group->id?'active':null)?>">
                                <a  href="<?= site_url($this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$u_group->id)?>" aria-expanded="false"><?= $u_group->user_group_name ?></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                        <div class="tab-content ">
                            <div id="tab-<?=$this->uri->segment(3)?>" class="tab-pane active">
                                <div class="panel-body">
                                <!-- Load Form Helper -->
                                <?= form_open($this->router->fetch_class().'/update_permissions',['class' => 'update_permissions', 'id' => 'update_permissions'])?>
                                <?php if($render):?>
                                <?php foreach($render as $item):?>
                                    <div class="panel panel-<?= $panel_class[array_rand($panel_class)] ?>">
                                        <div class="panel-heading">
                                            <label style="font-size: 15px;"> <input name="controller[]" type="checkbox" class="controller" value="<?=$item['id']?>"> <?=$item['controller_name']?> (<?=$item['description']?>) </label>
                                        </div>
                                        <div class="panel-body">
                                            <?php foreach ($item['permission'] as $permissions): ?>
                                                <?= form_hidden('permissions['.$permissions['id'].']','NO') ?>
                                                <h3>
                                                <label>
                                                    <?= form_checkbox('permissions['.$permissions['id'].']','YES',($permissions['has_access']=='YES'?TRUE:FALSE),'class="controller_'.$item['id'].'"') ?>
                                                    <?= $permissions['method_name'] ?>
                                                </label>
                                                </h3>
                                                <p style="margin-left: 15px;"><?= $permissions['description'] ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php endif;?>
                                <?= form_close() ?>
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
