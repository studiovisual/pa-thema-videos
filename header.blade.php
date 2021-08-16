<!doctype html>
<html {{ language_attributes() }}>

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! wp_head() !!}

</head>

<body {{ body_class(get_field('departamento', 'option') ? : "") }}>

    <div class="pa-creation-grid d-flex">
        <div class="pa-content-column flex-grow-1 d-block">

        @include('components.menu.main-menu')
        @include('components.header.title')
        @include('components.header.breadcrumbs')


