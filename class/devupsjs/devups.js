var devups = {

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