<?php

namespace Blocks;

use Blocks\PACarouselVideos\PACarouselVideos;
use Blocks\PAFeaturePost\PAFeaturePost;
use Blocks\PAListVideosColumn\PAListVideosColumn;

class ChildBlocks
{


    public function __construct()
    {
        \add_filter('acf_gutenblocks/blocks', [$this, 'registerChildBlocks']);
    }

    /**
     */
    public function registerChildBlocks(array $blocks): array
    {
        $newBlocks = [
            PAFeaturePost::class,
            PAListVideosColumn::class,
            PACarouselVideos::class
        ];

        return array_merge($blocks, $newBlocks);
    }
}
