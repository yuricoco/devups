<?php


use dclass\devups\Controller\Controller;

class DepartmentController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Department(), $next, $per_page);

        self::$jsfiles[] = Department::classpath('Ressource/js/departmentCtrl.js');

        $this->entitytarget = 'Department';
        $this->title = "Manage Department";
        
        $this->renderListView(DepartmentTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Department(), $next, $per_page);
        return ['success' => true,
            'datatable' => DepartmentTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($department_form = null){
        extract($_POST);

        $department = $this->form_fillingentity(new Department(), $department_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'department' => $department,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $department->__insert();
        return 	array(	'success' => true,
                        'department' => $department,
                        'tablerow' => DepartmentTable::init()->buildindextable()->getSingleRowRest($department),
                        'detail' => '');

    }

    public function updateAction($id, $department_form = null){
        extract($_POST);
            
        $department = $this->form_fillingentity(new Department($id), $department_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'department' => $department,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $department->__update();
        return 	array(	'success' => true,
                        'department' => $department,
                        'tablerow' => DepartmentTable::init()->buildindextable()->getSingleRowRest($department),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Department';
        $this->title = "Detail Department";

        $department = Department::find($id);

        $this->renderDetailView(
            DepartmentTable::init()
                ->builddetailtable()
                ->renderentitydata($department)
        );

    }
    
    public function deleteAction($id){
      
            Department::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Department::delete()->where("id")->in($ids);

        return array('success' => true,
                'detail' => ''); 

    }

}
