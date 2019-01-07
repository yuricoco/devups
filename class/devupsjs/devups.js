var devups = {

    upload: function  (file, url, onprogress, onload, oncomplete, _datatype, _postname) {

        if(!_postname)
            _postname = "file";

        var xhr = new XMLHttpRequest();
        xhr.open('POST', url);

        xhr.upload.onprogress = function(e) {
            console.log(e.loaded);
            onprogress(e.loaded, e.total, e);
        };

        xhr.onload = function() {
            console.log('Upload terminé !');
            onload(xhr.response);
        };
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.response);
                if(_datatype == "json")
                    try {
                        oncomplete(JSON.parse(xhr.response));
                    } catch(e) {
                        console.log(e); // error in the above string (in this case, yes)!
                        oncomplete(e)
                    }
                else
                    oncomplete(xhr.response)
            }
        };
        var form = new FormData();
        form.append(_postname, file);
        xhr.send(form);
    },
    sessionoff : function(response, url){
        if(!response.session)
            return;

        if(url){
            window.location.href = url;
        }else{
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
    round: function(variable){
        return Math.round(variable*100)/100;
    }
};