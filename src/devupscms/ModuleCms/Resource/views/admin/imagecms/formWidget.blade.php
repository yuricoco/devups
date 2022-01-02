<?php //use dclass\devups\Form\Form; ?>
<?php //Form::addcss(Slide ::classpath('Resource/js/imagecms')) ?>

<?= Form::open($imagecms, ["action" => "$action", "method" => "post"]) ?>

<div class='form-group'>
    <label for='activated'>{{t('Cms Text')}}</label>
    <?= Form::select('cmstext', FormManager::Options_Helper("title", Cmstext::allrows()), $imagecms->cmstext->getId(), ['class' => 'form-control']); ?>
</div>
<div class='form-group'><label for='dv_image'>Dv_image</label>
    <?php $dv_image = $imagecms->getImage(); ?>
    <?= Form::imbricate($dv_image) ?>
    <div class='form-group'>
        <label for='targeturl'>Folder</label>
        <?= Form::select('folder', FormManager::Options_Helper("name", Tree_item::getmainmenu("folder")),
            $dv_image->folder->getId(), ['placeholder' => '--- folder ---', 'class' => 'form-control']); ?>
    </div>
    <div class='form-group'>
        <label for='image'>{{t('dv_image.image')}}</label>
        <?= Form::filepreview($dv_image->getImage(),
            $dv_image->showImage(),
            ['class' => 'form-control'], 'image') ?>
        <?= Form::file('image',
            $dv_image->getImage(),
            ['class' => 'form-control'], 'image') ?>
    </div>
    <?= Form::closeimbricate() ?>
</div>


<?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>

<?= Form::close() ?>

<?= Form::addDformjs() ?>
<?= Form::addjs(Slide::classpath('Resource/js/imagecmsForm')) ?>
    