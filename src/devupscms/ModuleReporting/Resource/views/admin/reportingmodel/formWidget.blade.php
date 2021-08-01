<?php //use dclass\devups\Form\Form; ?>
<?php //Form::addcss(Reportingmodel ::classpath('Ressource/js/reportingmodel')) ?>

<?= Form::open($reportingmodel, ["action" => "$action", "method" => "post"], true) ?>

<div class='form-group'>
    <label for='object'>{{t('reportingmodel.name')}}</label>
    <?= Form::input('name', $reportingmodel->getName(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='object'>{{t('reportingmodel.styleressource')}}</label>
    <?= Form::input('styleressource', $reportingmodel->getStyleressource(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='object'>{{t('reportingmodel.title')}}</label>
    <?= Form::input('title', $reportingmodel->getTitle(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='object'>{{t('reportingmodel.object')}}</label>
    <?= Form::input('object', $reportingmodel->getObject(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='content'>{{t('reportingmodel.content')}}</label>
    <?= Form::textarea('content', $reportingmodel->getContent(), ['id' => 'editor', 'class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='contenttext'>{{t('reportingmodel.contenttext')}}</label>
    <?= Form::textarea('contenttext', $reportingmodel->getContenttext(), ['class' => 'form-control']); ?>
</div>


<?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>

<?= Form::close() ?>

    