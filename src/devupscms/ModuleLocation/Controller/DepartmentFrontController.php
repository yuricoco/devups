<?php 


class DepartmentFrontController extends DepartmentController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Department(), $next, $per_page);

    }

    public function createAction($department_form = null){
        $rawdata = \Request::raw();
        $department = $this->hydrateWithJson(new Department(), $rawdata["department"]);
 

        
        $id = $department->__insert();
        return 	array(	'success' => true,
                        'department' => $department,
                        'detail' => '');

    }

    public function updateAction($id, $department_form = null){
        $rawdata = \Request::raw();
            
        $department = $this->hydrateWithJson(new Department($id), $rawdata["department"]);

                  
        
        $department->__update();
        return 	array(	'success' => true,
                        'department' => $department,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $department = Department::find($id);

        return 	array(	'success' => true,
                        'department' => $department,
                        'detail' => '');
          
}       


}
