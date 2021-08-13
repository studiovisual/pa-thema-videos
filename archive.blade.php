@extends('layouts.app')

@section('content')
<div class="pa-content py-5">
	<div class="container">
		<div class="row row-cols-auto">
			<section class="col-12{{ is_active_sidebar('archive') ? ' col-md-8' : '' }}">
				@if(get_query_var('paged') < 1)
					<div class="pa-blog-itens mb-5">
						@include('template-parts.feature')
					</div>
				@endif

				<div class="pa-blog-itens mt-5 mb-4">
					<h2 class="mb-4">{{ single_term_title() }}</h2>

					@include('template-parts.grid-posts', [
						'args' => array(
							'post_status'		  => 'publish',
							'post__not_in' 		  => !empty($sticks) ? array($sticks[0]) : null,
							'posts_per_page'	  => 15,
							'ignore_sticky_posts' => 1,
							'cat'				  => get_query_var('cat'),
							'paged' 			  => (get_query_var('paged')) ? get_query_var('paged') : 1,
						),
					])
				</div>
				
				<div class="pa-pg-numbers row">
					@php(new PaPageNumbers())
				</div>
			</section>

			@if(is_active_sidebar('archive'))
				<aside class="col-md-4 d-none d-xl-block">
					{!! dynamic_sidebar('archive') !!}
				</aside>
			@endif
		</div>
	</div>
</div>
@endsection
