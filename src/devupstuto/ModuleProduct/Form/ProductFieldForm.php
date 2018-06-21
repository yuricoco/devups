<?= Form::open($product, ["action"=> " $action_form", "method"=> "post"]) ?>

     
	<?= Form::input('name', $product->getName(), ['class' => 'form-control']); ?>
 

	<?= Form::textarea('description', $product->getDescription(), ['class' => 'form-control']); ?>
 
<?php $image = $product->getImage(); ?>
                    <?= Form::imbricate($image) ?>
	<?= Form::file('image', 
                $image->getImage(),
                $image->showImage(),
                 ['class' => 'form-control'], 'image') ?>
 
<?= Form::closeimbricate() ?>

                    <?= Form::select('category', 
                    FormManager::Options_Helper('name', Category::allrows()),
                    $product->getCategory()->getId(),
                    ['class' => 'form-control']); ?>

                    <?= Form::select('subcategory', 
                    FormManager::Options_Helper('name', Subcategory::allrows()),
                    $product->getSubcategory()->getId(),
                    ['class' => 'form-control']); ?>

                    <?= Form::checkbox('storage', 
                    FormManager::Options_ToCollect_Helper('town', new Storage(), $product->getStorage()),
                    FormManager::Options_Helper('town', $product->getStorage()),
                    ['class' => 'form-control']); ?>

        
     <?= Form::submit("save", ['class' => 'btn btn-success']) ?>
     <?= Form::reset("reset", ['class' => 'btn btn-warning']) ?>
     <?= Form::close() ?>