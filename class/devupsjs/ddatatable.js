/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var totalpage = $("#pagination-notice").data('notice');

$("#deletegroup").click(function () {
    ddatatable.groupdelete();
});
$("#checkall").click(function () {
    ddatatable.checkall();
});
$(".dcheckbox").click(function () {
    ddatatable.uncheckall();
});
var ddatatable = {
    currentpage : 1,
    per_page : 10,
    allchecked: false,
    getcheckbox: function () {
        return $("#dv_table").find('tbody').find("input[type=checkbox]");
    },
    getcheckboxchecked: function () {
        var $input = this.getcheckbox();
        var ids = [];
        $.each($input, function (i, input) {
            if(input.checked)
                ids.push(input.value);
        });
        return ids;
    },
    checkall : function () {
        var $input = this.getcheckbox();
        if(this.allchecked){
            this.allchecked = false;
            $.each($input, function (i, input) {
                //console.log(input);
                input.checked = false;
            });
        }else{
            this.allchecked = true;
            $.each($input, function (i, input) {
                //console.log(input);
                input.checked = true;
            });
        }
    },
    uncheckall: function () {
        if(this.allchecked){
            $("#checkall")[0].checked = false;
            this.allchecked = false;
        }
    },
    groupdelete: function () {
        var thisclass = this;
        this.groupaction(function (ids, $trs) {

            if(ids == ''){
                alert("Aucun element selectionné!")
                return false;
            }

            if(!confirm('Voulez-vous Supprimer les éléments selectionnés?')) return false;

            //$.get("services.php?path="+model.entity+".groupdelete&ids="+ids.join(), function (response) {
                console.log(ids.join());
                $.each($trs, function (i, tr) {
                    tr.remove();
                })
                thisclass.uncheckall();
            //}, 'json');
        });
    },
    groupaction : function (callback) {
        var ids = this.getcheckboxchecked();

        var $trs = [];
        $.each(ids, function (i, id) {
            $trs.push($("#"+id));
        });
        callback(ids, $trs);
    },
    search: function (form) {
        var $input = form.find('input');

        var dataget = '';
        $.each($input, function (i, input) {
            //console.log(input);
            dataget += "&" + $(input).attr('name') + "=" + $(input).val();
        });

        $.get("services.php?path="+model.entity+".datatable&next=1&per_page="+this.per_page+""+dataget, function (response) {
            //console.log(response);
            $("#dv_table").find("tbody").html(response.tablebody);
            $("#dv_table").find("input[type=reset]").removeClass("hidden");
        }, 'json');//
    },
    cancelsearch : function ($this) {
        $.get("services.php?path="+model.entity+".datatable&next=1&per_page="+this.per_page, function (response) {
            //console.log(response);
            $("#dv_table").find("tbody").html(response.tablebody);
            $("#dv_table").find("input[type=reset]").addClass("hidden");
        }, 'json');//
    },
    setperpage: function(per_page){
        this.per_page = per_page;
        this.page(1);
    },
    callback: function (response) {
        console.log(response);
    },
    orderasc:function (param) {
        console.log(param);
        $.get("services.php?path="+model.entity+".datatable&next="+this.currentpage+"&per_page="+this.per_page+"&"+param, function (response) {
            console.log(response);
            $("#dv_table").find("tbody").html(response.tablebody);
        }, 'json');//, 'json'
    },
    orderdesc:function (param) {
        console.log(param);
        $.get("services.php?path="+model.entity+".datatable&next="+this.currentpage+"&per_page="+this.per_page+"&"+param+" desc", function (response) {
            //console.log(response);
            $("#dv_table").find("tbody").html(response.tablebody);
        }, 'json');
    },
    previous: function () {
        if(currentpage > 1){
            $ul.find('next').removeClass('disabled');
            this.page(currentpage - 1);
        }
        // else if($a.hasClass("disabled"))
        //     $ul.find('previous').removeClass('disabled');
    },
    next: function () {
        if(currentpage < totalpage){
            $ul.find('previous').removeClass('disabled');
            this.page(currentpage + 1);
        }
    },
    page: function (index) {

        $.get("services.php?path="+model.entity+".datatable&next="+index+"&per_page="+this.per_page+"", function (response) {
            //console.log(response);
            $("#dv_table").find("tbody").html(response.tablebody);
        }, 'json');

    }
};


$("#datatable-form").submit(function (e) {
    e.preventDefault();
    ddatatable.search($(this));
});

$(".pagination").find("a").click(function (e) {
    e.preventDefault();
    var $a = $(this);
    var $ul = $(this).parents('ul');
    if($a.hasClass("previous")){
        ddatatable.previous();
    }else if($a.hasClass("next")){
        ddatatable.next();
    }else{
        datatable.currentpage = $a.data("next");
        ddatatable.page($a.data("next"));
    }

    //console.log($(this).data("next"));
});