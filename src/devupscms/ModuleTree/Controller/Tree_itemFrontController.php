<?php


use dclass\devups\Datatable\Lazyloading;

class Tree_itemFrontController extends Tree_itemController
{

    public function ll($next = 1, $per_page = 10)
    {

        $ll = new Lazyloading();
        $ll->lazyloading(new Tree_item());

        return $ll;

    }

    public function createAction($tree_item_form = null)
    {
        $rawdata = \Request::raw();
        $tree_item = $this->hydrateWithJson(new Tree_item(), $rawdata["tree_item"]);

        $id = $tree_item->__insert();
        return array('success' => true,
            'tree_item' => $tree_item,
            'detail' => '');

    }

    public function updateAction($id, $tree_item_form = null)
    {
        $rawdata = \Request::raw();

        $tree_item = $this->hydrateWithJson(new Tree_item($id), $rawdata["tree_item"]);

        $tree_item->__update();
        return array('success' => true,
            'tree_item' => $tree_item,
            'detail' => '');

    }


    public function detailAction($id)
    {

        $tree_item = Tree_item::find($id);

        return array('success' => true,
            'tree_item' => $tree_item,
            'detail' => '');

    }

    public function changestatus(Request $request, $id, $status)
    {
        $category = Tree_item::find($id);
        $category->setStatus($status);

        $category->save();

        return $category;
    }

    public function getchildren($id)
    {

        $qb = Tree_item::where("parent_id", $id);
//        if ($count)
        $ll = new Lazyloading();
        $ll->lazyloading(new Tree_item(),  $qb, "this.name asc");
        return $ll;
        $category = Tree_item::find($id);
//        $categories = Category::where("parent_id", $id)->take(self::per_page)
//            ->orderBy('name', 'asc')->get();
//        foreach ($categories as $cat) {
//            $cat->children = DB::table("categories")->select()->where("parent_id", $cat->id)->count();
//        }

        $categorytree = [];
        if ($category->getParents_id())
            $categorytree = Tree_item::where("this.id")->in($category->getParents_id())->__getAll();

        return compact("category", "categorytree", "ll");

    }

    /**
     *
     */
    public function getdata()
    {
//        $content = file_get_contents(self::$path);
//        $info = json_decode($content, true);
        $categories = [];
        $info = Category::getmaincategory();
//        foreach ($info as $cat) {
//            $cat->children = DB::table("categories")->select()->where("parent_id", $cat->id)->count();
//        }
        return ["suceess" => true, "data" => $info];

    }

    public function orderAction()
    {

        $rawdata = \Request::raw();

        $tree_itemorder = $rawdata["tree_items"];

        foreach ($tree_itemorder as $order){
            Tree_item::where("this.id", $order[0])->update(['position'=>$order[1]]);
        }

        return Response::$data;

    }

    public function addcontentAction()
    {
        $menu = Tree_item::find(Request::get("id"));
        $content = new Cmstext();
        $content->setSlug($menu->getSlug());
        $content->setTitle($menu->getName());
        $content->setContent("comming soon");
        $content->setSommary("comming soon");
        $content->tree_item = $menu;
        $id = $content->__insert();

        Response::set("redirect", Cmstext::classpath("cmstext/edit?id=".$id));
        return Response::$data;

    }


}
