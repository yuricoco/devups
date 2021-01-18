var catid = 0;

Vue.component("tree_itemForm", {
    data() {
        return {
            chain: [],
            treeitem: {},
            tree_itemparent: {},
            tree_itemtree: [],
            chain: [],
        }
    },
    props: ["tree_item"],
    mounted() {

        model._apiget("tree-item.detail?id=" + this.tree_item.id, (response) => {
            console.log(response);
            //this.tree_item = response.tree_item;

            // this.tree_itemtree = response.data.tree_itemtree;
            // this.tree_itemparent = response.data.tree_itemparent;

        })

    },
    methods: {

        update() {
            console.log(this.tree_item);
            model._apipost('tree-item.update?id=' + this.tree_item.id,
                JSON.stringify({
                    "tree_item": model.entitytoformentity(this.tree_item)
                }),
                response => {
                    console.log(response);
                    this.tree_item = {};

                    $.notify("Categorié mise à jour avec succès!", "success");

                }, false);
        },
        createcontent(){
            var url = $("#content").data('url')
            console.log(url);
            if(this.tree_item.content_id)
                window.location.href = url+'edit?id='+this.tree_item.content_id+'&tree_item='+this.tree_item.id;
            else
                window.location.href = url+'new?tree_item='+this.tree_item.id;
        }

    },
    template: `
        
        <div class="card border-primary">
            <div class="card-header ">Edit item</div>
            <div class="card-body">
                <form id="frmEdit" class="form-horizontal">
                            <div class="form-group">
                                <label for="text">Nom</label>

                                <input autocomplete="off" v-model="tree_item.name" type="text"
                                       class="form-control " name="text" id="text"
                                       placeholder="Text">

                            </div>
                            <div class="form-group">
                                <label for="text">Url</label>

                                <input autocomplete="off" v-model="tree_item.slug" type="text"
                                       class="form-control " name="text" id="text"
                                       placeholder="Text">

                            </div>
                            <div class="form-group">
                                <label for="text">Menu principal</label>
                                <div class="form-check form-check-inline">
                                    <input v-model="tree_item.main" value="1" class="form-check-input" type="radio"
                                           name="exampleRadios" id="exampleRadios1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Oui
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="tree_item.main" value="0" class="form-check-input" type="radio"
                                           name="exampleRadios" id="exampleRadios2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Non
                                    </label>
                                </div>

                            </div>
                            <div v-if="tree_item.main == 0" class="form-group">
                                <label for="href">Parent / @{{tree_itemparent ? tree_itemparent.name : ""}}</label>
                                <select v-model="tree_item.parent_id" class="form-control item-menu">
                                    <option :value="0">
                                        --- Sélectionner le parent ---
                                    </option>
                                    <optgroup label="Hierarchie supérieur">
                                    <option v-for="(hopcat, $index) in tree_itemtree"
                                            v-bind:value="hopcat.id">
                                        @{{hopcat.name}}
                                    </option>
                                    </optgroup>
                                    <optgroup label="Définir comme enfant de :">
                                    <option v-for="(parentcat, $index) in chain"
                                            v-bind:value="parentcat.id">
                                        @{{parentcat.name}}
                                    </option>
                                    </optgroup>
                                </select>
                            </div>
                        </form>
            </div>
            <div class="card-footer">
                        <button v-if="tree_item.id" @click="update()" type="button" id="btnUpdate"
                                class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Update
                        </button>
                        <button v-if="!tree_item.id" @click="create()" type="button" id="btnAdd" class="btn btn-success">
                            <i class="fas fa-plus"></i> Add
                        </button>
                        <button @click="tree_item = {}" type="button" class="btn btn-danger">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </div>
        </div>
    `
});

Vue.component("addchild", {
    data() {
        return {
            tree_item: {},
            nameparent: "main branche",
        }
    },
    props: ["parent", "tree_items", "tree"],
    mounted() {
        console.log(this.parent);
        if (this.parent)
            this.nameparent = this.parent.slug
    },
    methods: {
        create() {
            this.tree_item.main = 1;

            if(this.tree_items)
                this.tree_item.position = this.tree_items.length;
            else if (this.$parent.children)
                this.tree_item.position = this.$parent.children[this.$parent.children.length - 1].position;

            this.tree_item["tree.id"] = this.tree.id;
            // var datajson = JSON.stringify(this.tree_item);

            if (this.parent) {
                this.tree_item.main = 0;
                this.tree_item.parent_id = this.parent.id;
            }

            model._apipost("tree-item.create", JSON.stringify({
                tree_item: this.tree_item
            }), (response) => {
                console.log(response);
                // todo: add to the parent
                this.tree_item.name = "";
                if(this.tree_items)
                    this.tree_items.push(response.tree_item)
                else if (this.$parent.children)
                    this.$parent.children.push(response.tree_item)

            }, false);

        },
    },
    template: `
        <li class="list-group-item">
            <div class="input-group mb-3">
                <input type="text" v-model="tree_item.name" class="form-control" 
                :placeholder="'Ajouter un enfant a ' +nameparent" 
                aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button @click="create()" class="input-group-text" id="basic-addon2">add</button>
                  </div>
            </div>
        </li>
    `
})

Vue.component("childrenTree", {
    data() {
        return {
            children: [],
            chain: [],
        }
    },
    props: ["tree_item", "tree"],
    mounted() {
    },
    methods: {

        findchildren(el) {

            model._apiget("tree-item.getchildren?id=" + this.tree_item.id, (response) => {
                console.log(response);

                this.children = response.listEntity;
                this.ll = response;
            });

        },
        edit(el) {
            // this.el =el;
            this.$root.$emit("edit", this.tree_item)

        },
        saveorder() {
            // this.el =el;
            if (this.children){
                var toupdate = [];
                this.children.forEach((item) => {
                    toupdate.push([item.id, item.position])
                })

                model._apipost("tree-item.order",
                    JSON.stringify({
                        tree_items: toupdate
                    }), (response) => {
                        console.log(response);

                    })
            }
                // this.$root.$emit("saveorder", this.$parent.children)

        },
        changestatus(el, status) {
            el.status = status;
            console.log(el);
            model._apiget("tree-item.changestatus?id=" + el.id + "&status=" + status, function (response) {
                console.log(response);
            });
        },
        addcontent() {

            model._apiget("tree-item.addcontent?id=" + this.tree_item.id, function (response) {
                console.log(response);
                window.location.href = response.redirect;
            });

        },
        _delete(el, index) {
            // this.el =el;

            this.tree_item_id = [el.id, index];
            model.modalbox = $("#deletebox");
            model._showmodal();


        },
        move(position) {
            this.tree_item.position += position;
        }

    },
    template: `
        <li class="list-group-item">
            <div class="dd-handle dd-primary">
                <button class="btn btn-light">
                <span v-html="tree_item.name"></span> {{tree_item.position}}
                ({{tree_item.children}})</button>
                <button @click="move(1)" class="btn btn-info"><i class="fa fa-angle-up"></i></button> 
                <button @click="move(-1)" class="btn btn-info"><i class="fa fa-angle-down"></i></button> 

                <span class="pull-right fs11 fw600">
                    <a v-if="parseInt(tree_item.status)" @click="changestatus(tree_item, 0)"
                       class="btn list-item  text-success">
                        <i class="fa fa-circle fs10"></i> Activer
                    </a>
                    <a v-if="!parseInt(tree_item.status)" @click="changestatus(tree_item, 1)"
                       class="btn list-item  text-danger">
                        <i class="fa fa-circle fs10"></i> Desactiver
                    </a>
                    <button v-if="tree_item.children" @click="saveorder()" type="button"
                            class="btn btn-info">
                        <i class="fa fa-exchange-alt"></i> Save Order</button>
                    <button @click="addcontent()" type="button"
                            class="btn btn-info">
                        <i class="fa fa-plus"></i> Add content</button>
                    <button v-if="tree_item.children" @click="findchildren(tree_item)" type="button"
                            class="btn btn-info">
                        <i class="fa fa-copy"></i></button>
                    <button @click="edit(tree_item)" type="button" class="btn btn-info">
                        <i class="fa fa-edit"></i></button>
                    <button @click="_delete(tree_item, $index)" type="button" class="btn btn-danger">
                        <i class="fa fa-times"></i></button>

                </span>
            </div>
            <ul class="sortableLists list-group">
                <li v-if="children.length" is="childrenTree" v-for="(child, $index) in children"
                    v-bind:key="child.id" :tree_item="child" class="list-group-item"></li>
                
                <li is="addchild"
                    v-bind:key="tree_item.id+'addchild'" 
                    :parent="tree_item" :tree="tree" class="list-group-item"></li>
                
            </ul>
        </li>
    `
});

Vue.component("tree_item", {
    data() {
        return {
            tree_itemtree: [],
            tree_items: [],
            tree_item: {},
            tree_itemstring: "",
            search: "",
            resultdatas: [],
            ll: {},
            componentkey: 1,
        }
    },
    props: ["tree"],
    mounted() {

        model._apiget("tree-item.lazyloading?dfilters=on&next=1&per_page=10&main:eq=1&tree.id:eq=" + this.tree.id,
            (response) => {
                console.log(response);
                this.ll = response;
                this.tree_items = response.listEntity;
            })

        this.$root.$on('edit', (item) => {
            console.log(item);
            this.tree_item = item;
        })

    },
    computed: {
        orderedItems: function () {
            return this.tree_items.sort(function (a, b) {
                return a.position - b.position
            });
            // return _.orderBy(this.tree_items, 'position')
        }
    },
    methods: {

        highlight(next) {
            return (this.currentpage === next) ? 'active' : '';
        },
        nextchildren(next) {

            this.currentpage = next;
            model._apiget("tree_item.nextchildren?id=" + catid + "&next=" + next, (response) => {
                console.log(response);
                this.ll = response.data.ll;

                this.tree_items = this.ll.listEntity;
            });

        },
        backtoparent(tree_item, index) {

            this.tree_item.parent_id = tree_item.id;
            this.findchildren(tree_item);

        },
        cancelsearch() {
            this.search = "";
            this.resultdatas = [];
            this.init();
        },
        findtree_item(e) {

            if (e.keyCode === 13) { //|| product.id
                return;
            }

            if (this.search.length >= 3) {
                //$("#box-loader").show();
                var self = this;
                if (this.resultdatas.length) {
                    this.tree_items = this.filterrow(this.search, this.resultdatas);
                    return;
                }
                // else
                model._apiget("tree_item.find?search=" + devups.escapeHtml(this.search), (response) => {
                    console.log(response);
                    this.tree_itemtree = [];
                    this.resultdatas = response.data;
                    this.tree_items = response.data
                });

            } else {
                $("#productselected").html("");
                this.tree_items = [];
                this.resultdatas = [];
            }
        },

        confirmdelete(option) {

            var tree_item_id = this.tree_item_id[0];
            var index = this.tree_item_id[1];

            model._apiget("tree_item.delete?id=" + tree_item_id + "&option=" + option, (response) => {
                console.log(response);
                this.tree_items.splice(index, 1);
                model._dismissmodal();

            });

        },
        save() {
            var els = $(".sortableLists").find(".li");

            const cc = builcollection(els);
            this.tree_items = JSON.parse(cc);
            console.log(this.tree_items);
            this.tree_itemstring = cc;

            model._apipost("tree_item.create", {data: cc}, (response) => {
                console.log(response);
            });

        },
        filterrow(value, dataarray) {
            var filter, filtered = [], tr, td, i, data;

            console.log(dataarray);
            filter = value.toUpperCase();

            for (i = 0; i < dataarray.length; i++) {
                data = dataarray[i];
                if (data.name.toUpperCase().indexOf(filter) > -1) {
                    filtered.push(data);
                }
            }
            return filtered;
        },

        saveorder() {
            // this.el =el;
            if (this.tree_items){
                var toupdate = [];
                this.tree_items.forEach((item) => {
                    toupdate.push([item.id, item.position])
                })
                console.log(toupdate);
                model._apipost("tree-item.order",
                    JSON.stringify({
                        tree_items: toupdate
                    }), (response) => {
                        console.log(response);

                    })
            }
            // this.$root.$emit("saveorder", this.$parent.children)

        },
    },
    template: `

        <div class="row">
            <div class="col-12">
                <div class="chute chute-center">
                    <!-- AllCP Info -->
                    <div class="allcp-panels fade-onload">
                        <div class="panel" id="spy3">
                            <div class="panel-heading">
                                <div class="topbar-left">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-link">
                                            <strong class="">{{tree.name}} | </strong>
                                        </li>
                                        <li class="breadcrumb-link">
                                            <a @click="init(tree_item, $index)">Main</a>
                                        </li>
                                        <li v-for="(cat, $index) in tree_itemtree" class="breadcrumb-link">
                                            <i class="fa fa-angle-right"></i>
                                            <a @click="backtoparent(cat, $index)">@{{cat.name}}</a>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card mb-3">
                    <div class="card-header">

                        <input v-model="search" @keyup="findtree_item($event)"
                               placeholder="Rechercher une categorie ..."
                               class="form-control gui-input"/>
                        <button style="position: absolute; right: 20px; top: 7px" type="button"
                                @click="cancelsearch()" class="btn">
                            <i class="fa fa-close "></i>
                        </button>

                        <hr>
                    </div>
                    <div class="card-body">
                        
                        <button @click="saveorder()" type="button" class="btn btn-info">
                            <i class="fa fa-exchange-alt"></i> Save Order
                        </button>
                            
                        <ul id="sortable" class="sortableLists list-group">
                                    
                            <li is="childrenTree" v-for="(tree_item, $index) in orderedItems"
                                v-bind:key="tree_item.id" :tree="tree" 
                                :tree_item="tree_item" 
                                class="list-group-item"></li>
                            
                            <li is="addchild" v-bind:key="tree.id+'addchild'" 
                                    :tree_items="tree_items"  :tree="tree" class="list-group-item"></li>
                                
                        </ul>
                        <div v-if="ll.pagination > 1" class="dataTables_paginate paging_simple_numbers text-right">
                            <ul class="pagination">

                                <li v-for="n in ll.pagination" :class="'page-item '+ highlight(n) ">
                                    <a class="page-link"
                                       v-on:click="nextchildren(n)"
                                       href="#"
                                       data-next="1">@{{ n }}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <tree_itemForm :key="tree_item.id" v-if="tree_item.id" :tree_item="tree_item" ></tree_itemForm>
            </div>

        </div>

    `
})

var tree_itemview = new Vue({
    el: '#content',
    data: {
        trees: [],
        attributes: [],
        tree: {},
    },
    mounted() {
        model._apiget("tree.lazyloading", (response) => {
            console.log(response);
            this.trees = response.listEntity;
        })
        this.$root.$emit("saveorder", (tree_items) => {

        })
    },
    methods: {
        init(tree) {
            this.tree = tree;
            console.log("tree_item.getdata client");
        },

    }
});

