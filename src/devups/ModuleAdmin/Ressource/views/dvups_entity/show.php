
			<div class="row">
				<div class="col-lg-12">
					<ol class="breadcrumb">
						<li class="active">
							<i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Detail 
						</li>
					</ol>
				</div>
				<div class="col-lg-12"><?= $__navigation  ?></div>
			</div>
			<div class="row">
						
			<div class="col-lg-12 col-md-12">
			
		<div class="form-group">
				<h4>Dvups_module</h4>
                <?php echo $dvups_entity->getDvups_module()->getName(); ?>
        </div> 
		<div class="form-group">
			<label>Dvups_right dvups_entity</label>
                  <?php 
                  if($dvups_entity->getDvups_right() and $dvups_entity->getDvups_right()[0]->getId()) {
                      foreach ($dvups_entity->getDvups_right() as $dvups_right){ 
					echo '
                <label class="checkbox-inline">
						'.$dvups_right->getName().'
                </label>'; 
				}} ?>
		</div> 
		
			
	<div class="form-group text-center">
		<a href="index.php?path=dvups_entity/edit&id=<?php echo $dvups_entity->getId(); ?>" class="btn btn-default">Modifier</a>
		<a href="index.php?path=dvups_entity/delete&valid=oui&id=<?php echo $dvups_entity->getId(); ?>" class="btn btn-default">Supprimer</a>
	</div>
	
	</div>
					
			</div>