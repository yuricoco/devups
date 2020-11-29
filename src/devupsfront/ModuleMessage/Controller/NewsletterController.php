<?php


use dclass\devups\Controller\Controller;

class NewsletterController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Newsletter(), $next, $per_page);

        self::$jsfiles[] = Newsletter::classpath('Ressource/js/newsletterCtrl.js');

        $this->entitytarget = 'Newsletter';
        $this->title = "Manage Newsletter";
        
        $this->renderListView(NewsletterTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Newsletter(), $next, $per_page);
        return ['success' => true,
            'datatable' => NewsletterTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($newsletter_form = null){
        extract($_POST);

        $newsletter = $this->form_fillingentity(new Newsletter(), $newsletter_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'newsletter' => $newsletter,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $newsletter->__insert();
        return 	array(	'success' => true,
                        'newsletter' => $newsletter,
                        'tablerow' => NewsletterTable::init()->buildindextable()->getSingleRowRest($newsletter),
                        'detail' => '');

    }

    public function updateAction($id, $newsletter_form = null){
        extract($_POST);
            
        $newsletter = $this->form_fillingentity(new Newsletter($id), $newsletter_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'newsletter' => $newsletter,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $newsletter->__update();
        return 	array(	'success' => true,
                        'newsletter' => $newsletter,
                        'tablerow' => NewsletterTable::init()->buildindextable()->getSingleRowRest($newsletter),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Newsletter';
        $this->title = "Detail Newsletter";

        $newsletter = Newsletter::find($id);

        $this->renderDetailView(
            NewsletterTable::init()
                ->builddetailtable()
                ->renderentitydata($newsletter)
        );

    }
    
    public function deleteAction($id){
      
            Newsletter::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Newsletter::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
