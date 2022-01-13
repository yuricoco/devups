class Drequest {
    baseurl = __env;
    url = "";
    _param = {};
    _data = {};

    constructor() {

    }

    static localstorage() {
        if (localStorage.getItem('edition3ag')) {
            try {
                return JSON.parse(localStorage.getItem('edition3ag'));
            } catch (e) {
                localStorage.removeItem('edition3ag');
            }
        }
        return {};
    }

    static localsave(database) {
        localStorage.setItem('edition3ag', JSON.stringify(database))
    }

    static init(url) {
        let r = new Drequest();
        r.baseurl = url;
        r.url = "";
        return r;
    }

    static api(url) {
        let r = new Drequest();
        r.baseurl = __env + "api/" + url;
        return r;
    };

    param(_param) {
        this._param = _param;
        return this;
    };

    data(_data) {
        this._data = _data;
        return this;
    };

    toFormdata(_data) {
        var keys = Object.keys(_data);
        var values = Object.values(_data);

        var fd = new FormData();
        for (var i = 0; i < keys.length; i++) {
            if (typeof values[i] === 'object' && values[i] !== null)
                fd.append(keys[i], values[i].id)
            else
                fd.append(keys[i], values[i])
        }
        this._data = fd;
        return this;
    };

    post(callback) {
        console.log(this);
        //this._param.lang = __lang;
        //console.log(this.baseurl + this.url+ $.isEmptyObject(this._param)? "": "?"+ $.param(this._param));
        var keys = Object.keys(this._param);
        var param = (!keys.length) ? "" : "?" + $.param(this._param);
        return $.ajax({
            url: this.baseurl + this.url + param,
            data: this._data,
            cache: false,
            contentType: false,
            processData: false,
            method: "POST",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
            }
        });
    };

    raw(callback) {
        this._data = JSON.stringify(this._data);


        console.log(this);
        //console.log(this.baseurl + this.url+ $.isEmptyObject(this._param)? "": "?"+ $.param(this._param));
        var keys = Object.keys(this._param);
        var params = (!keys.length) ? "" : "?" + $.param(this._param);


        var request = new XMLHttpRequest();
// var params = "action=something";
        request.open('POST', this.baseurl + this.url + params, true);
        request.onreadystatechange = function () {
            //console.log(request.response);
            if (request.readyState == 4) {
                //alert("It worked!")
                callback(JSON.parse(request.response))
            }
        };
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//request.setRequestHeader("Content-length", params.length);
//request.setRequestHeader("Connection", "close");
        return request.send(this._data);

        this._data = JSON.stringify(this._data);
        console.log(this);
        //console.log(this.baseurl + this.url+ $.isEmptyObject(this._param)? "": "?"+ $.param(this._param));
        var keys = Object.keys(this._param);
        var param = (!keys.length) ? "" : "?" + $.param(this._param);
        return $.ajax({
            url: this.baseurl + this.url + param,
            data: this._data,
            cache: false,
            // contentType: false,
            // processData: false,
            method: "POST",
            "headers": {
                "Content-Type": "application/json",
                //"Cookie": "PHPSESSID=6e3493f4e1e185cd94f35ef9488ef63e"
            },
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
            }
        });
    };

    get(callback) {
        console.log(this._param)
        // this._param.lang = __lang;
        return $.ajax({
            url: this.baseurl + this.url, //+ $.isEmptyObject(this._param)? "": "?"+ $.param(this._param),
            data: this._param,
            method: "GET",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
            }
        });
    }
}