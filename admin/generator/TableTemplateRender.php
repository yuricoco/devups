<?php

namespace admin\generator;

class TableTemplateRender
{

    protected $btnedit_class = "btn btn-warning btn-sm";
    protected $btnview_class = "btn btn-info btn-sm";
    protected $btndelete_class = "btn btn-danger btn-sm";
    protected $btnsearch_class = "btn btn-primary";
    protected $table_class = "table table-bordered table-striped table-hover dataTable no-footer";

    protected $defaultaction = [
        "edit" => [
            //'type' => 'btn',
            'content' => '<i class="fa fa-edit" ></i> edit',
            'class' => 'edit',
            'action' => '',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ],
        "show" => [
            //'type' => 'btn',
            'content' => '<i class="fa fa-eye" ></i> show',
            'class' => 'show',
            'action' => '',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ],
        "delete" => [
            //'type' => 'btn',
            'content' => '<i class="fa fa-close" ></i> delete',
            'class' => 'delete',
            'action' => '',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ],
    ];
    protected $createaction = [
        //'type' => 'btn',
        'content' => '<i class="fa fa-plus" ></i> create',
        'class' => 'btn btn-success',
        'action' => 'onclick="model._new()"',
        'habit' => 'stateless',
        'modal' => 'data-toggle="modal" ',
    ];
    const button = [
        //'type' => 'btn',
        'content' => '<i class="fa fa-plus" ></i> create',
        'class' => 'btn btn-success',
        'action' => '',
        'habit' => 'stateless',
        'modal' => 'data-toggle="modal" ',
    ];

}