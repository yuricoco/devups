
    <?= Form::open($product, ["action"=> " $action_form", "method"=> "post"]) ?>

     <div class='form-group'>
<label for='name'>Name</label>
	<?= Form::input('name', $product->getName(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='description'>Description</label>
	<?= Form::textarea('description', $product->getDescription(), ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='image'>Image</label>
<?php $image = $product->getImage(); ?>
                    <?= Form::imbricate($image) ?><div class='form-group'>
<label for='image'>Image</label>
	<?= Form::file('image', 
                $image->getImage(),
                $image->showImage(),
                 ['class' => 'form-control'], 'image') ?>
 </div>
<?= Form::closeimbricate() ?>
 </div>
<div class='form-group'>
<label for='category'>Category</label>

                    <?= Form::select('category', 
                    FormManager::Options_Helper('id', Category::allrows()),
                    $product->getCategory()->getId(),
                    ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='subcategory'>Subcategory</label>

                    <?= Form::select('subcategory', 
                    FormManager::Options_Helper('id', Subcategory::allrows()),
                    $product->getSubcategory()->getId(),
                    ['class' => 'form-control']); ?>
 </div>
<div class='form-group'>
<label for='storage'>Storage</label>

                    <?= Form::checkbox('storage', 
                    FormManager::Options_ToCollect_Helper('id', new Storage(), $product->getStorage()),
                    FormManager::Options_Helper('id', $product->getStorage()),
                    ['class' => 'form-control']); ?>
 </div>


    <?= Form::submit("save", ['class' => 'btn btn-success']) ?>

    <?= Form::addDformjs() ?>
    <?= Form::addjs("productForm") ?>

    <?= Form::close() ?>
