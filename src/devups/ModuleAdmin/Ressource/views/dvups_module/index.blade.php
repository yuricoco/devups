
@extends('layout')
@section('title', 'List')


@section('cssimport')

                <style></style>
                
@show

@section('content')

        <div class="row">
                <div class="col-lg-12">
                        <ol class="breadcrumb">
                                <li class="active">
                                        <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Liste 
                                </li>
                        </ol>
                </div>
                <div class="col-lg-12"> <?= $__navigation  ?></div>
        </div>
        <div class="row">
                
        <div class="col-lg-12 col-md-12">
                
                    <?= Genesis::lazyloading($lazyloading, ['name']); ?>

        </div>
			
        </div>
        
@endsection

@section('jsimport')

                <script>
    function findindatabase(){
        $.get( "index.php?path=abonne.rest/datatable&search=" + $("#search").val(), function (response) {
                    console.log(response);
        });
    }
    
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("dv_table");
        console.log(table);
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1].innerHTML.toUpperCase();
            td += " " + tr[i].getElementsByTagName("td")[2].innerHTML.toUpperCase();
//            td += " " + tr[i].getElementsByTagName("td")[3].innerHTML.toUpperCase();
//            td += " " + tr[i].getElementsByTagName("td")[4].innerHTML.toUpperCase();
            search(tr, td, filter, i);
            
        }
    }
    function search(tr, td, filter, i) {
        if (td.indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
    </script>
@show