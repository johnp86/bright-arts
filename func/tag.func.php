<?php

function get_tag_result($tag_id){

    $query = mysql_query("
        SELECT images . image_id, images . ext AS i
        JOIN image_tags ON i.image_tag_id = image_tags.image_id
        WHERE
        image_tags.tag_id = $tag_id
        ");
   // echo '<h1>',$query,'</h1>';

    while ($tag_row = mysql_fetch_assoc($query)){
        $tags[] = array(
            'id' => $tag_row['image_id'],
            'ext' => $tag_row['ext']
        );
    }
    return $tags;
}

?>
