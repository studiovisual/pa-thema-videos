@php 
	get_header(); 
	require(get_template_directory() . '/components/parent/header.php'); 
@endphp

@yield('content')

{!! get_footer() !!}