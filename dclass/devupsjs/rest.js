/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var routingGenerate = function (route, parameter) {
    var getAttr = "";
    if (parameter) {
        var keys = Object.keys(parameter);
        var values = Object.values(parameter);
        for (var i = 0; i < keys.length; i++) {
            getAttr += "&" + keys[i] + "=" + values[i];
        }
    }
    if(this.externservices)
        return this.api + "api.php?extern=1&path=" + route + getAttr;
    else
        return this.api + "api.php?path=" + route + getAttr;
}
