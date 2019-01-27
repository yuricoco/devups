<div class='form-group'>
<label for='name'>Name</label>
	<b><?= $dvups_entity->getName(); ?></b>
 </div>
<div class='form-group'>
<label for='dvups_module'>Dvups_module</label>
	<?= '<b>'.$dvups_entity->getDvups_module()->getId().'</b>'; ?>
 </div>
<div class='form-group'>
<label for='dvups_right'>Dvups_right</label>
<ul>
                    <?php foreach ($dvups_entity->getDvups_right() as $dvups_right){ 
                        echo '<li>'.$dvups_right->getId().'</li>';
                    } ?></ul>
 </div>
