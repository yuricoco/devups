<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 29/03/2019
 * Time: 10:24 AM
 */

class DvAdmin
{

    public static function buildindexdatatable($listemodule, $entity)
    {
        $traitement = new Traitement();
        $listview = [];

        foreach ($entity->attribut as $attribut) {
            if ($attribut->formtype == 'image') {
                $listview[] = "\n['header' => '" . ucfirst($attribut->name) . "', 'value' => 'src:" . $attribut->name . "']";
                $listview[] = "\n['header' => '" . ucfirst($attribut->name) . "', 'value' => '" . $attribut->name . "']";
            } else {
                $listview[] = "\n['header' => '" . ucfirst($attribut->name) . "', 'value' => '" . $attribut->name . "']";
            }
        }

        if (!empty($entity->relation)) {
            foreach ($entity->relation as $relation) {

                if ($relation->cardinality == 'manyToMany')
                    break;

                $entitylink = $traitement->relation($listemodule, $relation->entity);

                if(is_null($entitylink))
                    continue;

                $entrel = ucfirst(strtolower($relation->entity));
                $key = 0;
                $entitylinkattrname = "id";
                $entitylink->attribut = (array)$entitylink->attribut;
                if (isset($entitylink->attribut[1])) {
                    $key = 1;
                    $entitylinkattrname = $entitylink->attribut[$key]->name;
                }

                $listview[] = "\n['header' => '" . $entrel . "', 'value' => '" . $entrel . "." . $entitylinkattrname . "']";
            }
        }

        $index = "[" . implode(', ', $listview) . "\n]";

        return $index;

    }

    public static function buildformcontent($name)
    {

        $new_edit = "
                    <div class=\"col-lg-12\" >

                                    <?= " . ucfirst($name) . "Form::__renderForm($" . $name . ", $" . "action_form, true); ?>

                        </div>";
    }

    public static function buildshowcontent($name)
    {
        $show = "
                    <div class=\"col-lg-12 col-md-12\">
                    
			<?php " . ucfirst($name) . "Form::__renderDetailWidget($" . $name . "); ?>
			
	<div class=\"form-group text-center\">
		<?php //echo Genesis::actionListView(\"" . $name . "\", $" . $name . "->getId()); ?>
	</div>
	
	</div>
					";
    }

}