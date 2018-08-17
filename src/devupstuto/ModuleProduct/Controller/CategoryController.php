<?php


use DClass\devups\Datatable as Datatable;

class CategoryController extends Controller
{


    public static function renderFormWidget($id = null)
    {
        if ($id)
            CategoryForm::__renderFormWidget(Category::find($id), 'update');
        else
            CategoryForm::__renderFormWidget(new Category(), 'create');
    }

    public static function renderDetail($id)
    {
        CategoryForm::__renderDetailWidget(Category::find($id));
    }

    public static function renderForm($id = null, $action = "create")
    {
        $category = new Category();
        if ($id) {
            $action = "update&id=" . $id;
            $category = Category::find($id);
            //$category->collectStorage();
        }

        return ['success' => true,
            'form' => CategoryForm::__renderForm($category, $action, true),
        ];
    }

    public function datatable($next, $per_page)
    {
        $lazyloading = $this->lazyloading(new Category(), $next, $per_page);
        return ['success' => true,
            'tablebody' => Datatable::getTableRest($lazyloading),
            'tablepagination' => Datatable::pagination($lazyloading)
        ];
    }

    public function listAction($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Category(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');

    }

    public function showAction($id)
    {

        $category = Category::find($id);

        return array('success' => true,
            'category' => $category,
            'detail' => 'detail de l\'action.');

    }

    public function createAction()
    {
        extract($_POST);
        $this->err = array();

        $category = $this->form_generat(new Category(), $category_form);

        if ($id = $category->__insert()) {
            return array('success' => true, // pour le restservice
                'category' => $category,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'category' => $category,
                'action_form' => 'create', // pour le web service
                'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }

    }

    public function updateAction($id)
    {
        extract($_POST);

        $category = $this->form_generat(new Category($id), $category_form);

        if ($category->__update()) {
            return array('success' => true, // pour le restservice
                'category' => $category,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'category' => $category,
                'action_form' => 'update&id=' . $id, // pour le web service
                'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }

    public function deleteAction($id)
    {

        Category::delete($id);
        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }


    public function deletegroupAction($ids)
    {

        Category::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __newAction()
    {

        return array('success' => true, // pour le restservice
            'category' => new Category(),
            'action_form' => 'create', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __editAction($id)
    {

        $category = Category::find($id);

        return array('success' => true, // pour le restservice
            'category' => $category,
            'action_form' => 'update&id=' . $id, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
