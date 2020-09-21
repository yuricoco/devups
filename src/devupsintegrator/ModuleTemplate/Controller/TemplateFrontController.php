<?php 


class TemplateFrontController extends TemplateController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Template());
            return $ll;

    }

    public function createAction($template_form = null ){
        $rawdata = \Request::raw();
        $template = $this->hydrateWithJson(new Template(), $rawdata["template"]);
 

        
        $id = $template->__insert();
        return 	array(	'success' => true,
                        'template' => $template,
                        'detail' => '');

    }

    public function updateAction($id, $template_form = null){
        $rawdata = \Request::raw();
            
        $template = $this->hydrateWithJson(new Template($id), $rawdata["template"]);

                  
        
        $template->__update();
        return 	array(	'success' => true,
                        'template' => $template,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $template = Template::find($id);

        return 	array(	'success' => true,
                        'template' => $template,
                        'detail' => '');
          
}       


}
