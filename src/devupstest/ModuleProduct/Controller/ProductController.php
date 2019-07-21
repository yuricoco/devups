<?php 


use DClass\devups\Datatable as Datatable;

class ProductController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Product(), $next, $per_page);

        self::$jsfiles[] = Product::classpath('Ressource/js/productCtrl.js');

        $this->entitytarget = 'Product';
        $this->title = "Manage Product";
        $datatablemodel = [
['header' => 'Name', 'value' => 'name'], 
['header' => 'Price', 'value' => 'price'], 
['header' => 'Description', 'value' => 'description'], 
['header' => 'Category', 'value' => 'Category.id']
];
        
        $this->renderListView(
            Datatable::buildtable($lazyloading, $datatablemodel)
                ->render()
        );

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Product(), $next, $per_page);
        return ['success' => true,
            'datatable' => Datatable::getTableRest($lazyloading),
        ];
    }

    public function createAction($product_form = null){
        extract($_POST);

        $product = $this->form_fillingentity(new Product(), $product_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'product' => $product,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $product->__insert();
        return 	array(	'success' => true,
                        'product' => $product,
                        'tablerow' => Datatable::getSingleRowRest($product),
                        'detail' => '');

    }

    public function updateAction($id, $product_form = null){
        extract($_POST);
            
        $product = $this->form_fillingentity(new Product($id), $product_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'product' => $product,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $product->__update();
        return 	array(	'success' => true,
                        'product' => $product,
                        'tablerow' => Datatable::getSingleRowRest($product),
                        'detail' => '');
                        
    }
    
    public function deleteAction($id){
      
            Product::delete($id);
        return 	array(	'success' => true, // pour le restservice
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

}
