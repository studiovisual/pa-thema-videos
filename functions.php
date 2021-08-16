<?php

if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    require_once $composer;
}

new \Blocks\ChildBlocks();

define('PARENT_THEME_URI', get_template_directory_uri() . '/');
define('THEME_URI', get_stylesheet_directory_uri() . '/');
define('THEME_DIR', get_stylesheet_directory() . '/');
define('THEME_CSS', THEME_URI . 'assets/css/');
define('THEME_JS', THEME_URI . 'assets/js/');
define('THEME_IMGS', THEME_URI . 'assets/images/');

require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Leaders.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_HomeFields.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Site-ministries.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_Projects.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_Leaders.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_CPT_SliderHome.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Enqueue_Files.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Page_Lideres.php');

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

    if (file_exists($grandchild_template)) {
        return blade($template_chosen);
    }

    return $template;
});

/**
* Modify category query
*/
add_action('pre_get_posts', function($query) {
    if(is_admin() || !is_category() || !$query->is_main_query())
        return $query;

    global $queryFeatured;
    $queryFeatured = new WP_Query(
        array(
            'posts_per_page' => 1,
            'post_status'	 => 'publish',
            'cat'			 => get_query_var('cat'),
            'post__in'       => get_option('sticky_posts'),
        )
    );

    if(empty($queryFeatured->found_posts)):
        $queryFeatured = new WP_Query(
            array(
                'posts_per_page' 	   => 1,
                'post_status'	 	   => 'publish',
                'cat'			 	   => get_query_var('cat'),
                'ignore_sticky_posts ' => true,
            )
        );
    endif;

    $query->set('posts_per_page', 15);
    $query->set('ignore_sticky_posts', true);
    $query->set('post__not_in', !empty($queryFeatured->found_posts) ? array($queryFeatured->posts[0]->ID) : null);

    return $query;
});
