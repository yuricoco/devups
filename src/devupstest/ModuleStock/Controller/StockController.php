<?php 


use DClass\devups\Datatable as Datatable;

class StockController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Stock(), $next, $per_page);

        self::$jsfiles[] = Stock::classpath('Ressource/js/stockCtrl.js');

        $this->entitytarget = 'Stock';
        $this->title = "Manage Stock";
        
        $this->renderListView(StockTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Stock(), $next, $per_page);
        return ['success' => true,
            'datatable' => StockTable::init($lazyloading)->buildindextable()->getTableRest(),
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
                        'tablerow' => StockTable::init()->buildindextable()->getSingleRowRest($stock),
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
                        'tablerow' => StockTable::init()->buildindextable()->getSingleRowRest($stock),
                        'detail' => '');
                        
    }
    
    public function deleteAction($id){
      
            Stock::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Stock::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
