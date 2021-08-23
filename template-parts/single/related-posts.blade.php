{{-- Title --}}
<div class="row">
    <div class="col-12">
        <h2>Vídeos Relacionados</h2>
    </div>
</div>

{{-- Vídeos --}}
<div class="row">

    @foreach (getRelatedPostsByDepartment($post->ID) as $post)

    {{-- <pre><?php var_dump($item) ?></pre> --}}

        <div class="col-4 mb-4">
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
        
    @endforeach

</div>