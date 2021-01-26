class Drequest {
    baseurl = __env;
    url = "";
    _param = {};
    _data = {};

    constructor() {

    }

    static init(url) {
        let r = new Drequest();
        r.baseurl = url;
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

    post(callback) {
        return $.ajax({
            url: this.baseurl + this.url +"?"+ $.param(this._param),
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
        return $.ajax({
            url: this.baseurl + this.url,
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