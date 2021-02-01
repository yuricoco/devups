<?php


use dclass\devups\Controller\Controller;

class Dvups_langController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Dvups_lang(), $next, $per_page);

        self::$jsfiles[] = Dvups_lang::classpath('Ressource/js/dvups_langCtrl.js');

        $this->entitytarget = 'Dvups_lang';
        $this->title = "Manage Dvups_lang";
        
        $this->renderListView(Dvups_langTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Dvups_lang(), $next, $per_page);
        return ['success' => true,
            'datatable' => Dvups_langTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($dvups_lang_form = null){
        extract($_POST);

        $dvups_lang = $this->form_fillingentity(new Dvups_lang(), $dvups_lang_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_lang' => $dvups_lang,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $dvups_lang->__insert();
        return 	array(	'success' => true,
                        'dvups_lang' => $dvups_lang,
                        'tablerow' => Dvups_langTable::init()->buildindextable()->getSingleRowRest($dvups_lang),
                        'detail' => '');

    }

    public function updateAction($id, $dvups_lang_form = null){
        extract($_POST);
            
        $dvups_lang = $this->form_fillingentity(new Dvups_lang($id), $dvups_lang_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_lang' => $dvups_lang,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $dvups_lang->__update();
        return 	array(	'success' => true,
                        'dvups_lang' => $dvups_lang,
                        'tablerow' => Dvups_langTable::init()->buildindextable()->getSingleRowRest($dvups_lang),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Dvups_lang';
        $this->title = "Detail Dvups_lang";

        $dvups_lang = Dvups_lang::find($id);

        $this->renderDetailView(
            Dvups_langTable::init()
                ->builddetailtable()
                ->renderentitydata($dvups_lang)
        );

    }
    
    public function deleteAction($id){
      
            Dvups_lang::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dvups_lang::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
