<?php

/**
 * @Entity @Table(name="dvups_lang")
 * */
class Dvups_lang extends \Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="ref", type="string" , length=150 )
     * @var string
     **/
    private $ref;
    /**
     * @Column(name="_table", type="string" , length=55 )
     * @var string
     **/
    private $_table;
    /**
     * @Column(name="_row", type="integer" )
     * @var string
     **/
    private $_row;

    /**
     * @Column(name="_column", type="string" , length=55 )
     * @var string
     **/
    private $_column;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function getRef()
    {
        return $this->ref;
    }

    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    public function get_table()
    {
        return $this->_table;
    }

    public function set_table($_table)
    {
        $this->_table = $_table;
    }

    public function get_column()
    {
        return $this->_column;
    }

    public function set_column($_column)
    {
        $this->_column = $_column;
    }

    /**
     * @return string
     */
    public function get_row()
    {
        return $this->_row;
    }

    /**
     * @param string $row
     */
    public function set_row($row)
    {
        $this->_row = $row;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'ref' => $this->ref,
            '_table' => $this->_table,
            '_column' => $this->_column,
        ];
    }

}
