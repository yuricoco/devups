
<div class="row">

    <div class="col-lg-12">

        <?= Form::open($cmstext, ["action" => "$action", "method" => "post"], true) ?>

        <div class='form-group'>
            <label for='lang'>Lang</label>
            <?= Form::radio('lang', Cmstext::$LANGS, $cmstext->getLang(), ['class' => 'form-control']); ?>
        </div>
        <div class='form-group'>
            <label for='lang'>Active</label>
            <?= Form::radio('active', Cmstext::$ACTIVES, $cmstext->getActive(), ['class' => 'form-control']); ?>
        </div>
        <div class='form-group'>
            <label for='lang'>Position</label>
            <?= Form::input('position', $cmstext->getPosition(), ['class' => 'form-control'], FORMTYPE_NUMBER); ?>
        </div>
        <div class='form-group'>
            <label for='lang'>Reference</label>
            <?= Form::input('reference', $cmstext->getReference(), ['class' => 'form-control']); ?>
        </div>

        <div class='form-group'>
            <label for='titre'>Titre</label>
            <?= Form::input('title', $cmstext->getTitle(), ['class' => 'form-control']); ?>
        </div>

        <div class='form-group'>
            <label for='content'>Content</label>
            <?= Form::textarea('content', $cmstext->getContent(), ['class' => 'form-control', 'id' => 'editor']); ?>
        </div>

        <div class='form-group'>
            <label for='content'>Sommary</label>
            <?= Form::textarea('sommary', $cmstext->getSommary(), ['class' => 'form-control']); ?>
        </div>
        <?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>

        <?= Form::close() ?>

    </div>
</div>
