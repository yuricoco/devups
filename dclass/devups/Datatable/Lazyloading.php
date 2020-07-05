<?php
/**
 * Created by PhpStorm.
 * User: ATEMKENG AZANKANG
 * Date: 13/08/2019
 * Time: 14:14
 */

namespace dclass\devups\Datatable;

use QueryBuilder;
use Request;

class Lazyloading implements \JsonSerializable
{
    protected $success = true;
    protected $classname = "";
    protected $listentities = [];
    protected $listentity = [];
    protected $nb_element = 0;
    protected $per_page = 30;
    protected $pagination = 1;
    protected $current_page = 1;
    protected $next = 1;
    protected $previous = 0;
    protected $remain = 0;
    protected $detail = 0;

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
            case "lkr":
                $this->currentqb->andwhere($attr)->like_($value);
                break;
            case "lkl":
                $this->currentqb->andwhere($attr)->_like($value);
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

    const maxpagination = 12;

    /***
     * @param \stdClass $entity the instance of the entity
     * @param int $this ->next the page to print within the datatable by default it's 0
     * @param int $this ->per_page the number of element per page
     * @param \QueryBuilder|null $qbcustom if the developer want to customise the request
     * @param string $order
     * @return void
     */
    public function lazyloading(\stdClass $entity, \QueryBuilder $qbcustom = null, $order = "")
    {//
        $remain = true;
        $qb = new QueryBuilder($entity);
        $classname = strtolower(get_class($entity));
        if (Request::get("next") && Request::get('per_page')) {
            extract(Request::$uri_get_param);
            $this->next = $next;
            $this->per_page = $per_page;
        }

        if (Request::get('order')) {
            $order = Request::get('order');
            if ($entity->inrelation())
                $order = $classname . "." . $order;//$_GET['order'];
        } elseif (Request::get('orderjoin'))
            $order = strtolower(Request::get('orderjoin'));


        if ($qbcustom != null) {

            if (Request::get("dfilters"))
                $qbcustom = $this->filter($entity, $qbcustom);

            $nb_element = $qbcustom->__countEl(false, false); //false
        } else {

            if (Request::get("dfilters")) {

                $qbcustom = $this->filter($entity, $qb);
                $nb_element = $qbcustom->__countEl(false, true);
            } else {
                //$qb->handlesoftdelete();
                $nb_element = $qb->selectcount()->handlesoftdelete()->__countEl(false);
            }
        }

        if ($this->per_page != "all") {
            if (!($nb_element % $this->per_page)) {
                $pagination = $nb_element / $this->per_page;
            } else {
                $pagination = intval($nb_element / $this->per_page) + 1;
            }

            if ($this->next > 0) {
                $page = $this->next;
                $this->next = (intval($this->next) - 1) * $this->per_page;
            } else {
                $page = 1;
            }

            if ($qbcustom != null) {

                if ($order) {
                    $listEntity = $qbcustom->orderby($order)->limit($this->next, $this->per_page)->__getAll();
                } else
                    $listEntity = $qbcustom->limit($this->next, $this->per_page)->__getAll();

            } else {
                if ($order)
                    $listEntity = $qb->select()->handlesoftdelete()->orderby($order)->limit($this->next, $this->per_page)->__getAll();
                else
                    $listEntity = $qb->select()->handlesoftdelete()->limit($this->next, $this->per_page)->__getAll();

            }

            if ($page == $pagination) {
                $this->next = $page - 1;
                $remain = false;
            } else {
                $this->next = $page;
            }
        } else {
            $pagination = 0;
            $page = 1;
            $remain = 0;
            if ($qbcustom != null) {
                if ($order) {
                    $listEntity = $qbcustom->orderby($order)->__getAll();
                } else {
                    $listEntity = $qbcustom->__getAll();
                }
            } else {
                //$qb->handlesoftdelete();
                if ($order) {
                    $listEntity = $qb->select()->handlesoftdelete()->orderby($order)->__getAll();
                } else {
                    $listEntity = $qb->select()->handlesoftdelete()->__getAll();
                }
            }
            $this->per_page = $nb_element;
        }

        $paginationcustom = [];
        if ($pagination >= self::maxpagination) {
            $middle = intval($pagination / 2);
            $paginationcustom['firsts'] = [1, 2, 3];
            $paginationcustom['lasts'] = [$pagination - 2, $pagination - 1, $pagination];

            if ($page > self::maxpagination / 2) {

                $paginationcustom['middleleft'] = intval($pagination / 4);
                //$paginationcustom['firsts'] = [$page, 1 + $page + 1, 2 + $page + 2];

                if ($page + 3 >= $pagination) {
                    $paginationcustom['middleleft'] = intval($pagination / 4);
                    $paginationcustom['lasts'] = [];
                    $paginationcustom['middles'] = [$pagination - 5, $pagination - 4, $pagination - 3, $pagination - 2, $pagination - 1, $pagination];
//                else{
//                    $paginationcustom['middles'][] = $middle + $page + 2;
//                    $paginationcustom['middles'][] = $middle + $page + 3;
//                    $paginationcustom['middles'][] = $middle + $page + 4;
                } else {
                    $paginationcustom['middleright'] = intval($pagination * 3 / 4);
                    $paginationcustom['middles'] = [$page - 1, $page, $page + 1];
                }
                //= [$page, $page + 1, $page + 2];
            } else {

                $paginationcustom['middles'] = [$middle - 1, $middle, $middle + 1];
                $paginationcustom['middleright'] = intval($pagination * 3 / 4);
                $paginationcustom['middleleft'] = intval($pagination / 4);

                if ($page > 3 && $page < 8) {
                    $paginationcustom['firsts'] = [1, 2, 3, 4, 5, 6, 7];
                }

            }
        }

        $this->classname = $classname;
        $this->class = $classname;
        $this->listentity = $listEntity;
        $this->nb_element = $nb_element;
        $this->pagination = $pagination;
        $this->paginationcustom = $paginationcustom;
        $this->current_page = $page;
        $this->previous = (int)$page - 1;
        $this->next += 1;
        $this->remain = (int)$remain;

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
            'listEntity' => $this->listentity,
            'nb_element' => $this->nb_element,
            'per_page' => $this->per_page,
            'pagination' => $this->pagination,
            'current_page' => $this->current_page,
            'next' => $this->next,
            'previous' => $this->previous,
            'remain' => $this->remain,
            'detail' => $this->detail);
    }

}
