
var drequest = function (){
    self = this;
    self.baseurl = __env;
    self._param = {};
    self.api = function (url){
        self.url = url;
        return self;
    };
    self.param = function (_param){
        self._param = _param;
        return self;
    };
    self.sendformdata = function (callback){
        return $.ajax({
            url: this.baseurl+self.url,
            data: self._param,
            cache: false,
            contentType: false,
            processData: false,
            method: "POST",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
            }});
    };
    self.send = function (callback){
        $.ajax({
            url: this.baseurl+self.url,
            data: self._param,
            method: "POST",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
            }
        });
    }
}