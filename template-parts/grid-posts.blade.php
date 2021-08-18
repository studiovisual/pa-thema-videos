@notempty($args)
    @php
        $query = new WP_Query($args);
    @endphp

    @if($query->have_posts())
        <div class="row pa-w-list-videos">
            @while($query->have_posts())
                @php
                    $query->the_post();
                    $id = get_the_ID();
                @endphp

                <div class="pa-blog-item mb-4 mb-md-4 border-0 col-12 col-md-4 position-relative">
                    <div class="ratio ratio-16x9 mb-2">
                        <figure class="figure">
                            <img src="{{ check_immg(get_the_ID(), 'full') }}" class="figure-img img-fluid rounded m-0 w-100 h-100 object-cover" alt="{{ get_the_title() }}">

                            @hasfield('video_length')
                                <div class="figure-caption position-absolute w-100 h-100 d-block">
                                    <span class="pa-video-time position-absolute px-2 rounded-1">
                                        <i class="far fa-clock me-1" aria-hidden="true"></i> @videolength
                                    </span>
                                </div>
                            @endfield
                        </figure>	
                    </div>

                    <a class="stretched-link" href="{{ the_permalink() }}" title="{{ the_title_attribute() }}">
                        <h3 class="card-title fw-bold h6 pa-truncate-2">{!! get_the_title() !!}</h3>
                    </a>
                </div>
            @endwhile
        </div>

        @php(wp_reset_postdata())
    @else
        <p>Não há vídeos disponíveis</p>
    @endif
@endnotempty