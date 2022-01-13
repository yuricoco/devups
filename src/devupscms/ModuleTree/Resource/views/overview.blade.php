@extends('admin.layout')
@section('title', 'List')

@section('layout_content')
    <div hidden class="row">
        @foreach($moduledata->dvups_entity as $entity)
            @ include("default.entitywidget")
        @endforeach
    </div>

    <div class="row">
        <div class="col-12">

            <!-- Content -->
            <section id="content"
                     xmlns:v-bind="http://www.w3.org/1999/xhtml"
                     xmlns:v-on="http://www.w3.org/1999/xhtml"
                    data-url="{!! $basecontenturl !!}"
                     class="content">
                <!-- Column Center -->
                <div class="row">
                    <div class="col-lg-3">

                        <div class="chute chute-center">
                            <!-- AllCP Info -->
                            <div class="allcp-panels fade-onload">
                                <div class="panel" id="spy3">

                                    <ul class="nav n">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Available tree: (0) | @{{role}} </a>
                                        </li>
                                        <li v-for="(cat, $index) in trees" class="nav-item">
                                            <div class="input-group mb-3">
                                                <input v-model="cat.name" type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <span v-if="role =='admin'" @click="_delete(cat.id, $index)" class="input-group-text btn-danger" >
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                    <span v-if="role =='admin'" @click="update(cat)" class="input-group-text" >
                                                        <i class="fa fa-edit"></i></span>
                                                    <span @click="init(cat, $index)" class="input-group-text" >
                                                        <i class="fa fa-eye"></i></span>
                                                    <a :href="'{{Tree_item::classpath('tree-item/index?dfilters=on&tree.name:eq=')}}'+cat.name" class="input-group-text" >
                                                        <i class="fa fa-list-alt"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li v-if="role =='admin'" class="nav-item">
                                            <div class="input-group mb-3">
                                                <input v-model="treeedit.name" type="text" class="form-control" placeholder="Nouvelle racine" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <span @click="update(treeedit)" class="btn btn-primary input-group-text" >cree</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-9">

                        <tree_item :key="tree.id" v-if="tree.id" :langs="langs" :tree="tree"></tree_item>

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

        </div>
    </div>

@endsection 

@section("jsimport")
    <script>
        var createcontenturl = ' $addcontenturl !!}';
    </script>
@endsection