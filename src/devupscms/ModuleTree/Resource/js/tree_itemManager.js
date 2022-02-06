Vue.component("tree_itemForm", {
    data() {
        return {
            chain: [],
            treeitem: {},
            contenturl: "",
            tree_itemparent: {},
            tree_itemtree: [],
        }
    },
    props: ["tree_item", 'langs'],
    mounted() {

        var url = $("#content").data('url')
        console.log(url);
        if (this.tree_item.content_id)
            this.contenturl = url + 'edit?id=' + this.tree_item.content_id + '&tree_item=' + this.tree_item.id;
        else
            this.contenturl = url + 'new?tree_item=' + this.tree_item.id;

    },
    methods: {

        update(quit) {
            console.log(this.tree_item);
            //return ;
            Drequest.api('tree-item.update?id=' + this.tree_item.id)
                .data({
                    //"tree_item": model.entitytoformentity(this.tree_item)
                    "tree_item": this.tree_item
                })
                .raw(
                    response => {
                        console.log(response);
                        if(quit)
                            this.tree_item = {};
                        $.notify("mise à jour avec succès!", "success");
                    });
        },
        createcontent() {
        }

    },
    template: `
        
        <div class="panel">
            <div class="card-header ">Edit item</div>
            <div class="card-body">
                <form id="frmEdit" class="form-horizontal">
                
                    <div class="panel">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#general-tab" role="tab"
                                   aria-controls="home" aria-selected="true">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cont-tab" data-toggle="tab" href="#content-tab" role="tab"
                                   aria-controls="content" aria-selected="false">Quick content</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#image-tab" role="tab"
                                   aria-controls="profile" aria-selected="false">Image</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active" id="general-tab" role="tabpanel"
                                 aria-labelledby="home-tab"> 
                                    <div v-for="lang in langs" class="form-group">
                                        <label for="text">Nom {{lang.iso_code}}</label>
                                        <input autocomplete="off" v-model="tree_item.name[lang.iso_code]" type="text"
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
                                        <label for="text">chain</label>
        
                                        <input autocomplete="off" v-model="tree_item.chain" type="text"
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
                                
                            </div>
                            <div class="tab-pane fade" id="content-tab" role="tabpanel" aria-labelledby="content-tab">
                                <div class="form-group">
                                    <label for="text">Content</label>
                                    <textarea style="min-height: 300px" class="form-control" v-model="tree_item.content" ></textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="image-tab" role="tabpanel" aria-labelledby="profile-tab">
                                    <tree_item_image :tree_item="tree_item" ></tree_item_image>
                            </div>
                        </div>
                    </div>
                </form>
                        
                <a :href="contenturl" target="_blank" class="btn btn-primary">
                    <i class="fas fa-edit"></i> advanced content
                </a>
                
            </div>
            <div class="card-footer">
                <button v-if="tree_item.id" @click="update()" type="button" id="btnUpdate"
                        class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Update
                </button>
                <button v-if="tree_item.id" @click="update(true)" type="button" id="btnUpdate"
                        class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Update & quit
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
            tree_item: {name:{}},
            nameparent: "main branche",
        }
    },
    props: ["parent", "tree_items", "tree"],
    mounted() {
        console.log(this.parent);
        if (this.parent)
            this.nameparent = this.parent.name
    },
    methods: {
        create() {
            console.log(this.tree_item, this.tree)
            this.tree_item.main = 1;

            if (this.tree_items)
                this.tree_item.position = this.tree_items.length;
            else if (this.$parent.children && this.$parent.children[this.$parent.children.length - 1])
                this.tree_item.position = this.$parent.children[this.$parent.children.length - 1].position;
            else
                this.tree_item.position = 1;

            this.tree_item["tree.id"] = this.tree.id;
            // var datajson = JSON.stringify(this.tree_item);

            if (this.parent) {
                this.tree_item.main = 0;
                this.tree_item.parent_id = this.parent.id;
            }
            this.tree_item.name["fr"] = this.tree_item.name["en"]
            Drequest.api("tree-item.create")
                .data({
                    tree_item: this.tree_item
                })
                .raw((response) => {

                    console.log(response);
                    // todo: add to the parent
                    this.tree_item.name = {};
                    if (this.tree_items)
                        this.tree_items.push(response.tree_item)
                    else if (this.$parent.children)
                        this.$parent.children.push(response.tree_item)

                });

        },
    },
    template: `
        <li class="list-group-item">
            <div class="input-group center">
            <input type="text" class="filter datepicker date-input form-control hasDatepicker" 
              v-model="tree_item.name['en']" :placeholder="'Ajouter un enfant a ' +nameparent['en']"  >
            <span  @click="create()" class="btn btn-default input-group-addon">
            <i class="fa fa-plus"></i>
            </span>
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
    props: ["tree_item", "tree", "langs", "index", "nbitem"],
    mounted() {
    },
    methods: {

        findchildren(el) {
            Drequest.api("tree-item.lazyloading?dfilters=on&next=1&per_page=25&parent_id:eq=" + this.tree_item.id)
                .get((response) => {
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
            if (this.children) {
                var toupdate = [];
                this.children.forEach((item) => {
                    toupdate.push([item.id, item.position])
                })
                Drequest.api("tree-item.order")
                    .data({
                        tree_items: toupdate
                    })
                    .raw((response) => {
                        console.log(response);
                    });
            }
            // this.$root.$emit("saveorder", this.$parent.children)

        },
        changestatus(el, status) {
            el.status = status;
            console.log(el);
            Drequest.api("tree-item.changestatus?id=" + el.id + "&status=" + status)
                .get(function (response) {
                    console.log(response);
                })
        },
        addcontent() {

            Drequest.api("tree-item.addcontent?id=" + this.tree_item.id)
                .get(function (response) {
                    console.log(response);
                    window.location.href = response.redirect;
                });

        },
        _delete(el, index) {
            // this.el =el;
            Drequest.api("tree-item.delete?id=" + this.tree_item.id)
                .get((response) => {
                    console.log(response);
                    if (this.$parent)
                        this.$parent.tree_items.splice(index, 1)
                    else {
                        this.$root.$emit("delete", index)
                    }
                })

        },
        move(position) {
            this.tree_item.position += position;
        }

    },
    template: `
        <li class="list-group-item">
            <div class="dd-handle dd-primary">
                <button style="width: 120px; overflow: hidden"  class="btn btn-light">
                <span v-html="tree_item.name['en']"></span> {{tree_item.position}} {{nbitem}}
                ({{tree_item.children}})</button>
                <button v-if="tree_item.position" @click="move(1)" class="btn btn-info btn-sm"><i class="fa fa-angle-down"></i></button> 
                <button v-if="tree_item.position <= nbitem - 1" @click="move(-1)" class="btn btn-info btn-sm"><i class="fa fa-angle-up"></i></button> 

                <span class="pull-right fs11 fw600">
                    <a v-if="parseInt(tree_item.status)" @click="changestatus(tree_item, 0)"
                       class="btn list-item  text-success">
                        <i class="fa fa-circle fs10"></i> on
                    </a>
                    <a v-if="!parseInt(tree_item.status)" @click="changestatus(tree_item, 1)"
                       class="btn list-item  text-danger">
                        <i class="fa fa-circle fs10"></i> off
                    </a>
                    <button v-if="tree_item.children" @click="saveorder()" title="Save Order" type="button"
                            class="btn btn-info">
                        <i class="fa fa-exchange-alt"></i> </button>
                        
                    <button v-if="tree_item.children" @click="findchildren(tree_item)" type="button"
                            class="btn btn-info">
                        <i class="fa fa-copy"></i></button>
                    <button @click="edit(tree_item)" type="button" class="btn btn-info">
                        <i class="fa fa-edit"></i></button>
                    <button @click="_delete(tree_item, index)" type="button" class="btn btn-danger">
                        <i class="fa fa-close"></i></button>

                </span>
            </div>
            <ul class="sortableLists list-group">  
                <li is="addchild"
                    v-bind:key="tree_item.id+'addchild'" 
                    :parent="tree_item" :tree="tree" class="list-group-item"></li>
                
                <li v-if="children.length" is="childrenTree" v-for="(child, $index) in children"
                    v-bind:key="child.id" :tree="tree"  
                    :tree_item="child" 
                    :langs="langs" 
                    :nbitem="children.length" 
                    :index="$index" 
                    class="list-group-item"></li>
                              
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
    props: ["tree", "langs"],
    mounted() {

        Drequest
            .api("tree-item.lazyloading")
            .param({
                dfilters: "on",
                next: 1,
                per_page: 10,
                "main:eq": 1,
                "tree.id:eq": this.tree.id,
            })
            .get((response) => {
                console.log(response);
                this.ll = response;
                this.tree_items = response.listEntity;
            });

        this.$root.$on('edit', (item) => {
            console.log(item);
            this.tree_item = item;
        })

        this.$root.$on('delete', (index) => {
            console.log(index);
            this.$parent.tree_items.splice(index, 1)
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

            Drequest
                .api("tree-item.nextchildren?id="+catid+"&next="+next)
                //.param({id: catid, next: next})
                .get((response) => {
                    console.log(response);
                    this.ll = response.data.ll;
                    this.tree_items = this.ll.listEntity;
                });

            //xhrObj.abort();
        },
        nextitems(next) {

            this.currentpage = next;

            Drequest.api("tree-item.lazyloading")
                .param({
                    dfilters: "on",
                    next: next,
                    per_page: 10,
                    "main:eq": 1,
                    "tree.id:eq": this.tree.id,
                })
                .get((response) => {
                    console.log(response);
                    this.ll = response;

                    this.tree_items = this.ll.listEntity;
                });

            //xhrObj.abort();
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

                Drequest
                    .api("tree-item.find")
                    .param({search: devups.escapeHtml(this.search)})
                    .get((response) => {
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

            Drequest
                .api("tree-item.delete")
                .param({id: tree_item_id, "option": option})
                .get((response) => {
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
            Drequest
                .api("tree-item.create")
                .data({data: cc}).post((response) => {
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
            if (this.tree_items) {
                var toupdate = [];
                this.tree_items.forEach((item) => {
                    toupdate.push([item.id, item.position])
                })
                console.log(toupdate);
                Drequest
                    .api("tree-item.order")
                    .data({
                        tree_items: toupdate
                    }).raw((response) => {
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
                                            <strong class="">{{tree.name['en']}} | </strong>
                                        </li>
                                        <li class="breadcrumb-link">
                                            <a @click="init(tree_item, $index)">Main</a>
                                        </li>
                                        <li v-for="(cat, $index) in tree_itemtree" class="breadcrumb-link">
                                            <i class="fa fa-angle-right"></i>
                                            <a @click="backtoparent(cat, $index)">@{{cat.name['en']}}</a>
                                            
                                            <span class="material-icons" data-toggle="modal" data-target="#exampleModal">create</span>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel">
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
                                    
                            <li is="addchild" v-bind:key="tree.id+'addchild'" 
                                    :tree_items="tree_items"  :tree="tree" class="list-group-item"></li>
                                
                            <li is="childrenTree" v-for="(tree_item, $index) in orderedItems"
                                v-bind:key="tree_item.id" :tree="tree" 
                                :tree_item="tree_item" 
                                :langs="langs" 
                                :nbitem="orderedItems.length" 
                                :index="$index" 
                                class="list-group-item"></li>
                            
                        </ul>
                        <div v-if="ll.pagination > 1" class="dataTables_paginate paging_simple_numbers text-right">
                            <ul class="pagination">

                                <li v-for="n in ll.pagination" :class="'page-item '+ highlight(n) ">
                                    <a class="page-link"
                                       v-on:click="nextitems(n)"
                                       href="#"
                                       data-next="1">@{{ n }}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div style=" position: sticky;  top: 150px;" class="col-md-5">
                <tree_itemForm :langs="langs" :key="tree_item.id" v-if="tree_item.id" :tree_item="tree_item" ></tree_itemForm>
            </div>

        </div>

    `
})

var tree_itemview = new Vue({
    el: '#content',
    data: {
        trees: [],
        attributes: [],
        role: _role,
        tree: {},
        langs: langs,
        treeedit: {name: ''},
    },
    mounted() {
        Drequest.api("tree.lazyloading").get((response) => {
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
        edit(tree) {
            this.treeedit = tree
        },

        _delete(id, index) {

            if (!confirm("confirmer la suppression?"))
                return;

            Drequest.api("tree.delete?id=" + id).get((response) => {
                console.log(response);
                this.trees.slice(index, 1)
            });

        },

        create() {
            if (!this.treeedit.name)
                return null;

            Drequest.api("tree.create")
                .data({
                    tree: {
                        "name": this.treeedit.name
                    }
                })
                .raw((response) => {
                    console.log(response);
                    this.trees.push(response.tree)
                });
        },

        update(treeedit) {
            if (!treeedit.name)
                return null;

            if (treeedit.id) {
                Drequest.api("tree.update?id=" + treeedit.id)
                    //.param({id: treeedit.id})
                    .data({
                        tree: {
                            "name": treeedit.name
                        }
                    })
                    .raw((response) => {
                        console.log(response);
                        $.notify("Updated with success");
                    });

            } else {
                Drequest.api("tree.create")
                    .data({
                        tree: {
                            "name": treeedit.name
                        }
                    })
                    .raw((response) => {
                        console.log(response);
                        this.trees.push(response.tree)
                    });
            }
        },

    }
});

