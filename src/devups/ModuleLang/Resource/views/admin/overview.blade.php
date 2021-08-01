@extends('admin.layout')

@section('layout_content')

    <div class="row">
        <div class="col-lg-12">

            <div id="lang_component" data-baseurl="{{Local_content::classpath()}}services.php?path=" class=""
                 xmlns:v-bind="http://www.w3.org/1999/xhtml">


                <h3 class="title">Local content Component</h3>

                <hr>

                <!-- Content -->
                <section id="content" xmlns:v-bind="http://www.w3.org/1999/xhtml"
                         xmlns:v-on="http://www.w3.org/1999/xhtml"
                         class="content">
                    <!-- Column Center -->

                    <div class="row">
                        <div class="col-lg-4">

                            <div class="chute chute-center">
                                <!-- AllCP Info -->
                                <div class="allcp-panels fade-onload">
                                    <div class="panel" id="spy3">
                                        <div class="panel">
                                            <div class="form-group">
                                                <button @click="loaddata()"
                                                        class="btn btn-warning">
                                                    <i v-if="loading" class="material-icons mi-autorenew">autorenew</i>
                                                    Available reference (refresh): (0) |
                                                </button>
                                                <button @click="buildcache()"
                                                        class="btn btn-warning">
                                                    <i v-if="loading" class="material-icons mi-autorenew">autorenew</i>
                                                    Regenerer le cache
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <label>Filter , enter sometext in the field.</label>
                                                <div class="input-group mb-3">
                                                    <input v-model="langfilter" @keyup="filter()" type="text"
                                                           class="form-control"
                                                           placeholder="Filter , enter sometext in the field."
                                                           aria-label="Recipient's username"
                                                           aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button @click="loaddata()" class="input-group-text"
                                                                id="basic-addon2">search
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height: 500px; overflow: auto" class="panel-body">
                                            <table class="table">
                                                <tr v-for="(cat, $index) in trees" class="nav-item">
                                                    <td class="">
                                            <textarea readonly v-model="cat.reference" type="text" class="form-control"
                                                      aria-describedby="basic-addon2"></textarea>

                                                    </td>
                                                    <td class="input-group-append">
                                                <span @click="_delete(cat.id, $index)"
                                                      class="input-group-text">supp.</span>
                                                        <button @click="init(cat, $index)" class="btn btn-info">detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div style="max-height: 500px; overflow: auto" class="panel-footer">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                 id="dataTable_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button page-item previous">
                                                        <a class="page-link" @click="previous()">
                                                            <i class="fa fa-angle-left"></i></a></li>
                                                    <li class="paginate_button page-item ">
                                                        <a class="page-link"
                                                           href="javascript:ddatatable.pagination(this, 1);"
                                                           data-next="1">1</a>
                                                    </li>
                                                    <li class="paginate_button page-item next">
                                                        <a class="page-link" @click="nextpage()">
                                                            <i class="fa fa-angle-right"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-8">

                            <local_content :key="tree.id" v-if="tree.id" :tree="tree"></local_content>

                        </div>
                    </div>

                    <!-- /Column Center -->
                </section>
                <!-- /Content -->

            </div>

        </div>
    </div>
@endsection
            