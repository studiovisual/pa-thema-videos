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


/**
 * Search the first priority seat of the post
 *
 * @param string $post_id The post ID
 * @return string
 */
function getPrioritySeat($post_id) : string
{
    if ($term = get_the_terms($post_id, 'xtt-pa-owner'))
        return $term[0]->name;

    return 'Não há nenhuma sede proprietária vinculada a este post.';
}


/**
 * Search the first department of the post
 *
 * @param string $post_id The post ID
 * @return string
 */
function getDepartment($post_id) : string
{
    if ($term = get_the_terms($post_id, 'xtt-pa-departamentos'))
        return $term[0]->name;

    return 'Não há nenhum departamento vinculado a este post.';
}



/**
 * Search the related posts by department
 *
 * @param string $post_id The post ID
 * @param int $limit Maximum posts per query. Default = 6
 * @return array
 */
function getRelatedPostsByDepartment($post_id, $limit = 6) : array
{
    if ($term = get_the_terms($post_id, 'xtt-pa-departamentos')) {

        $args = array(
            'post_type' => 'post',
            'tax_query' => array(
                array(
                    'taxonomy' => 'xtt-pa-departamentos',
                    'terms'    => $term[0]->name,
                ),
            ),
            'posts_per_page' => $limit
        );
        
        return get_posts($args);
    }

    return 'Não foi possível localizar outros posts, porque não há nenhum departamento vinculado a este post.';
}