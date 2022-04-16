<?php  ?>
<?php //Form::addcss(Dvups_role ::classpath('Ressource/js/dvups_role')) ?>

<?= Form::open($dvups_role, ["action" => Dvups_role::classpath("services.php?path=dvups_role.$action"), "method" => "post"]) ?>

<div class='text-left'>
    <div class='form-group'>
        <label for='name'>{{t('Role name')}} </label>
        <?= Form::input('name', $dvups_role->getName(), ['class' => 'form-control']); ?>
    </div>
    <div class='form-group'>
        <label for='alias'>{{t('Alias for commun')}}</label>
        <?= Form::input('alias', $dvups_role->getAlias(), ['class' => 'form-control']); ?>
    </div>
    <div class='form-group'>
        <label for='dvups_right'>Dvups_right</label>
        <?= Form::checkbox('dvups_right::values', FormManager::Options_Helper('name', Dvups_right::allrows()),
            $dvups_role->inCollectionOf("dvups_right"), ['class' => 'form-control']); ?>
    </div>
    <label for='dvups_module'>Dvups_module</label>
    <table class='table'>
        <tr>
            <td>Component</td>
            <td></td>
        </tr>
        @foreach($components as $component)
            <tr class='form-group'>
                <th class='form-group '>
                    <?= Form::input('dvups_component::values', [$component->getId(), $value_components], ['class' => ''], "checkbox"); ?>
                    {{$component->getName()}}
                </th>
                <td>
                    <table class='table'>
                        @foreach($component->__hasmany(Dvups_module::class) as $module)
                            <tr class='form-group'>
                                <th class='form-group '>
                                    <?= Form::input('dvups_module::values', [$module->getId(), $value_modules], ['class' => ''], "checkbox"); ?>
                                    {{$module->getName()}}
                                </th>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class='row pl-6'>
                                        @foreach($module->__hasmany(Dvups_entity::class) as $entity)
                                            <div class="col-lg-3">
                                                <label class='form-group '>
                                                    <?= Form::input('dvups_entity::values', [$entity->getId(), $value_entities], ['class' => ''], "checkbox"); ?>
                                                    {{$entity->getName()}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
    </table>

</div>

<?= Form::submitbtn("save", ['class' => 'btn btn-success']) ?>

<?= Form::close() ?>

<?= Form::addDformjs() ?>
<?= Form::addjs(Dvups_role::classpath('Ressource/js/dvups_roleForm')) ?>
    