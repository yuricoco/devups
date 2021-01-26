<?php


use dclass\devups\Controller\Controller;

class TemplateController extends Controller
{

    public function listView($next = 1, $per_page = 10)
    {

        $this->datatable = TemplateTable::init(new Template())->buildindextable();

        self::$jsfiles[] = Template::classpath('Ressource/js/templateCtrl.js');

        $this->entitytarget = 'Template';
        $this->title = "Manage Template";

        $this->renderListView();

    }

    public function datatable($next, $per_page)
    {

        return ['success' => true,
            'datatable' => TemplateTable::init(new Template())->buildindextable()->getTableRest(),
        ];

    }

    public function createAction($template_form = null)
    {
        extract($_POST);

        $template = $this->form_fillingentity(new Template(), $template_form);
        if ($this->error) {
            return array('success' => false,
                'template' => $template,
                'action' => 'create',
                'error' => $this->error);
        }


        $id = $template->__insert();
        return array('success' => true,
            'template' => $template,
            'tablerow' => TemplateTable::init()->buildindextable()->getSingleRowRest($template),
            'detail' => '');

    }

    public function updateAction($id, $template_form = null)
    {
        extract($_POST);

        $template = $this->form_fillingentity(new Template($id), $template_form);

        if ($this->error) {
            return array('success' => false,
                'template' => $template,
                'action_form' => 'update&id=' . $id,
                'error' => $this->error);
        }

        $template->__update();
        return array('success' => true,
            'template' => $template,
            'tablerow' => TemplateTable::init()->buildindextable()->getSingleRowRest($template),
            'detail' => '');

    }


    public function detailView($id)
    {

        $this->entitytarget = 'Template';
        $this->title = "Detail Template";

        $template = Template::find($id);

        $this->renderDetailView(
            TemplateTable::init()
                ->builddetailtable()
                ->renderentitydata($template)
        );

    }

    public function deleteAction($id)
    {

        Template::delete($id);
        return array('success' => true,
            'detail' => '');
    }


    public function deletegroupAction($ids)
    {

        Template::where("id")->in($ids)->delete();

        return array('success' => true,
            'detail' => '');

    }

}
