<?php


use Genesis as g;

class Dv_imageForm extends FormManager
{

    public $dv_image;

    public static function init(\Dv_image $dv_image, $action = "")
    {
        $fb = new Dv_imageForm($dv_image, $action);
        $fb->dv_image = $dv_image;
        return $fb;
    }

    public function buildForm()
    {


        $this->fields['tree_item\\folder.id'] = [
            "label" => t('Folder'),
            "type" => FORMTYPE_SELECT,
            "value" => $this->dv_image->folder->getId(),
            "placeholder" => '--- choose a folder ---',
            "options" => FormManager::Options_Helper("name", Tree_item::getmainmenu("folder", 1)),
        ];
        $this->fields['image'] = [
            "label" => t('dv_image.image'),
            "type" => FORMTYPE_FILE,
            "filetype" => FILETYPE_IMAGE,
            "value" => $this->dv_image->getImage(),
            "src" => $this->dv_image->showImage(),
        ];

        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("dv_image.formWidget", self::getFormData($id, $action));
    }

}
    