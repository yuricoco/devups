<?php


class CmstextFrontController extends CmstextController
{

    public static function documentView()
    {
        $collection = [];
        $list = Tree_item::getmainmenu("documentation");
        foreach ($list as $el) {
            $collection[] = [
                "item" => $el,
                "children" => $el->getChildren(),
            ];
        }
        $cms = null;
        if ($ref = Request::get("ref"))
            $cms = Cmstext::where("slug", $ref)->__getOne();
        Genesis::render('documentation', compact("collection", "cms"));
    }

    public function ll($next = 1, $per_page = 10)
    {

        $ll = new Lazyloading();
        $ll->lazyloading(new Cmstext());
        return $ll;

    }

    public function createAction($cmstext_form = null)
    {
        $rawdata = \Request::raw();
        $cmstext = $this->hydrateWithJson(new Cmstext(), $rawdata["cmstext"]);


        $cmstext->setCreationdate(new DateTime());


        $id = $cmstext->__insert();
        return array('success' => true,
            'cmstext' => $cmstext,
            'detail' => '');

    }

    public function updateAction($id, $cmstext_form = null)
    {
        $rawdata = \Request::raw();

        $cmstext = $this->hydrateWithJson(new Cmstext($id), $rawdata["cmstext"]);


        $cmstext->__update();
        return array('success' => true,
            'cmstext' => $cmstext,
            'detail' => '');

    }


    public function detailAction($id)
    {

        $cmstext = Cmstext::find($id);

        return array('success' => true,
            'cmstext' => $cmstext,
            'detail' => '');

    }


}
