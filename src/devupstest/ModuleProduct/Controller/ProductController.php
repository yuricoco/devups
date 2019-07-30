<?php 


use DClass\devups\Datatable as Datatable;

class ProductController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Product(), $next, $per_page);

        self::$jsfiles[] = Product::classpath('Ressource/js/productCtrl.js');

        $this->entitytarget = 'Product';
        $this->title = "Manage Product";
        
        $this->renderListView(
            ProductTable::init($lazyloading)
                ->buildindextable()
                ->render()
        );

    }

    public function listdata() {
        return $this->lazyloading(new Product(), 1, 10);
    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Product(), $next, $per_page);
        return ['success' => true,
            'datatable' => ProductTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function detailView($id)
    {

        $this->entitytarget = 'Product';
        $this->title = "Detail Product";

        $product = Product::find($id);

        $this->renderDetailView(
            ProductTable::init()
                ->builddetailtable()
                ->renderentitydata($product)
        );

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
                        'tablerow' => ProductTable::init()->buildindextable()->getSingleRowRest($product),
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
                        'tablerow' => ProductTable::init()->buildindextable()->getSingleRowRest($product),
                        'detail' => '');
                        
    }
    
    public function deleteAction($id){
      
            Product::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Product::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
