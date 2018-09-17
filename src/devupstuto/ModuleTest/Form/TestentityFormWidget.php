
    <?= Form::open($testentity, ["action"=> "$action_form", "method"=> "post"]) ?>

     <div class='form-group'>
<label for='name'>Name</label>
	<?= Form::input('name', $testentity->getName(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='description'>Description</label>
	<?= Form::textarea('description', $testentity->getDescription(), ['class' => 'form-control']); ?>
 </div>

       
    <?= Form::submit("save", ['class' => 'btn btn-success']) ?>
    
    <?= Form::addDformjs() ?>
    
    <?= Form::close() ?>