@extends('admin.layout')
@section('title', 'List')

@section('layout_content')
    <div id="devman">
        <div class="row">
            <div class="col-lg-2">
                <select v-model="method" class="form-control" >
                    <option v-for="method in methods" class="form-control" >@{{ method }}</option>
                </select>
            </div>
            <div class="col-lg-8">
                <input v-model="base_url" class="form-control"/>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn" @click="send($event)" >send</button>
            </div>
            <div class="col-lg-12">
                <div class="form-group" >
                    <label v-for="pd in postdatas" class="form-control" >
                        <input v-model="postdata" :value="pd" type="radio"  /> @{{ pd }}
                    </label>
                </div>
                <textarea v-model="raw" class="form-control" ></textarea>
                <hr>
                <h3  >Response</h3>
                <div style="height: 300px; overflow: auto" id="jsonresult" >

                </div>
            </div>
        </div>
    </div>
@endsection

@section('jsimport')
    <script src="{{__admin}}plugins/vue.min.js"></script>
    <script>
        var restapi = new Vue({
            el: "#devman",
            data: {
                raw: "",
                base_url: "http://127.0.0.1/edition3ag/api/",
                methods: ['GET', 'POST'],
                postdatas: ['formdata', 'raw'],
                postdata: 'raw',
                method: 'GET',
                params: [],
                post: [],
            },
            methods: {
                globalcallback(response){
                    console.log(response)
                    $("#jsonresult").html("<pre>" + JSON.stringify(response, null, "\t") + "</pre>");
                },
                send(ev) {
                    console.log(this.base_url)
                    if(this.postdata === 'formdata')
                        Drequest.init(this.base_url)
                            .data(this.raw)
                            .post(this.globalcallback)
                    else if(this.postdata === 'raw')
                        Drequest.init(this.base_url)
                            .data(this.raw)
                            .post(this.globalcallback)
                }
            }
        })
    </script>
@endsection
