<?php  ?>
<?php //Form::addcss(Dvups_role ::classpath('Ressource/js/dvups_role')) ?>

<?= Form::open($dvups_role, ["action" => "$action", "method" => "post"]) ?>

<div class='form-group'>
    <label for='name'>{{t('dvups_role.name')}}</label>
    <?= Form::input('name', $dvups_role->getName(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='alias'>{{t('dvups_role.alias')}}</label>
    <?= Form::input('alias', $dvups_role->getAlias(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='dvups_right'>Dvups_right</label>

    <?= Form::checkbox('dvups_right',
        FormManager::Options_Helper('name', Dvups_right::all()),
        $dvups_role->inCollectionOf("dvups_right"),
        ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='dvups_module'>Dvups_module</label>

    <?= Form::checkbox('dvups_module',
        FormManager::Options_Helper('name', Dvups_module::all()),
        $dvups_role->inCollectionOf("dvups_module"),
        ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='dvups_entity'>Dvups_entity</label>

    <?= Form::checkbox('dvups_entity',
        FormManager::Options_Helper('name', Dvups_entity::all()),
        $dvups_role->inCollectionOf("dvups_entity"),
        ['class' => 'form-control']); ?>
</div>


<?= Form::submit("save", ['class' => 'btn btn-success']) ?>

<?= Form::close() ?>

<?= Form::addDformjs() ?>
<?= Form::addjs(Dvups_role::classpath('Ressource/js/dvups_roleForm')) ?>
    