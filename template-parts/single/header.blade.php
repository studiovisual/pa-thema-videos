{{-- Player --}}
@hasfield('video_url', get_the_ID())
    <div class="row mb-3">
        <div class="col-12">
          @hasfield('video_url', get_the_ID())
            <div class="embed-container">
              {!! get_field('video_url', get_the_ID()) !!}  
            </div>
          @endfield
        </div>
    </div>
@endfield

<div class="row my-4">
    <div class="col-md mb-4 mb-md-0 d-flex flex-column align-items-start">
        {{-- Title --}}
        <h1 class="single-title mb-2">{{ the_title() }}</h1>

        {{-- Tempo do vídeo --}}
        <div class="figure-caption d-flex align-items-center justify-content-start">
            @hasfield('video_url', get_the_ID())
                <span class="pa-video-time rounded-1">
                    <em class="far fa-clock me-1"></em>        

                    @videolength(get_the_ID())
                </span>

                <span class="mx-2">|</span>
            @endfield

            <span>@getPrioritySeat(get_the_ID()) </span> 
        </div>
    </div>
    
    {{-- Shere --}}
    <div class="col-auto">
        <div class="pa-share">
            <ul class="list-inline">
                <li class="list-inline-item">{{ __('Share:', 'iasd') }} </li>

                {{-- Twitter --}}
                <li class="list-inline-item">
                    <a target="_blank" rel="noopener" href="@php(linkToShare(get_the_ID(), 'twitter'))">
                        <em class="fab fa-twitter"></em>
                    </a>
                </li>

                {{-- Facebook --}}
                <li class="list-inline-item">
                    <a target="_blank" rel="noopener" href="@php(linkToShare(get_the_ID(), 'facebook'))">
                        <em class="fab fa-facebook-f"></em>
                    </a>
                </li>

                {{-- Whatssapp --}}
                <li class="list-inline-item">
                    <a target="_blank" rel="noopener" href="@php(linkToShare(get_the_ID(), 'whatsapp'))" >
                        <em class="fab fa-whatsapp"></em>
                    </a>
                </li>
            
            </ul>
        </div>
    </div>
</div>
