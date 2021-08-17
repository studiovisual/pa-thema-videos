<?php

/**
 * videoLength Format video length in 'mm:ss'
 *
 * @param  int $post_id The post ID
 * @return string Formated length string
 */
function videoLength(int $post_id = 0): string {
    $length = get_field('video_length', !empty($post_id) ? $post_id : get_the_ID());

    if(empty($length))
        return "";

    if($length / 3600 >= 1)
        return sprintf('%02d:%02d:%02d', ($length / 3600), ($length / 60 % 60), $length % 60);
    else
	    return sprintf('%02d:%02d', ($length / 60 % 60), $length % 60);
}