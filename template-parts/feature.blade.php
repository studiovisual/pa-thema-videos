@notempty($post)
    <div class="pa-blog-itens mb-5">
        <h2 class="mb-4">Destaque</h2>

        <div class="pa-blog-feature pa-w-list-videos">
            <a href="{{ get_the_permalink($post->ID) }}" title="{{ get_the_title($post->ID) }}">
                <div class="ratio ratio-16x9">
                    <figure class="figure m-xl-0 w-100">
                        <img src="{{ check_immg($post->ID, 'full') }}" class="figure-img img-fluid m-0 rounded w-100 h-100 object-cover" alt="{{ get_the_title($post->ID) }}">

                        <div class="figure-caption position-absolute w-100 h-100 d-block">
                            <i class="pa-play far fa-play-circle position-absolute" aria-hidden="true"></i>
                        </div>
                    </figure>
                </div>
            </a>
        </div>
    </div>
@endnotempty