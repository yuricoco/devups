
<?php //Form::addcss(Local_content ::classpath('Ressource/js/local_content')) ?>

<div class='alert alert-info'>
    Pensez en regenerer les données caches des lang
</div>

<div hidden class='form-group'>
    <?= Form::input('id', $local_content_fr->getId(), ['id' => 'dvups-id-edit-fr', 'class' => 'form-control']); ?>
</div>

<div class='form-group'>
    <label for='content'>Content fr</label>
    <?= Form::textarea('content', $local_content_fr->getContent(), ['id' => 'dvups-content-edit-fr', 'class' => 'form-control']); ?>
</div>

<div hidden class='form-group'>
    <?= Form::input('id', $local_content_en->getId(), ['id' => 'dvups-id-edit-en', 'class' => 'form-control']); ?>
</div>

<div class='form-group'>
    <label for='content'>Content en</label>
    <?= Form::textarea('content', $local_content_en->getContent(), ['id' => 'dvups-content-edit-en', 'class' => 'form-control']); ?>
</div>

