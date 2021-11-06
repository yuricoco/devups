<?php


class Dv_langCore extends \stdClass
{

    /**
     * @Id @ManyToOne(targetEntity="\Dvups_lang")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_lang
     */
    public $lang;

    public static function langvalues($entityname, $id, $key){
        $sql = "SELECT $key FROM {$entityname}_lang WHERE {$entityname}_id = $id ";
        return (new DBAL())->executeDbal($sql, [], DBAL::$NOTHING);
    }

}