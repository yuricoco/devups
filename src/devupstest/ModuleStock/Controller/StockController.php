<?php 


use DClass\devups\Datatable as Datatable;

class StockController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Stock(), $next, $per_page);

        self::$jsfiles[] = Stock::classpath('Ressource/js/stockCtrl.js');

        $this->entitytarget = 'Stock';
        $this->title = "Manage Stock";
        $datatablemodel = [
['header' => 'Name', 'value' => 'name']
];
        
        $this->renderListView(
            Datatable::buildtable($lazyloading, $datatablemodel)
                ->render()
        );

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Stock(), $next, $per_page);
        return ['success' => true,
            'datatable' => Datatable::getTableRest($lazyloading),
        ];
    }

    public function createAction($stock_form = null){
        extract($_POST);

        $stock = $this->form_fillingentity(new Stock(), $stock_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'stock' => $stock,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $stock->__insert();
        return 	array(	'success' => true,
                        'stock' => $stock,
                        'tablerow' => Datatable::getSingleRowRest($stock),
                        'detail' => '');

    }

    public function updateAction($id, $stock_form = null){
        extract($_POST);
            
        $stock = $this->form_fillingentity(new Stock($id), $stock_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'stock' => $stock,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $stock->__update();
        return 	array(	'success' => true,
                        'stock' => $stock,
                        'tablerow' => Datatable::getSingleRowRest($stock),
                        'detail' => '');
                        
    }
    
    public function deleteAction($id){
      
            Stock::delete($id);
        return 	array(	'success' => true, // pour le restservice
                        'redirect' => 'index', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }
    

    public function deletegroupAction($ids)
    {

        Stock::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
