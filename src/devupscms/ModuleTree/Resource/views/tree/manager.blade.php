@extends('layout')

@section('cssimport')

    <link rel="stylesheet" href="{{commun("css/jquery-ui.css")}}">
    <style>
        .card-body ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .card-body .list-group {
            min-height: 20px;
        }

        .card-body .list-group:last-child {
            border: 1px solid #eee;
        }

        .card-body .li .li {
            margin-left: +33px;
        }
    </style>

@show

@section('content')

    <!-- Content -->
    <section id="content" xmlns:v-bind="http://www.w3.org/1999/xhtml"
             xmlns:v-on="http://www.w3.org/1999/xhtml"
             class="content">
        <!-- Column Center -->
        <div class="chute chute-center">
            <!-- AllCP Info -->
            <div class="allcp-panels fade-onload">
                <div class="panel" id="spy3">
                    <div class="panel-heading">
                        <div class="topbar-left">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-link">
                                    <strong class="">Menu ({{Category::count()}}) | </strong>
                                </li>
                                <li class="breadcrumb-link">
                                    <a @click="init(category, $index)">Main</a>
                                </li>
                                <li v-for="(cat, $index) in categorytree" class="breadcrumb-link">
                                    <i class="fa fa-angle-right"></i>
                                    <a @click="backtoparent(cat, $index)">@{{cat.name}}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="deletebox" class="swal2-container swal2-fade swal2-shown" style="display:none; overflow-y: auto;">
            <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content"
                 class="swal2-modal swal2-show dv_modal" tabindex="1" style="display: inline-flex;">
                <div style=" width: 100%" class="box-container">
                    <div id="" class="modal-content">
                        <div class="modal-header">
                            <button onclick="model._dismissmodal()" type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel"></h4>
                        </div>
                        <div class="modal-body">

                            <p>Voulez-vous Supprimer? Ceci supprimera aussi toutes les catégories enfants!</p>
                            <button @click="confirmdelete('all')" type="button" class="btn btn-danger">
                                Supprimer Avec les catégories enfants
                            </button>
                            <button @click="confirmdelete('no')" type="button" class="btn btn-info">
                                Les categories enfant monterons d'une hiérarchie
                            </button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /Column Center -->
    </section>
    <!-- /Content -->

@endsection
