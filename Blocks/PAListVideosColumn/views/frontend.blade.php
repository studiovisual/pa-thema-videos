@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAListVideosColumn/preview.png"/>
@else
	
	<div class="pa-widget pa-w-list-posts col-md-4">
			
		@isset($items)

			<h2 class="mb-4">{{ $title }}</h2>

			@foreach ($items as $id)
			<div class="card mb-2 mb-xl-4 border-0">
				<a href="{{ get_the_permalink($id) }}" title="{{ get_the_title($id) }}"">
					<div class="row">
						<div class="col-6">
							<div class="ratio ratio-16x9">
								<figure class="figure m-xl-0">
									<img src="{{ check_immg($id, 'full') }}" class="figure-img img-fluid rounded m-0" alt="{{ get_the_title($id) }}">
								</figure>	
							</div>
						</div>
						<div class="col-6">
							<div class="card-body p-0">
								<h3 class="card-title h6">{{ get_the_title($id) }}</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach

			@if ($enable_link AND $link)
				<a href="{{ $link }}" class="pa-all-content">Ver todas os vídeos</a>
			@endif

		@else

		<p>Não foi encontrado nenhum post para esta seção.</p>

		@endisset
		
	</div>
@endif