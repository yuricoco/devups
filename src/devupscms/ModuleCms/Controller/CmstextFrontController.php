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


    public function detailAction($id)
    {

        $cmstext = Cmstext::find($id);

        return array('success' => true,
            'cmstext' => $cmstext,
            'detail' => '');

    }

    public function faqView()
    {
        $collection = [];
        $list = Tree_item::getmainmenu("faq");
        foreach ($list as $el){
            /*$children = $el->getChildren();
            $colchildren = [];
            foreach ($children as $child){
                $content = $child->getContent()->getContent();
                $colchildren = [
                    "item"=>$child,
                    "content"=>$child,
                ];
            }*/
            $collection[] = [
                "item" => $el,
                "children" => $el->getChildren(),
            ];
        }
        return compact("collection");

    }


}
