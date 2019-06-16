
//var mainApp = angular.module("filemanagerApp", ['file-model']);//, mainpp = angular.module("mainpp", []);
    
    main.service('filemanage', function()
    {
        
        this.upload_multiple_file = {
                    upload : function(entityname, entity, images, file, callback){
                            console.log("autres vues");
                            var fd = new FormData();
                            if(file){
                                    for(i = 0; i < file.length; i++){
                                            fd.append('upload_images[]', file[i]);
                                    }
                            }
                            if(images)
                                    fd.append('images', images);
                            else
                                    fd.append('images', '');

                            //xmlrequeste("index.php?path="+entityname+".rest/image_edit&id="+entity.id, fd, callback);
                            $("input[type=file]").val('');
                    },
                    deleteimage : function(entity, i){
                        console.log(entity.imageList);
                            if(entity.imageList){
                                $.each(entity.imageList, function(index, image){
                                        if(index == i){
                                                if(index == 0)
                                                        entity.imageList.splice(0, 1);
                                                else
                                                        entity.imageList.splice(index, 1);
                                        }
                                });
                                return entity.imageList;
                            }else{
                                return [];
                            }
                    }
            };
            
    });
