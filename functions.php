<?php

require_once 'vendor/autoload.php';
require_once (dirname(__FILE__) . '/classes/controllers/PA_ACF_Leaders.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_ACF_HomeFields.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_ACF_Site-ministries.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_CPT_Projects.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_CPT_Leaders.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_CPT_SliderHome.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Enqueue_Files.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Page_Lideres.php');

add_filter('blade/view/paths', function ($paths) {
    $paths = (array)$paths;

    $paths[] = get_stylesheet_directory();

    return $paths;
});

add_filter('template_include', function($template) {
    $path = explode('/', $template);
    $template_chosen = basename(end($path), '.php');
    $grandchild_template = dirname(__FILE__) . '/' . $template_chosen . '.blade.php';

    if(file_exists($grandchild_template))
        return blade($template_chosen);
  
    return $template;
});