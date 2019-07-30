<?php 


use DClass\devups\Datatable as Datatable;

class CategoryController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Category(), $next, $per_page);

        self::$jsfiles[] = Category::classpath('Ressource/js/categoryCtrl.js');

        $this->entitytarget = 'Category';
        $this->title = "Manage Category";
        
        $this->renderListView(CategoryTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Category(), $next, $per_page);
        return ['success' => true,
            'datatable' => CategoryTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($category_form = null){
        extract($_POST);

        $category = $this->form_fillingentity(new Category(), $category_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'category' => $category,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $category->__insert();
        return 	array(	'success' => true,
                        'category' => $category,
                        'tablerow' => CategoryTable::init()->buildindextable()->getSingleRowRest($category),
                        'detail' => '');

    }

    public function updateAction($id, $category_form = null){
        extract($_POST);
            
        $category = $this->form_fillingentity(new Category($id), $category_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'category' => $category,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $category->__update();
        return 	array(	'success' => true,
                        'category' => $category,
                        'tablerow' => CategoryTable::init()->buildindextable()->getSingleRowRest($category),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Category';
        $this->title = "Detail Category";

        $category = Category::find($id);

        $this->renderDetailView(
            CategoryTable::init()
                ->builddetailtable()
                ->renderentitydata($category)
        );

    }
    
    public function deleteAction($id){
      
            Category::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Category::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
