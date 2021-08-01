<?php


namespace dclass\devups\Controller;

use Request;

trait CrudTrait
{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = self::$tablename::init(new self::$classname)->buildindextable();

        self::$jsfiles[] = self::$classname::classpath('Resource/js/'.self::$entityname.'Ctrl.js');

        $this->entitytarget = self::$classname;
        $this->title = "Manage ".self::$classname;

        $this->renderListView();

    }

    public function datatable($next, $per_page) {

        return ['success' => true,
            'datatable' => self::$tablename::init(new self::$classname())->router()->getTableRest(),
        ];

    }

    public function formView($id = null)
    {
        $dvups_lang = new self::$classname();
        $action = self::$classname::classpath('services.php?path='.self::$entityname.'.create');
        if ($id) {
            $action = self::$classname::classpath('services.php?path='.self::$entityname.'.update&id=' . $id);
            $dvups_lang = self::$classname::find($id);
        }

        return ['success' => true,
            'form' => self::$formname::init($dvups_lang, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function _editAction($id){
        return $this->formView($id);
    }
    public function _newAction(){
        return $this->formView();
    }

    public function createAction($dvups_lang_form = null ){
        extract($_POST);

        $dvups_lang = $this->form_fillingentity(new self::$classname(), $dvups_lang_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                'dvups_lang' => $dvups_lang,
                'action' => 'create',
                'error' => $this->error);
        }

        $id = $dvups_lang->__insert();
        return 	array(	'success' => true,
            'dvups_lang' => $dvups_lang,
            'tablerow' => self::$tablename::init()->router()->getSingleRowRest($dvups_lang),
            'detail' => '');

    }

    public function updateAction($id, $dvups_lang_form = null){
        extract($_POST);

        $dvups_lang = $this->form_fillingentity(new self::$classname($id), $dvups_lang_form);

        if ( $this->error ) {
            return 	array(	'success' => false,
                'dvups_lang' => $dvups_lang,
                'action_form' => 'update&id='.$id,
                'error' => $this->error);
        }

        $dvups_lang->__update();
        return 	array(	'success' => true,
            self::$entityname => $dvups_lang,
            'tablerow' => self::$tablename::init()->router()->getSingleRowRest($dvups_lang),
            'detail' => '');

    }


    public function detailView($id)
    {

        $this->entitytarget = self::$classname;
        $this->title = "Detail ".self::$classname;

        $dvups_lang = self::$classname::find($id);

        $this->renderDetailView(
            self::$tablename::init()
                ->builddetailtable()
                ->renderentitydata($dvups_lang)
        );

    }

    public function deleteAction($id){

        self::$classname::find($id)->__delete();

        return 	array(	'success' => true,
            'detail' => '');
    }


    public function deletegroupAction($ids)
    {

        self::$classname::where("id")->in($ids)->delete();

        return array('success' => true,
            'detail' => '');

    }

}