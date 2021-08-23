{{-- Player --}}
@hasfield('video_url', $post->ID)
    <div class="row">
        <div class="col-12">
            <div class="embed-container">
                @hasfield('video_url', $post->ID)
                    {!! get_field('video_url', $post->ID) !!}
                @endfield
            </div>
        </div>
    </div>
@endfield

<div class="row my-4">
    <div class="col-md-11 d-flex flex-column align-items-start">
        
        {{-- Title --}}
        <h1 class="single-title mt-3 mb-2">{{ the_title() }}</h1>

        {{-- Tempo do vídeo --}}
        <div class="figure-caption d-flex align-items-center justify-content-start">
            <span class="pa-video-time rounded-1">
                <i class="far fa-clock me-1"></i> 
                @hasfield('video_url', $post->ID)
                    @videolength($post->ID)
                @endfield
            </span>
            <span class="mx-2">|</span>
            <span>@getPrioritySeat($post->ID) </span>
        </div>
    </div>
    <div class="col-md-3">
        {{-- Espaço destinado ao botão de compartilhar --}}
    </div>
</div>