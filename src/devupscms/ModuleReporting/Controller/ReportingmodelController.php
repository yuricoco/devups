<?php


use dclass\devups\Controller\Controller;

class ReportingmodelController extends Controller
{

    public function __construct()
    {
        $this->entity = new Reportingmodel();
    }

    public function listView($next = 1, $per_page = 10)
    {

        $this->datatable = ReportingmodelTable::init(new Reportingmodel())->buildindextable();

        self::$jsfiles[] = Reportingmodel::classpath('Resource/js/reportingmodelCtrl.js');

        $this->entitytarget = 'Reportingmodel';
        $this->title = "Manage Reportingmodel";

        $this->renderListView();

    }

    public function datatable($next, $per_page)
    {

        return ['success' => true,
            'datatable' => ReportingmodelTable::init(new Reportingmodel())->buildindextable()->getTableRest(),
        ];

    }

    public function editmailView($id = null)
    {

        self::$jsfiles[] = Reportingmodel::classpath('Resource/js/reportingmodelCtrl.js');

        $action = Reportingmodel::classpath("services.php?path=reportingmodel.update-email&id=" . $id);
        $reportingmodel = Reportingmodel::find($id);
        $langs = Dvups_lang::all();
        Genesis::renderView("admin.reportingmodel.form", [
            "success" => true,
            "reportingmodel" => $reportingmodel,
            "action" => $action,
            "langs" => $langs,
        ]);
    }

    public function formView($id = null)
    {
        $reportingmodel = new Reportingmodel();
        $action = Reportingmodel::classpath("services.php?path=reportingmodel.create");
        if ($id) {
            self::$jsfiles[] = Reportingmodel::classpath('Resource/js/reportingmodelCtrl.js');

            $action = Reportingmodel::classpath("services.php?path=reportingmodel.update&id=" . $id);
            $reportingmodel = Reportingmodel::find($id);

            return ['success' => true,
                'form' => ReportingmodelForm::init($reportingmodel, $action)
                    ->buildForm()
                    ->addDformjs()
                    ->renderForm(),
            ];
        }

        return ['success' => true,
            'form' => ReportingmodelForm::init($reportingmodel, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($reportingmodel_form = null)
    {
        extract($_POST);

        $reportingmodel = $this->form_fillingentity(new Reportingmodel(), $reportingmodel_form);
        if ($this->error) {
            return //Genesis::renderView("reportingmodel.form",
                array('success' => false,
                    'error' => $this->error);//);
        }

        $reportingmodel->dvid_lang = "fr";
        $id = $reportingmodel->__insert();
        //return redirect(Reportingmodel::classpath("reportingmodel/index"));

        return array('success' => true,
            'reportingmodel' => $reportingmodel,
            'tablerow' => ReportingmodelTable::init()->buildindextable()->getSingleRowRest($reportingmodel),
            'detail' => '');

    }

    public function updateAction($id, $reportingmodel_form = null)
    {
        extract($_POST);

        $reportingmodel = $this->form_fillingentity(new Reportingmodel($id), $reportingmodel_form);

        if ($this->error) {
            return //Genesis::renderView("reportingmodel.form",
                array('success' => false,
                    'error' => $this->error);//);
        }

        $reportingmodel->__update();
        return array('success' => true,
            'reportingmodel' => $reportingmodel,
            'tablerow' => ReportingmodelTable::init()->buildindextable()->getSingleRowRest($reportingmodel),
            'detail' => '');

    }

    public function updateMailAction($id, $reportingmodel_form = null)
    {
        extract($_POST);

        $reportingmodel = $this->form_fillingentity(new Reportingmodel($id), $reportingmodel_form);

        if ($this->error) {
            return Genesis::renderView("reportingmodel.form", array('success' => false,
                'reportingmodel' => $reportingmodel,
                'action_form' => 'update&id=' . $id,
                'error' => $this->error));
        }

        $reportingmodel->__update();
        redirect(Reportingmodel::classpath("reportingmodel/index"));

    }


    public function detailView($id)
    {

        $this->entitytarget = 'Reportingmodel';
        $this->title = "Detail Reportingmodel";

        $reportingmodel = Reportingmodel::find($id);

        $this->renderDetailView(
            ReportingmodelTable::init()
                ->builddetailtable()
                ->renderentitydata($reportingmodel)
        );

    }

    public function deleteAction($id)
    {

        Reportingmodel::delete($id);
        return array('success' => true,
            'detail' => '');
    }


    public function deletegroupAction($ids)
    {

        Reportingmodel::delete()->where("id")->in($ids);

        return array('success' => true,
            'detail' => '');

    }

    public function testmail($id, $email)
    {
        $this->testmailAction($id, $email);
    }
    public function testmailAction($id, $email)
    {
        return Reportingmodel::find($id, 1)
            ->addReceiver($email, "devups developer")
            ->sendMail([
                "activationcode" => "ddddd",
                "username" => "devups developer",
            ]);

    }

    public function loadContent($name)
    {
        $local = local();
        $filename = Reportingmodel::classroot("Resource/partial/{$name}_$local.html");
        if (!file_exists($filename))
            return [
                "success" => false,
                "detail" => t("Le fichier :file n existe pas!", ["file" => $filename]),
            ];
        $content = file_get_contents($filename);
        return [
            "success" => true,
            "content" => $content,
            "detail" => t("Contenu enregistrer avec sucess"),
        ];
    }

    public function saveContent($id)
    {
        $local = local();
        $rm = Reportingmodel::find($id, Dvups_lang::getByIsoCode($local)->id);

        $filename = Reportingmodel::classroot("Resource/partial");
        \DClass\lib\Util::log($rm->content, "{$rm->name}_$local.html", $filename);

        return [
            "success" => true,
            "detail" => t("Contenu enregistrer avec sucess"),
        ];
    }

    public function downloadContent($id)
    {
        $local = local();
        $rm = Reportingmodel::find($id, Dvups_lang::getByIsoCode($local)->id);

        $fileName = "{$rm->name}_$local.html";

        header('Content-Type: text/html; charset=windows-1252');
        //header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        echo $rm->content;

        exit;
    }

}
