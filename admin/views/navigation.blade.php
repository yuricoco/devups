<?php
/**
 * Created by PhpStorm.
 * User: yuri coco
 * Date: 29-Jan-16
 * Time: 10:17
 */

$index_ajouter = "index.php?path=$action/new";
$index_modifier = "index.php?path=$action/index";
$index_supprimer = "index.php?path=$action/delete";

if(isset($lien_menu)){
echo '<div class="row">
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 ">
							<h5>'.$lien_menu.'</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="float: right; margin-right: 30px;"  class="panel">';
		if(isset($_SESSION['privilege_avance'][$action])){
			if( in_array('create', $_SESSION['privilege_avance'][$action]) or 
				in_array('read', $_SESSION['privilege_avance'][$action]) ){
				
				if(in_array('create', $_SESSION['privilege_avance'][$action]))
					echo '<a href="'.$index_ajouter.'"  class="btn btn-default" >add</a>';
				else
					echo "";
				
				if(in_array('read', $_SESSION['privilege_avance'][$action]))
					echo '<a href="'.$index_modifier.'" target="_self" class="btn btn-default" >Listing</a> .';
				else
					echo "<span class='alert alert-info' >not rigth for 'list' action </span>";
				
			}else{
				echo "<span class='alert alert-info' >not rigth contact the administrator</span>";
		}}
	echo '</div>';
}else{
	if(isset($_SESSION['privilege_avance'][$action])){
		if( in_array('create', $_SESSION['privilege_avance'][$action]) or 
			in_array('read', $_SESSION['privilege_avance'][$action]) ){
			
			if(in_array('create', $_SESSION['privilege_avance'][$action]))
				echo '<a href="'.$index_ajouter.'"  class="btn btn-default" >add</a>';
			else
				echo "";
			
			if(in_array('read', $_SESSION['privilege_avance'][$action]))
				echo '<a href="'.$index_modifier.'" target="_self" class="btn btn-default" >Listing</a> .';
			else
				echo "<span class='alert alert-info' >not rigth for 'list' action </span>";
			
		}else{
			echo "<span class='alert alert-info' >not rigth contact the administrator</span>";
	}}
}