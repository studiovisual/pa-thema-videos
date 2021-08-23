{{-- Player --}}
@hasfield('video_url', $post->ID)
    <div class="row mb-3">
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

    <div class="col-md-7 d-flex flex-column align-items-start">
        
        {{-- Title --}}
        <h1 class="single-title mb-2">{{ the_title() }}</h1>

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
    
    {{-- Shere --}}
    <div class="col-md-5">
        <div class="pa-share">
            <ul class="list-inline">
                <li class="list-inline-item">Compartilhar: </li>

                {{-- Twitter --}}
                <li class="list-inline-item">
                    <a rel="canonical" target="_blank" href="@php(linkToShare($post->ID, 'twitter'))">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>

                {{-- Facebook --}}
                <li class="list-inline-item">
                    <a rel="canonical" target="_blank" href="@php(linkToShare($post->ID, 'facebook'))">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>

                {{-- Whatssapp --}}
                <li class="list-inline-item">
                    <a rel="canonical" target="_blank" href="@php(linkToShare($post->ID, 'whatsapp'))" >
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </li>
            
            </ul>
        </div>
    </div>
</div>