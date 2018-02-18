/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('#image_edit').on('click', '.supp', function(){
    var image = $(this).next('img').attr('alt'), listImage ='';
    var $form = $(this).parents('form');
    $(this).parents('.blockimg').remove();
    
    $.each($('.image'), function(index, value){
        if(image !== $(this).attr('alt')){
            listImage += $(this).attr('alt')+',';
        }
    });
    listImage = listImage.substring(0, listImage.length - 1);
    $('textarea').val(listImage);
	console.log($form.attr("action"));
    //rest('index.php?path=projet_image_edit_rest&id='+$('form').attr('id'), listImage);
    
});

$('#imagelistsp').on('click', '.supp', function(){
    var image = $(this).next('img').attr('alt'), listImage ='';
    $(this).parents('.blockimg').remove();
    
    $.each($('.image'), function(index, value){
        if(image !== $(this).attr('alt')){
            listImage += $(this).attr('alt')+',';
        }
    });
    listImage = listImage.substring(0, listImage.length - 1);
    $('textarea').val(listImage);
    rest('root.php?path=sousprojet_image_edit_rest&id='+$('form').attr('id'), listImage);
    
});

$('#imagelistcamp').on('click', '.supp', function(){
    var image = $(this).next('img').attr('alt'), listImage ='';
    $(this).parents('.blockimg').remove();
   
    $.each($('.image'), function(index, value){
        if(image !== $(this).attr('alt')){
            listImage += $(this).attr('alt')+',';
        }
    });
    listImage = listImage.substring(0, listImage.length - 1);
    $('textarea').val(listImage);
    rest('root.php?path=campagne_image_edit_rest&id='+$('form').attr('id'), listImage);
    
});


function rest(url, listImage){
    console.log(url);
    $.post(
            url, 
            {
                images:  listImage
            },
            function(data){
                //$('#err').html(data);
                console.log(data);
            }, 
            'text'
    );
}