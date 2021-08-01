<?php //use dclass\devups\Form\Form; ?>
<?= Form::addcss(Slide::classpath('Resource/css/slide')) ?>

<?= Form::open($slide, ["action" => "$action", "method" => "post"]) ?>

<div class='form-group'>
    <label for='activated'>{{t('slide.activated')}}</label>
    <?= Form::radio('activated', ["unactive", "activate"], (int) $slide->getActivated(), ['class' => 'form-control']); ?>
</div>

<div class='form-group'>
    <label for='image'>{{t('dv_image.image')}}</label>
    <div class="img-container">
        <?= Form::filepreview($slide->image->getImage(),
            $slide->image->showImage(),
            ['class' => 'form-control'], 'image') ?>
    </div>
<?= Form::file('image', '', ['onchange' => 'slide.init(this)', 'class' => 'form-control'], 'image') ?>

</div>

<div class='form-group'>
    <label for='activated'>{{t('Url redirect')}}</label>
    <?= Form::input('activated', $slide->getRedirect(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'>
    <label for='activated'>{{t('Small description')}}</label>
    <?= Form::input('content', $slide->getContent(), ['class' => 'form-control']); ?>
</div>

<?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>

<?= Form::close() ?>

<?= Form::addDformjs() ?>
