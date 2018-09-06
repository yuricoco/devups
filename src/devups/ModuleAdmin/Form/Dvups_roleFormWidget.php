
    <?= Form::open($dvups_role, ["action"=> "$action_form", "method"=> "post"]) ?>

     <div class='form-group'>
<label for='name'>Name</label>
	<?= Form::input('name', $dvups_role->getName(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='alias'>Alias</label>
	<?= Form::input('alias', $dvups_role->getAlias(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='dvups_right'>Dvups_right</label>

                    <?= Form::checkbox('dvups_right', 
                    FormManager::Options_ToCollect_Helper('name', new Dvups_right(), $dvups_role->getDvups_right()),
                    FormManager::Options_Helper('name', $dvups_role->getDvups_right()),
                    ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='dvups_module'>Dvups_module</label>

                    <?= Form::checkbox('dvups_module', 
                    FormManager::Options_ToCollect_Helper('name', new Dvups_module(), $dvups_role->getDvups_module()),
                    FormManager::Options_Helper('name', $dvups_role->getDvups_module()),
                    ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='dvups_entity'>Dvups_entity</label>

                    <?= Form::checkbox('dvups_entity', 
                    FormManager::Options_ToCollect_Helper('name', new Dvups_entity(), $dvups_role->getDvups_entity()),
                    FormManager::Options_Helper('name', $dvups_role->getDvups_entity()),
                    ['class' => 'form-control']); ?>
 </div>

       
    <?= Form::submit("save", ['class' => 'btn btn-success']) ?>
    
    <?= Form::close() ?>