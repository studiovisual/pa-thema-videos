<?php

if(file_exists($composer = __DIR__ . '/vendor/autoload.php'))
    require_once $composer;

define('PARENT_THEME_URI', get_template_directory_uri() . '/');
define('THEME_URI', get_stylesheet_directory_uri() . '/');
define('THEME_DIR', get_stylesheet_directory() . '/');
define('THEME_CSS', THEME_URI . 'assets/css/');
define('THEME_JS', THEME_URI . 'assets/js/');
define('THEME_IMGS', THEME_URI . 'assets/images/');

new \Blocks\ChildBlocks;

add_filter('popular-posts/settings/url', function() {
    return THEME_URI . 'vendor/lordealeister/popular-posts/';
});

// require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Leaders.class.php');
// require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_HomeFields.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_PostFields.class.php');
// require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Site-ministries.class.php');
// require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_Projects.class.php');
// require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_Leaders.class.php');
// require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_SliderHome.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Enqueue_Files.class.php');
// require_once(dirname(__FILE__) . '/classes/controllers/PA_Page_Lideres.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Util.class.php');
require_once(dirname(__FILE__) . '/classes/PA_Helpers.php');

/**
* Remove unused taxonomies
*/
add_action('init', function() {
    // unregister_taxonomy_for_object_type('xtt-pa-colecoes', 'post');
    unregister_taxonomy_for_object_type('post_tag', 'post');
    unregister_taxonomy_for_object_type('category', 'post');
    unregister_taxonomy_for_object_type('xtt-pa-regiao', 'post');
    
    
    // Desabilita blocos do tema
});

add_filter('blade/view/paths', function ($paths) {
    $paths = (array)$paths;

    $paths[] = get_stylesheet_directory();

    return $paths;
});

add_filter('template_include', function ($template) {
    $path = explode('/', $template);
    $template_chosen = basename(end($path), '.php');
    $template_chosen = str_replace('.blade', '', $template_chosen);
    $grandchild_template = dirname(__FILE__) . '/' . $template_chosen . '.blade.php';

    if(file_exists($grandchild_template)):
        blade($template_chosen);
        return '';
    endif;

    return $template;
});

/**
* Modify category query
*/
add_action('pre_get_posts', function($query) {
    if(is_admin() || !is_tax() || !$query->is_main_query())
        return $query;

    global $queryFeatured;
    $object = get_queried_object();
    
    $queryFeatured = new WP_Query(
        array(
            'posts_per_page' => 1,
            'post_status'	 => 'publish',
            'post__in'       => get_option('sticky_posts'),
            'tax_query'      => array(
                array(
                    'taxonomy' => $object->taxonomy,
                    'terms'    => array($object->term_id),
                ),
            ),
        )
    );

    if(empty($queryFeatured->found_posts)):
        $queryFeatured = new WP_Query(
            array(
                'posts_per_page' 	   => 1,
                'post_status'	 	   => 'publish',
                'ignore_sticky_posts ' => true,
                'tax_query'            => array(
                    array(
                        'taxonomy' => $object->taxonomy,
                        'terms'    => array($object->term_id),
                    ),
                ),
            )
        );
    endif;

    $query->set('posts_per_page', 15);
    $query->set('ignore_sticky_posts', true);
    $query->set('post__not_in', !empty($queryFeatured->found_posts) ? array($queryFeatured->posts[0]->ID) : null);

    return $query;
});

/**
* Filter save post to get video length
*/
add_action('acf/save_post', function($post_id) {
    if(get_post_type($post_id) != 'post')
        return;

    $url = parse_url(get_field('video_url', $post_id, false));
    $host = '';
    $id = '';

    if(empty($url))
        return;

    if(str_contains($url['host'], 'youtube') || str_contains($url['host'], 'youtu.be')):
        $host = 'youtube';

        if(array_key_exists('query', $url)):
            parse_str($url['query'], $params);
            $id = $params['v'];
        else:
            $id = str_replace('/', '', $url['path']);
        endif;
    elseif(str_contains($url['host'], 'vimeo')):
        $host = 'vimeo';
        $parts = explode('/', $url['path']);
        $id = $parts[count($parts) - 1];
    endif;

    if(!empty($host) && !empty($id))
        getVideoLength($post_id, $host, $id);
});



function InitPostUrls($permalink, $post, $leavename) {

    if($post->post_type == 'post') {
        // $permalink = '/editoria/%'.PATaxonomias::TAXONOMY_EDITORIAS.'%/%postname%/';
        $permalink = '/editoria/%xtt-pa-editorias%/%postname%/';
    }

    return $permalink;
}
function PostRewriteRules($bool, $object = null, $extra_query_vars = null) {
    $rewrite_rule = 'editoria/([^/]+)/([^/]+)/?$';
    $rewrite_redirect = 'index.php?name=$matches[2]&post_type=post&xtt-pa-editorias=$matches[1]';
    add_rewrite_rule( $rewrite_rule, $rewrite_redirect);

    flush_rewrite_rules();

    return $bool;
}

function ReplacePostUrls($permalink, $post, $leavename) {
    if($post->post_type == 'post') {

        $args = array(
            'object_type' => array(
                'post',
            ),
        );
        $output = 'names'; // or objects
        $operator = 'and'; // 'and' or 'or'
        $taxonomias = get_taxonomies($args, $output, $operator);

        $terms = wp_get_object_terms($post->ID, $taxonomias);
        foreach($terms as $term) {
            $permalink = str_replace('%'.$term->taxonomy.'%', $term->slug, $permalink);
        }
        foreach($taxonomias as $taxonomia)
            $permalink = str_replace('/%'.$taxonomia.'%', '', $permalink);
    }

    return $permalink;
}

add_filter( 'do_parse_request', 'PostRewriteRules', 3);
add_action( 'pre_post_link', 'InitPostUrls', 3, 3);
add_action( 'pre_post_link', 'ReplacePostUrls', 100, 3);


function enqueueAssets() {
    wp_enqueue_script(
        'adventistas-admin2', 
        get_stylesheet_directory_uri() . '/assets/scripts/admin.js', 
        array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
    );
}

add_action('enqueue_block_editor_assets', 'enqueueAssets');


add_filter('acf/fields/relationship/query', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query( $args, $field, $post_id ) {

    $args['post_status'] = 'publish';

    return $args;
}