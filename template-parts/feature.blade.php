@php
    $query = new WP_Query(
        array(
            'posts_per_page'      => 1,
            'post_status'	      => 'publish',
            'post__in'            => get_option('sticky_posts'),
            'ignore_sticky_posts' => 1,
        )
    );
@endphp

@if($query->have_posts())

    <h2 class="mb-4">Destaque</h2>

    @while($query->have_posts())
        @php($query->the_post())

        <div class="pa-blog-feature">
            <a href="{{ the_permalink() }}" title="{{ the_title_attribute() }}">
                <div class="ratio ratio-16x9">
                    <figure class="figure m-xl-0 w-100">
                        <img src="{{ check_immg(get_the_ID(), 'full') }}" class="figure-img img-fluid m-0 rounded w-100 h-100" alt="{{ get_the_title() }}">
                    </figure>
                </div>
            </a>
        </div>
    @endwhile

    @php(wp_reset_postdata())
@endif