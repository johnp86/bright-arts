function like_add(image_id){
    /*Posting to file in ajax folder. Then pass a variable through
    that variable is the first image_id {image_id:image_id}, the second is the value given to it
    then caaling a callback function witht the parameter 'data'*/
    $.post('ajax/like_add.php', {image_id:image_id}, function(data){
        if(data == 'success'){
            //call function to update like number
            like_get(image_id);
        }else{
            //this is mainly to stop people repeatly pressing like
            alert(data);
        }
    });
}

function like_get(image_id){
    //data now contains number of likes
    $.post('ajax/like_get.php', {image_id:image_id}, function(data){
        //set the specific tag to equal to the data(like number)
        $('#image_'+ image_id +'_likes').text(data);
    })
}