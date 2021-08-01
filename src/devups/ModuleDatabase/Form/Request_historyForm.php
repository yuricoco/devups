<?php 

        
use Genesis as g;

class Request_historyForm extends FormManager{

    public $request_history;

    public static function init(\Request_history $request_history, $action = ""){
        $fb = new Request_historyForm($request_history, $action);
        $fb->request_history = $request_history;
        return $fb;
    }

    public function buildForm()
    {
    
        
            $this->fields['query'] = [
                "label" => t('request_history.query'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $this->request_history->getQuery(), 
        ];

           
        return  $this;
    
    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("request_history.formWidget", self::getFormData($id, $action));
    }
    
}
    