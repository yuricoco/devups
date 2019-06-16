<?php


use DClass\devups\Datatable as Datatable;

class StorageController extends Controller
{

    public function listView($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Storage(), $next, $per_page);

        self::$jsfiles[] = Storage::classpath('Ressource/js/storageCtrl.js');

        $this->entitytarget = 'Storage';
        $this->title = "Manage Storage";
        $datatablemodel = [
            ['header' => 'Name', 'value' => 'name']
        ];

        $this->renderListView($lazyloading, $datatablemodel);

    }

    public function datatable($next, $per_page)
    {
        $lazyloading = $this->lazyloading(new Storage(), $next, $per_page);
        return ['success' => true,
            'datatable' => Datatable::getTableRest($lazyloading),
        ];
    }

    public function createAction($storage_form = null)
    {
        extract($_POST);

        $storage = $this->form_fillingentity(new Storage(), $storage_form);

        if ($this->error) {
            return array('success' => false,
                'storage' => $storage,
                'action_form' => 'create',
                'error' => $this->error);
        }

        $id = $storage->__insert();
        return array('success' => true,
            'storage' => $storage,
            'tablerow' => Datatable::getSingleRowRest($storage),
            'detail' => '');

    }

    public function updateAction($id, $storage_form = null)
    {
        extract($_POST);

        $storage = $this->form_fillingentity(new Storage($id), $storage_form);


        if ($this->error) {
            return array('success' => false,
                'storage' => $storage,
                'action_form' => 'update&id=' . $id,
                'error' => $this->error);
        }

        $storage->__update();
        return array('success' => true,
            'storage' => $storage,
            'tablerow' => Datatable::getSingleRowRest($storage),
            'detail' => '');

    }

    public function deleteAction($id)
    {

        Storage::delete($id);
        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    public function deletegroupAction($ids)
    {

        Storage::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
