@notempty($args)
    @php
        $query = new WP_Query($args);
    @endphp

    @if($query->have_posts())
        @while($query->have_posts())
            @php($query->the_post())

            <div class="pa-blog-item mb-4 mb-md-4 border-0">
                <a href="<?= the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <div class="row">

                        <?php if(has_post_thumbnail()) : ?>

                            <div class="col-5 col-md-4">
                                <div class="ratio ratio-16x9">
                                    <figure class="figure m-xl-0">
                                        <img src="<?= check_immg(get_the_ID(), 'full'); ?>" class="figure-img img-fluid rounded m-0 h-100 w-100" alt="...">
                                    </figure>	
                                </div>
                            </div>

                        <?php endif; ?>

                        <div class="col">
                            <div class="card-body p-0 <?= has_post_thumbnail() ?: 'pl-4 py-4 border-left border-5 pa-border'?>">
                                <h3 class="fw-bold h6 mt-xl-2 pa-truncate-4"><?= get_the_title(); ?></h3>
                                <p class="d-none d-xl-block"><?= wp_trim_words(get_the_excerpt(), 30)  ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endwhile

        @php(wp_reset_postdata())
    @else
        <p>Não há vídeos disponíveis</p>
    @endif
@endnotempty