<div class='form-group'>
<label for='name'>Name</label>
	<b><?= $dvups_role->getName(); ?></b>
 </div>
<div class='form-group'>
<label for='alias'>Alias</label>
	<b><?= $dvups_role->getAlias(); ?></b>
 </div>
<div class='form-group'>
<label for='dvups_right'>Dvups_right</label>
<ul>
                    <?php foreach ($dvups_role->getDvups_right() as $dvups_right){ 
                        echo '<li>'.$dvups_right->getId().'</li>';
                    } ?></ul>
 </div>
<div class='form-group'>
<label for='dvups_module'>Dvups_module</label>
<ul>
                    <?php foreach ($dvups_role->getDvups_module() as $dvups_module){ 
                        echo '<li>'.$dvups_module->getId().'</li>';
                    } ?></ul>
 </div>
<div class='form-group'>
<label for='dvups_entity'>Dvups_entity</label>
<ul>
                    <?php foreach ($dvups_role->getDvups_entity() as $dvups_entity){ 
                        echo '<li>'.$dvups_entity->getId().'</li>';
                    } ?></ul>
 </div>
