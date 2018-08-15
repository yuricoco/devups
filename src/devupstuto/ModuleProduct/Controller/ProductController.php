<?php

class ProductController extends Controller
{

    public static function renderFormWidget($id = null) {
        if($id)
            ProductForm::__renderFormWidget(Product::find($id), 'update');
        else
            ProductForm::__renderFormWidget(new Product(), 'create');
    }

    public static function renderDetail($id) {
        ProductForm::__renderDetailWidget(Product::find($id));
    }

    public static function renderForm($id = null, $action = "create") {
        $product = new Product();
        if($id){
            $action = "update&id=".$id;
            $product = Product::find($id);
            $product->collectStorage();
        }

        return ['success' => true,
            'form' => ProductForm::__renderForm($product, $action, true),
        ];
    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Product(), $next, $per_page);
        return ['success' => true,
            'tablebody' => Genesis::getTableRest($lazyloading),
            'tablepagination' => Genesis::pagination($lazyloading)
        ];
    }

    /**
     * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public function showAction($id)
    {

        $product = Product::find($id);

        return array('success' => true,
            'product' => $product,
            'detail' => 'detail de l\'action.');

    }

    /**
     * Action on creation form
     * @Sequences: controller - genesis - ressource/view/form
     * @return \Array
     */
    public function createAction()
    {
        extract($_POST);
        $this->err = array();

        $product = $this->form_generat(new Product(), $product_form);
        Product::Dfile("image");

        if ($id = $product->__insert()) {
            return array('success' => true, // pour le restservice
                'product' => $product,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'product' => $product,
                'action_form' => 'create', // pour le web service
                'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }

    }
    /**
     * Action on edit form
     * @Sequences: controller - genesis - ressource/view/index
     * @param type $id
     * @return \Array
     */
    public function updateAction($id)
    {
        extract($_POST);
        $this->err = array();

        $product = $this->form_generat(new Product($id), $product_form);
        Product::Dfile("image");

        if ($product->__update()) {
            return array('success' => true,
                'product' => $product,
                'redirect' => 'index',
                'detail' => '');
        } else {
            return array('success' => false,
                'product' => $product,
                'action_form' => 'update&id=' . $id,
                'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }

    /**
     *
     *
     * @param type $id
     * @return \Array
     */
    public function listAction($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Product(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');

    }

    public function deleteAction($id)
    {

        Product::delete($id);

        return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function deletegroupAction($ids)
    {

        Product::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    /**
     * Data for creation form
     * @Sequences: controller - genesis - ressource/view/form
     * @return \Array
     */
    public function __newAction()
    {

        return array('success' => true, // pour le restservice
            'product' => new Product(),
            'action_form' => 'create', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    /**
     * Data for edit form
     * @Sequences: controller - genesis - ressource/view/form
     * @param type $id
     * @return \Array
     */
    public function __editAction($id)
    {

        $product = Product::find($id);
        $product->collectStorage();
        return array('success' => true, // pour le restservice
            'product' => $product,
            'action_form' => 'update&id=' . $id, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
