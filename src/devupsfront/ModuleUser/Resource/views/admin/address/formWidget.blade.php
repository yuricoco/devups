
    <?php //use dclass\devups\Form\Form; ?>
    <?php //Form::addcss(Address ::classpath('Resource/js/address')) ?>
    
    <?= Form::open($address, ["action"=> "$action", "method"=> "post"]) ?>

     <div class='form-group'>
                <label for='firstname'>{{t('address.firstname')}}</label>
            	<?= Form::input('firstname', $address->getFirstname(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='description'>{{t('address.description')}}</label>
            	<?= Form::input('description', $address->getDescription(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='creationdate'>{{t('address.creationdate')}}</label>
            	<?= Form::input('creationdate', $address->getCreationdate(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='phonenumber'>{{t('address.phonenumber')}}</label>
            	<?= Form::input('phonenumber', $address->getPhonenumber(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='lastname'>{{t('address.lastname')}}</label>
            	<?= Form::input('lastname', $address->getLastname(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='address'>{{t('address.address')}}</label>
            	<?= Form::input('address', $address->getAddress(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='postalcode'>{{t('address.postalcode')}}</label>
            	<?= Form::input('postalcode', $address->getPostalcode(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='_type'>{{t('address._type')}}</label>
            	<?= Form::input('_type', $address->get_type(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
                <label for='label'>{{t('address.label')}}</label>
            	<?= Form::input('label', $address->getLabel(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'><label for='user'>User</label>
                    <?= Form::select('user', 
                    FormManager::Options_Helper('firstname', User::allrows()),
                    $address->getUser()->getId(),
                    ['class' => 'form-control']); ?>
 </div>
            <div class='form-group'><label for='town'>Town</label>
                    <?= Form::select('town', 
                    FormManager::Options_Helper('id', Town::allrows()),
                    $address->getTown()->getId(),
                    ['class' => 'form-control']); ?>
 </div>
            <div class='form-group'><label for='quarter'>Quarter</label>
                    <?= Form::select('quarter', 
                    FormManager::Options_Helper('id', Quarter::allrows()),
                    $address->getQuarter()->getId(),
                    ['class' => 'form-control']); ?>
 </div>
            
       
    <?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>
    
    <?= Form::close() ?>
    
    <?= Form::addDformjs() ?>    
    <?= Form::addjs(Address::classpath('Resource/js/addressForm')) ?>
    