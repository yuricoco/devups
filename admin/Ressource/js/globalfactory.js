/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


spacekolaApp.factory("langservice", function (internationalization) {

    var language = {
        getlang: function () {

            var lang = window.location.href;

            if (lang.includes('/fr/'))
                return internationalization.fr;
            else if (lang.includes("/en/"))
                return internationalization.en;
            else
                return internationalization.en;

        }
    };

    return language;

});


spacekolaApp.factory('globalfactory', function ($http, $httpParamSerializerJQLike) {
    return {
        user: {},
        setUser: function (user) {
            this.user = user;
        },
        getUser: function () {
            return this.user;
        },
        iduser: {},
        setIduser: function (iduser) {
            this.iduser = iduser;
        },
        getIduser: function () {
            return this.iduser;
        },
        asset: {},
        setAsset: function (asset) {
            this.asset = asset;
        },
        getAsset: function () {
            return this.asset;
        },
        api: getapi(),
        externservices: getexternservices(),
        services: getservice(),
        nodejsrout: getnodejsroute(),
        setServices: function (services) {
            this.services = services;
        },
        getServices: function () {
            return this.services;
        },
        routingGenerate: function (route, parameter) {
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
        },
        nodejsrouting: function (route, parameter) {
            var getAttr = "";
//            if (parameter) {
//                var keys = Object.keys(parameter);
//                var values = Object.values(parameter);
//                for (var i = 0; i < keys.length; i++) {
//                    getAttr += "&" + keys[i] + "=" + values[i];
//                }
//            }

            return this.nodejsrout + route + getAttr;
        },
        isPeriodeEvailable(startdate, enddate) {
            if (startdate !== enddate) {

                startdate = new Date(startdate);
                enddate = new Date(enddate);
                var today = new Date();

                if (startdate < today && enddate <= today && enddate > startdate) {

                    return true;

                    //                    else
                    //                        return false;
                }
            }
//                else{
            return false;
//                }
//                var diff = {}, tmp = enddate - startdate;
        },
        diffdate: function (date1) {
            date1 = new Date(date1);
            var date2 = new Date();
            var diff = {}, tmp = date2 - date1;
            diff.date = date1;
            tmp = Math.floor(tmp / 1000);             // Nombre de secondes entre les 2 dates
            diff.sec = tmp % 60;                    // Extraction du nombre de secondes

            tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
            diff.min = tmp % 60;                    // Extraction du nombre de minutes

            tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
            diff.hour = tmp % 24;                   // Extraction du nombre d'heures

            tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
            diff.day = tmp;

            return diff;

        },
        removeElementInArray: function (array, indexelement) {
            if (array.length > 1) {
                if (indexelement === 0)
                    array.splice(0, 1);
                else
                    array.splice(indexelement, 1);

                return array;
            } else {
                return [];
            }
        },
        getDuree: function (date) {
            var diff = this.diffdate(date);
            var duree = "";
            if (diff.day) {
                if (diff.day === 1)
                    duree = " hier ";
                else
                    duree = diff.day + " j";
            } else if (diff.hour) {
                duree = "il y a " + diff.hour + " h";
            } else if (diff.min) {
                duree = "depuis " + diff.min + " min";
            } else if (diff.sec) {
                duree = "il y a un instant";
            }

            return duree;
        },
        escapeHtml: function (text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            if (text)
                return text.replace(/[&<>"']/g, function (m) {
                    return map[m];
                });
        },
        jsonParse: function (jsobject) {
            var cache = [];
            var jsondata = JSON.stringify(jsobject, function (key, value) {
                if (typeof value === 'object' && value !== null) {
                    if (cache.indexOf(value) !== -1) {
                        // Circular reference found, discard key
                        return;
                    }
                    // Store value in our collection
                    cache.push(value);
                }
                return value;
            });
            cache = null;
            return jsondata;
        },
        formdate: function (date) {
            return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
        },
        formtime: function (time) {
            return time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds();
        },
        debug: function (response) {
            $("#debug").find('.modal-body').html(response);
            $("#debug").modal('show');
        },
        initVar: function (url, callback) {
            $http.get(url).success(function (response) {
                if (callback)
                    callback(response);
            }).error(function (resultat, statut, erreur) {
                console.log(erreur);
                console.log(resultat);
//                $("#main-space").html(resultat);
//                $('#err').html(resultat.responseText);
//                $('#log_erreur').append(resultat.responseText);
            });
        },

        xmlrequeste: function (url, formdata, callback) {

            $http.post(url, formdata, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            })

                    .success(function (result) {
                        console.log(result);
                        if (result === 'sessionoff') {
                            window.location.href = getservice()+"signin";
                        } else {
                            if (callback !== null)
                                callback(result);
                        }
                    })

                    .error(function (resultat, statut, erreur) {
                        $(".modal").hide();
                        console.log(erreur);
                        console.log(resultat);
//                        $("#main-space").html(resultat);
//                        $('#err').html(resultat.responseText);
//                        $('#log_erreur').append(resultat.responseText);
                    });
        },
        getnode: function(url, callback){
            $http.get(url).success( function (response) {
                console.log(response);
                callback(response);
            });
        },
        postnode: function(url, data, callback){
            $http.post(url, data).success( function (response) {
                console.log(response);
                callback(response);
            });
        }

    };
});

