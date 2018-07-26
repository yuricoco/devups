
<div class='form-group'>
    <label for='storage'>Storage</label>
    <ul>
        <?php
        $storages = $product->__hasmany('storage');

        foreach ($storages as $storage){
            echo '<li>'.$storage->getId().'</li>';
        }
        ?></ul>
</div>
<div class='form-group'>
<label for='name'>Name</label>
	<b><?= $product->getName(); ?></b>
 </div>
<div class='form-group'>
<label for='description'>Description</label>
	<p><?= $product->getDescription(); ?></p>
 </div>
<div class='form-group'>
<label for='image'>Image</label>
<div><?php $image = $product->getImage(); ?><div class='form-group'>
<label for='image'>Image</label>
	<img width="100" src="<?= $image->showImage(); ?>" />
 </div>
</div>
 </div>
<div class='form-group'>
<label for='category'>Category</label>
	<?= '<b>'.$product->getCategory()->getId().'</b>'; ?>
 </div>
<div class='form-group'>
<label for='subcategory'>Subcategory</label>
	<?= '<b>'.$product->getSubcategory()->getId().'</b>'; ?>
 </div>
