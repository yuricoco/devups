<?php  ?>
<?php //Form::addcss(Dvups_role ::classpath('Ressource/js/dvups_role')) ?>

<?= Form::open($dvups_role, ["action" => "$action", "method" => "post"]) ?>

<div class='text-left'>
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

        <?= Form::checkbox('dvups_right', FormManager::Options_Helper('name', Dvups_right::allrows()),
            $dvups_role->inCollectionOf("dvups_right"), ['class' => 'form-control']); ?>
    </div>
    <label for='dvups_module'>Dvups_module</label>
    <ul class=''>
        @foreach($modules as $module)
            <li class='form-group'>
                <label class='form-group '>
                    <?= Form::input('dvups_module', [$module->getId(), $value_modules], ['class' => 'form-control'], "checkbox"); ?>
                    {{$module->getName()}}
                </label>
                <ul class=''>
                    <label for='dvups_module'>Dvups_Entities</label>
                    @foreach($module->__hasmany(Dvups_entity::class) as $entity)
                        <li class='form-group'>
                            <label class='form-group '>
                                <?= Form::input('dvups_entity', [$entity->getId(), $value_entities], ['class' => 'form-control'], "checkbox"); ?>
                                {{$entity->getName()}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

</div>

<?= Form::submitbtn("save", ['class' => 'btn btn-success']) ?>

<?= Form::close() ?>

<?= Form::addDformjs() ?>
<?= Form::addjs(Dvups_role::classpath('Ressource/js/dvups_roleForm')) ?>
    