@php 
	get_header(); 
	require(get_template_directory() . '/components/parent/header.php'); 
	
@endphp
	<div class="pa-content py-5">
		<div class="container">
			<div class="row row-cols-auto">
				<article class="col-12 col-md-8">
					@if(get_query_var('paged') < 1)
						<div class="pa-blog-itens mb-5">
							@include('template-parts.feature')
						</div>
					@endif

					<div class="pa-blog-itens my-5">
						<h2 class="mb-4">Últimas postagens</h2>

						@php 
							$args = array(
								'post_status'	=> 'publish',
								'post__not_in' => array($sticks[0]),
								'ignore_sticky_posts' => 1,
								'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
							);
							pa_blog_itens($args);
						@endphp
					</div>
					
					<div class="pa-pg-numbers row">
						<?php 
							$PaPageNumbers = new PaPageNumbers();
						?>
					</div>

				</article>

				<aside class="col-md-4 d-none d-xl-block">
					@if(is_active_sidebar( 'archive'))
						{!! dynamic_sidebar('archive') !!}
					@endif
				</aside>
			</div>
		</div>
	</div>

{!! get_footer() !!}
