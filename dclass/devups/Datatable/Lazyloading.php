<?php
/**
 * Created by PhpStorm.
 * User: ATEMKENG AZANKANG
 * Date: 13/08/2019
 * Time: 14:14
 */

namespace dclass\devups\Datatable;

use Dvups_lang;
use phpDocumentor\Reflection\Types\Self_;
use QueryBuilder;
use Request;

class Lazyloading implements \JsonSerializable
{
    public $success = true;
    public $classname = "";
    public $listentities = [];
    public $listentity = [];
    public $nb_element = 0;
    public $per_page = 30;
    public $pagination = 1;
    protected $dynamicpagination = true;
    public $paginationcustom = [];
    public $current_page = 1;
    public $next = 1;
    public $previous = 0;
    public $remain = 0;
    public $detail = 0;

    public function setPerPage($page)
    {
        $this->per_page = $page;
        return $this;
    }
    public function setNext($next)
    {
        $this->next = $next;
        return $this;
    }

    public function lazyloading2($listEntity, $classname = "")
    {

        return array('success' => true, // pour le restservice
            'classname' => strtolower($classname),
            'listEntity' => $listEntity,
            'nb_element' => count($listEntity),
            'per_page' => 100,
            'pagination' => 1,
            'current_page' => 1,
            'next' => 1,
            'previous' => 0,
            'remain' => 1,
            'detail' => '');
    }

    /**
     * @var \QueryBuilder $currentqb
     */
    private $currentqb;

    private function filterswicher($opt, $attr, $value)
    {
        switch ($opt) {
            case "eq":
                $this->currentqb->andwhere($attr, "=", $value);
                break;
            case "neq":
                $this->currentqb->andwhere($attr, "!=", $value);
                break;
            case "oreq":
                $this->currentqb->orwhere($attr, "=", $value);
                break;
            case "gt":
                $this->currentqb->andwhere($attr, ">", $value);
                break;
            case "lt":
                $this->currentqb->andwhere($attr, "<", $value);
                break;
            case "get":
                $this->currentqb->andwhere($attr, ">=", $value);
                break;
            case "let":
                $this->currentqb->andwhere($attr, "<=", $value);
                break;
            case "lk":
                $this->currentqb->andwhere($attr)->like($value);
            case "lkr":
                $this->currentqb->andwhere($attr)->like_($value);
                break;
            case "lkl":
                $this->currentqb->andwhere($attr)->_like($value);
                break;
            case "isNull":
                $this->currentqb->andwhere($attr)->isNull();
                break;
            case "notNull":
                $this->currentqb->andwhere($attr)->isNotNull();
                break;
            case "btw":
                // todo : add constraint of integrity
                $btw = explode('_', $value);
                $this->currentqb->where($attr)->between($btw[0], $btw[1]);
                break;
            default:
                $this->currentqb->andwhere($attr)->like($value);
                break;
        }

    }

    public function extractXJoin($join, $attr)
    {
        //$value = '[This] is a [test] string, [eat] my [shorts].';
//        preg_match_all("/\<([^\>]*)\>/", $value, $matches);
//        $join = $matches[1][0];
//        $this->currentqb->leftjoin($join);
//        return str_replace($matches[0][0], "", $value);
        //$pos = strpos($value, "<");
        if (strpos($join, "<") !== false) {
            $lj = explode("<", $join);
            $this->currentqb->leftjoin($lj[0], $lj[1]);
            return str_replace("<" . $lj[1], "", $attr);
        }
        return $attr;
    }

    private function filter(\stdClass $entity, QueryBuilder $qb)
    {
        $this->currentqb = $qb;
        $getparam = Request::$uri_get_param;

        $this->currentqb->handlesoftdelete();
        foreach ($getparam as $key => $value) {

            if (!$value)
                continue;

            $attr = explode(":", $key);
            $join = explode(".", $attr[0]);
            if (isset($join[1])) {
                $attr[0] = $this->extractXJoin($join[0], $attr[0]);
                $this->filterswicher($attr[1], $attr[0], $value);
            } else if ($this->currentqb->hasrelation && isset($attr[1]))
                $this->filterswicher($attr[1], strtolower(get_class($entity)) . "." . $join[0], $value);
            elseif (isset($attr[1]))
                $this->filterswicher($attr[1], $join[0], $value);
//            else
//                $this->filterswicher("", $join[0], $value);

        }
        return $this->currentqb;
    }

    public static function initlazyloading(\stdClass $entity, \QueryBuilder $qbcustom = null, $order = "")
    {
        // return (new Controller())->lazyloading($entity, $this->next, $this->per_page, $qbcustom, $order);
    }

    public $qb;
    const maxpagination = 12;
    protected $render_query = false;
    public  $debug = false;
    public  $id_lang = null;

    // for retro compatibility
    public function renderQuery(){
        $this->render_query = true;
        $this->debug = true;
        return $this;
    }
    private $entity;
    public function __construct($entity = null, $qbcustom = null)
    {
        if($entity) {
            $this->entity = $entity;
            $classname = strtolower(get_class($entity));
            $this->classname = $classname;
            $this->class = $classname;
        }

        //$this->id_lang = Dvups_lang::defaultLang()->getId();
    }

    public function sortBy($attr, $sort = "ASC"){

    }
    private $qbcustom;
    private $dfilters;
    public function start(\QueryBuilder $qbcustom = null){
        $this->dfilters = Request::get("dfilters", false);
        if($this->dfilters == "on")
            $this->dfilters = true;

        if ($qbcustom != null) {

            if ($this->dfilters)
                $qbcustom = $this->filter($this->entity, $qbcustom);

            $this->nb_element = $qbcustom->count(); //false
        } else {
            $qb = new QueryBuilder($this->entity);
            $qb->select();
            if ($this->dfilters) {
                $qbcustom = $this->filter($this->entity, $qb);
                $this->nb_element = $qbcustom->count();
            } else {
                //$qb->handlesoftdelete();
                $this->nb_element = $qb->select()->handlesoftdelete()->count();
            }
        }
        $this->qbcustom = $qbcustom;
        return $this;
    }

    public static $colunms = "*";

    /***
     * @param \stdClass $entity the instance of the entity
     * @param int $this ->next the page to print within the datatable by default it's 0
     * @param int $this ->per_page the number of element per page
     * @param \QueryBuilder|null $qbcustom if the developer want to customise the request
     * @param string $order
     * @return int | $this
     */
    public function lazyloading(\stdClass $entity = null, \QueryBuilder $qbcustom = null, $order = "", $id_lang = null, $qbinstance = false)
    {//
        if($entity){
            $this->entity = $entity;
            $classname = strtolower(get_class($entity));
            $this->classname = $classname;
            $this->class = $classname;
            // $this->id_lang = $id_lang;
            $this->start($qbcustom);
        }

//        if ($this->entity->dvtranslate) {
            if ($id_lang)
                $this->id_lang = $id_lang;
//        }

        if($qbcustom)
            $this->qbcustom = $qbcustom;

        $qbcustom = $this->qbcustom;

        if (Request::get("next") && Request::get('per_page')) {
            extract(Request::$uri_get_param);
            $this->next = $next;
            $this->per_page = $per_page;
        }

        if (Request::get('dcount'))
            return $this;
        if ($dsum = Request::get('dsum')) {
            if ($qbcustom != null)
                $this->nb_element = $qbcustom->sum($dsum);
            else{
                $qb = new QueryBuilder($this->entity);
                $this->nb_element = $qb->sum($dsum);
            }
            return $this;
        }

        if (Request::get('dsort')) {
            $order = Request::get('dsort');
//            if ($this->entity->inrelation())
//                $order = $this->classname . "." . $order;//$_GET['order'];
        } elseif (Request::get('dsortjoin'))
            $order = strtolower(Request::get('dsortjoin'));

        $remain = true;
        $nb_element = $this->nb_element;
        if ($this->per_page != "all") {
            if (!($nb_element % $this->per_page)) {
                $pagination = $nb_element / $this->per_page;
            } else {
                $pagination = intval($nb_element / $this->per_page) + 1;
            }

            if ($this->next == "last_page") {
                $this->next = $pagination;
            }

            if ($this->next > 0) {
                $page = $this->next;
                $this->next = (intval($this->next) - 1) * $this->per_page;
            } else {
                $page = 1;
            }

            if ($qbcustom != null) {
                if ($this->id_lang)
                    $qbcustom->setLang($this->id_lang);
                if (Request::get("drand") == 1) {
                    $qbcustom->select()->handlesoftdelete()->rand()->limit($this->next, $this->per_page);
                }elseif ($order) {
                    $qbcustom->orderby($order)->limit($this->next, $this->per_page);
                } else
                    $qbcustom->limit($this->next, $this->per_page);

            } else {
                $qb = new QueryBuilder($this->entity);
                if ($this->id_lang)
                    $qb->setLang($this->id_lang);
                if (Request::get("drand") == 1) {
                    $qb->select()->handlesoftdelete()->rand()->limit($this->next, $this->per_page);
                }elseif ($order)
                    $qb->select()->handlesoftdelete()->orderby($order)->limit($this->next, $this->per_page);
                else
                    $qb->select()->handlesoftdelete()->limit($this->next, $this->per_page);

            }

            if ($page == $pagination) {
                $this->next = $page - 1;
                $remain = false;
            } else {
                $this->next = $page;
            }
        }
        else {
            $pagination = 0;
            $page = 1;
            $remain = 0;
            if ($qbcustom != null) {
                if (Request::get("drand") == 1) {
                    $qbcustom->select()->handlesoftdelete()->rand();
                }elseif ($order) {
                    $qbcustom->orderby($order);
                }
                /*else {
                    $qbcustom;
                }*/
            } else {
                $qb = new QueryBuilder($this->entity);
                //$qb->handlesoftdelete();
                if (Request::get("drand") == 1) {
                    $qb->select()->handlesoftdelete()->rand();
                }elseif ($order) {
                    $qb->select()->handlesoftdelete()->orderby($order);
                } else {
                    $qb->select()->handlesoftdelete();
                }
            }
            $this->per_page = $nb_element;
        }

        if($this->debug == 2) {
            $data = $qbcustom ? $qbcustom->getSqlQuery() : $qb->getSqlQuery();
            dv_dump($data);
        }

        if($this->debug)
            return $qbcustom ? $qbcustom->getSqlQuery() : $qb->getSqlQuery();

        if ($qbinstance){
            if ($qbcustom != null)
                return $qbcustom;
            else
                return $qb;
        }

        if ($qbcustom != null)
            $listEntity = $qbcustom->get(self::$colunms);
        else
            $listEntity = $qb->get(self::$colunms);

        $paginationcustom = [];
        if ($pagination >= self::maxpagination) {

            if ($page <= 8 / 2){
                for ($i = 1; $i <= 8; $i++){
                    $paginationcustom['left'][] = $i;
                }
                $paginationcustom['middle'] = [];
                $paginationcustom['right'] = ["...", $pagination];
            }
            elseif ($pagination - $page <= 8 / 2){
                $paginationcustom['left'] = [1, "..."];
                $paginationcustom['middle'] = [];
                for ($i = $pagination - 8; $i <= $pagination; $i++){
                    $paginationcustom['right'][] = $i;
                }
            }else{
                $paginationcustom['left'] = [1, "..."];
                for ($i = $page - 2; $i <= $page + 3; $i++){
                    $paginationcustom['middle'][] = $i;
                }
                $paginationcustom['right'] = ["...", $pagination];
            }

        }

        $this->listentity = $listEntity;
        $this->nb_element = $nb_element;
        $this->pagination = $pagination;
        $this->paginationcustom = $paginationcustom;
        $this->current_page = $page;
        $this->previous = (int)$page - 1;
        $this->next += 1;
        $this->remain = (int)$remain;

        return $this;

    }

    public function paginationData(){

        return array('success' => true, // pour le restservice
            'classname' => $this->classname,
            'dynamicpagination' => $this->dynamicpagination,
            'paginationcustom' => $this->paginationcustom,
            'nb_element' => (int)$this->nb_element,
            'per_page' => (int)$this->per_page,
            'pagination' => (int)$this->pagination,
            'current_page' => (int)$this->current_page,
            'next' => (int)$this->next,
            'previous' => (int)$this->previous,
            'remain' => (int)$this->remain,
            'detail' => $this->detail);

    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array('success' => true, // pour le restservice
            'classname' => $this->classname,
            'paginationcustom' => $this->paginationcustom,
            'listEntity' => $this->listentity,
            'nb_element' => (int)$this->nb_element,
            'per_page' => (int)$this->per_page,
            'pagination' => (int)$this->pagination,
            'current_page' => (int)$this->current_page,
            'next' => (int)$this->next,
            'previous' => (int)$this->previous,
            'remain' => (int)$this->remain,
            'detail' => $this->detail);
    }

}
