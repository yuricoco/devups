<div class='form-group'>
<label for='content'>Content</label>
	<b><?= $dvups_contentlang->getContent(); ?></b>
 </div>
<div class='form-group'>
<label for='lang'>Lang</label>
	<b><?= $dvups_contentlang->getLang(); ?></b>
 </div>
<div class='form-group'>
<label for='dvups_lang'>Dvups_lang</label>
	<?= '<b>'.$dvups_contentlang->getDvups_lang()->getId().'</b>'; ?>
 </div>
