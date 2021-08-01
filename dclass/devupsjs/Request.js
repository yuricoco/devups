class Drequest {
    baseurl = __env;
    url = "";
    _param = {};
    _data = {};

    constructor() {

    }

    static localstorage(){
        if (localStorage.getItem('edition3ag')) {
            try {
                return  JSON.parse(localStorage.getItem('edition3ag'));
            } catch(e) {
                localStorage.removeItem('edition3ag');
            }
        }
        return {};
    }
    static localsave(database){
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
        r.baseurl = __env+"api/"+url;
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
        //console.log(this.baseurl + this.url+ $.isEmptyObject(this._param)? "": "?"+ $.param(this._param));
        var keys = Object.keys(this._param);
        var param = (!keys.length) ? "": "?"+ $.param(this._param);
        return $.ajax({
            url: this.baseurl + this.url+ param,
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
        return this.post(callback);
    };

    get(callback) {
        console.log(this._param)
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