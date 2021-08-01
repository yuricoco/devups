

    <?php //Form::addcss(Address ::classpath('Ressource/js/address')) ?>
    
    <?= Form::open($address, ["action"=> "$action", "method"=> "post"]) ?>

     <div class='form-group'>
<label for='firstname'>Firstname</label>
	<?= Form::input('firstname', $address->getFirstname(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='description'>Description</label>
	<?= Form::input('description', $address->getDescription(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='phonenumber'>Phonenumber</label>
	<?= Form::input('phonenumber', $address->getPhonenumber(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='lastname'>Lastname</label>
	<?= Form::input('lastname', $address->getLastname(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='address'>Address</label>
	<?= Form::input('address', $address->getAddress(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='postalcode'>Postalcode</label>
	<?= Form::input('postalcode', $address->getPostalcode(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='label'>Label</label>
	<?= Form::input('label', $address->getLabel(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='user'>User</label>

                    <?= Form::select('user', 
                    FormManager::Options_Helper('firstname', User::allrows()),
                    $address->getUser()->getId(),
                    ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='town'>Town</label>

                    <?= Form::select('town', 
                    FormManager::Options_Helper('id', Town::allrows()),
                    $address->getTown()->getId(),
                    ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='quarter'>Quarter</label>

                    <?= Form::select('quarter', 
                    FormManager::Options_Helper('id', Quarter::allrows()),
                    $address->getQuarter()->getId(),
                    ['class' => 'form-control']); ?>
 </div>

       
    <?= Form::submit("save", ['class' => 'btn btn-success']) ?>
    
    <?= Form::close() ?>
    
    <?= Form::addDformjs() ?>    
    <?= Form::addjs(Address::classpath('Ressource/js/addressForm')) ?>
    