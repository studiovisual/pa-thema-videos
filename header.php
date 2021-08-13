<!doctype html>
<html <?php language_attributes(); ?>>

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>

</head>

<body <?php body_class(get_field('departamento', 'option') ? : ""); ?>>

    <div class="pa-creation-grid d-flex">
        <div class="pa-content-column flex-grow-1 d-block">

            <?php get_template_part('components/menu/main', 'menu') ?>

            /** Incluide original. Esta ativado no tema pai, mas não consta no layout enviado  */
            <?php //require(get_stylesheet_directory() . '/template-parts/slider-front-page.php') ?> 

            <?php get_template_part('components/header/title') ?>

            <?php get_template_part('components/header/breadcrumbs') ?>


