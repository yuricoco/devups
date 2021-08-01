<?php 

        
use Genesis as g;

class EmaillogForm extends FormManager{

    public $emaillog;

    public static function init(\Emaillog $emaillog, $action = ""){
        $fb = new EmaillogForm($emaillog, $action);
        $fb->emaillog = $emaillog;
        return $fb;
    }

    public function buildForm()
    {
    
        
            $this->fields['object'] = [
                "label" => t('emaillog.object'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $this->emaillog->getObject(), 
        ];

            $this->fields['log'] = [
                "label" => t('emaillog.log'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $this->emaillog->getLog(), 
        ];

           
        return  $this;
    
    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("emaillog.formWidget", self::getFormData($id, $action));
    }
    
}
    