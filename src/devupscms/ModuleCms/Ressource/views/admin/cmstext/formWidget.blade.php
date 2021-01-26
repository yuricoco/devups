
<div class="row">

    <div class="col-lg-12">

        <?= Form::open($cmstext, ["action" => "$action", "method" => "post"], true) ?>

        <div class='form-group'>
            <label for='lang'>Active</label>
            <?= Form::radio('active', Cmstext::$ACTIVES, $cmstext->getActive(), ['class' => 'form-control']); ?>
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

        @if($tree_item_id = Request::get("tree_item"))
            <div class='form-group'>
                <label for='content'>{{$tree_item->getName()}}</label>
                <?= Form::select('tree_item', FormManager::Options_Helper("id", [$tree_item]), $tree_item_id, ['class' => 'form-control']); ?>
            </div>
        @endif
        <?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>

        <?= Form::close() ?>

    </div>
</div>
