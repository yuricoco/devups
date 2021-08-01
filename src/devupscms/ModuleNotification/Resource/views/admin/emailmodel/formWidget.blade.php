<?php //use dclass\devups\Form\Form; ?>
<?php //Form::addcss(Reportingmodel ::classpath('Ressource/js/emailmodel')) ?>

<?= Form::open($emailmodel, ["action" => "$action", "method" => "post"], true) ?>

<div class='form-group'>
    <label for='object'>{{t('emailmodel.name')}}</label>
    <?= Form::input('name', $emailmodel->getName(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='object'>{{t('emailmodel.styleressource')}}</label>
    <?= Form::input('styleressource', $emailmodel->getStyleressource(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='object'>{{t('emailmodel.title')}}</label>
    <?= Form::input('title', $emailmodel->getTitle(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='object'>{{t('emailmodel.object')}}</label>
    <?= Form::input('object', $emailmodel->getObject(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='content'>{{t('emailmodel.content')}}</label>
    <?= Form::textarea('content', $emailmodel->getContent(), ['id' => 'editor', 'class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='contenttext'>{{t('emailmodel.contenttext')}}</label>
    <?= Form::textarea('contenttext', $emailmodel->getContenttext(), ['class' => 'form-control']); ?>
</div>


<?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>

<?= Form::close() ?>

    