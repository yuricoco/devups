<?php

class ProductForm extends FormManager
{

    public static function formBuilder(\Product $product, $action = null, $button = false)
    {
        $entitycore = new Core($product);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;


        $entitycore->field['name'] = [
            "label" => 'Name',
            "type" => FORMTYPE_TEXT,
            "value" => $product->getName(),
        ];

        $entitycore->field['description'] = [
            "label" => 'Description',
            "type" => FORMTYPE_TEXTAREA,
            "value" => $product->getDescription(),
        ];

        $entitycore->field['image'] = [
            "type" => FORMTYPE_INJECTION,
            FH_REQUIRE => true,
            "label" => 'Image',
            "imbricate" => ImageForm::__renderForm($product->getImage()),
        ];

        $entitycore->field['category'] = [
            "type" => FORMTYPE_SELECT,
            "value" => $product->getCategory()->getId(),
            "label" => 'Category',
            "options" => FormManager::Options_Helper('name', Category::allrows()),
        ];

        $entitycore->field['subcategory'] = [
            "type" => FORMTYPE_SELECT,
            "value" => $product->getSubcategory()->getId(),
            "label" => 'Subcategory',
            "options" => FormManager::Options_Helper('name', Subcategory::allrows()),
        ];

        $entitycore->field['storage'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => FormManager::Options_Helper('town', $product->getStorage()),
            "label" => 'Storage',
            "options" => FormManager::Options_ToCollect_Helper('town', new Storage(), $product->getStorage()),
        ];

        $entitycore->addjs("productForm");

        return $entitycore;
    }

    public static function __renderForm(\Product $product, $action = null, $button = false)
    {
        return FormFactory::__renderForm(ProductForm::formBuilder($product, $action, $button));
    }

    public static function __renderFormWidget(\Product $product, $action_form = null)
    {
        include ROOT . Product::classpath() . "Form/ProductFormWidget.php";
    }

    public static function __renderDetailWidget(\Product $product)
    {
        include ROOT . Product::classpath() . "Form/ProductDetailWidget.php";
    }

}
    