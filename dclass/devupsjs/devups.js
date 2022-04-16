function _t(key) {
    var lang = _local_content[key];

    if (lang)
        return lang;

    return key;
}

var devups = {
    el: "",
    togglemore(el) {
        if (el === this.el) {
            this.el = "";
            $(".more-dropdown").css({
                visibility: "hidden",
                opacity: 0,
                transition: "0s",
            });
            return;
        }
        this.el = el;

        $(".more-dropdown").css({
            visibility: "hidden",
            opacity: 0,
            transition: "0s",
        });

        if (!$(el).find(".more-dropdown").length)
            return;

        $(el).find(".more-dropdown").css({
            visibility: "visible",
            opacity: 1,
            transition: ".5s",
        });
    },
    formatDate() {
        var d = new Date(),
            hour = '' + (d.getHours()),
            min = '' + (d.getMinutes()),
            sec = '' + (d.getSeconds()),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        if (hour.length < 2) hour = '0' + hour;
        if (min.length < 2) min = '0' + min;
        if (sec.length < 2) sec = '0' + sec;

        return [year, month, day].join('-') + ' ' + [hour, min, sec].join(':');

    },
    validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    },
    urlify(text) {
        var urlRegex = /(https?:\/\/[^\s]+)/g;
        return text.replace(urlRegex, function (url) {
            return '<a href="' + url + '" target="_blank" >' + url + '</a>';
        })
        // or alternatively
        // return text.replace(urlRegex, '<a href="$1">$1</a>')
    },
    routing: function (route, parameter) {
        var getAttr = "";
        if (parameter) {
            var keys = Object.keys(parameter);
            var values = Object.values(parameter);
            for (var i = 0; i < keys.length; i++) {
                getAttr += "&" + keys[i] + "=" + values[i];
            }
        }

        return model.baseurl + "services.php?path=" + route + getAttr;
    },
    upload: function (file, url, onprogress, onload, oncomplete, _datatype, _postname, form) {

        if (!_postname)
            _postname = "file";

        var xhr = new XMLHttpRequest();
        xhr.open('POST', url);

        xhr.upload.onprogress = function (e) {
            console.log(e.loaded);
            onprogress(e.loaded, e.total, e);
        };

        xhr.onload = function () {
            console.log('Upload terminé !');
            onload(xhr.response);
        };
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.response);
                if (_datatype == "json")
                    try {
                        oncomplete(JSON.parse(xhr.response));
                    } catch (e) {
                        console.log(e); // error in the above string (in this case, yes)!
                        oncomplete(e)
                    }
                else
                    oncomplete(xhr.response)
            }
        };

        if (!form)
            form = new FormData();

        form.append(_postname, file);
        form.append("user_local_date", devups.formatDate());
        xhr.send(form);
    },
    sessionoff: function (response, url) {
        if (!response.session)
            return;

        if (url) {
            window.location.href = url;
        } else {
            window.location.reload();
        }
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
    escapeHtml: function (text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
            '↵': '<br>'
        };
        if (text)
            return text.replace(/↵[&<>"']/g, function (m) {
                return map[m];
            });
    },
    round: function (variable) {
        return Math.round(variable * 100) / 100;
    },
    lastnotification: null,
    notified(el) {
        $(el).find(".badge-counter").fadeOut();
        var $notified = $("#notification-block");
        var ids = []
        $notified.find("input").each((i, el) => {
            console.log(i, el)
            ids.push(el.value)
        })
        console.log(ids)
        Drequest.api("notified")
            .toFormdata({ids: ids.join()})
            .post((response) => {
                console.log(response)
                $notified.find("a").removeClass("bg-info", function () {

                })
            })

    },
    callbackNotification(response) {
        var nbnotif = response.notifications.length;
        if (nbnotif === 0)
            return;

        this.lastnotification = response.notifications[nbnotif - 1].created_at
        for (let item of response.notifications)
            $("#notification-items").prepend(item.html)

        $("#notification-block").find("#notif-ping").show().html(response.unreaded+"")
        $.notify(`vous avez ${nbnotif} nouvelles notifications`, "info")

    },
    initNotification(id, date) {
        Drequest.api(`lazyloading.notificationbroadcasted?dfilters=on&admin.id:eq=${id}&ping:eq=1&created_at:let=` + date)
            .get((response) => {
                console.log(response)
                devups.callbackNotification(response)
            })
    },
    timerNotification(id, date) {

        // else {
        //     this.initNotification(id, date)
        //     return 1;
        // }

        setInterval(() => {
            if (this.lastnotification) {
                date = this.lastnotification
            }
            Drequest.api(`notificationbroadcasted.alert?jsonmodel=html&adminid=${id}&ping=1&date=` + date)
                .get((response) => {
                    console.log(response)
                    devups.callbackNotification(response)
                })
        }, 30000)

    }
};
