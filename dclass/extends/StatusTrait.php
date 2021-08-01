<?php


trait StatusTrait
{

    public static function get($key)
    {
        return Status_entity::where("dvups_entity.name", self::class)
            ->andwhere("status._key", $key)->__getOne()->status;
    }

    public static  function getStatusEntity($key)
    {
        return Status_entity::where("dvups_entity.name", self::class)
            ->andwhere("status._key", $key)->__getOne();
    }

    public static  function getStatuslist($key)
    {
        return Status_entity::where("dvups_entity.name", self::class)
            ->andwhere("status._key", $key)->__getAll();
    }
}