<?php

namespace Blocks\PACarouselVideos;

use Blocks\Block;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\ButtonGroup;
use WordPlate\Acf\Fields\Number;
use WordPlate\Acf\Fields\Relationship;
use WordPlate\Acf\Fields\Text;

/**
 * Class PACarouselVideos
 * @package Blocks\PACarouselVideos
 */
class PACarouselVideos extends Block
{

	public function __construct()
    {
		parent::__construct([
			'title' 	  => __('IASD - Videos - Carousel', 'iasd'),
			'description' => 'Block to show video content on carousel format.',
			'category' 	  => 'pa-adventista',
			'keywords' 	  => ['featured'],
			'icon' 		  => '<svg id="Icons" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" 
							xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<style type="text/css">.st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}</style>
							<polyline class="st0" points="25,11 27,13 25,15 "/><polyline class="st0" points="7,11 5,13 7,15 "/><path class="st0" 
							d="M29,23H3c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h26c1.1,0,2,0.9,2,2v16C31,22.1,30.1,23,29,23z"/><circle class="st0" cx="16" cy="28" r="1"/>
							<circle class="st0" cx="10" cy="28" r="1"/><circle class="st0" cx="22" cy="28" r="1"/></svg>',
		]);
	}

	/**
	 * set ACF Field
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array
    {
		return [
            Text::make(__('Title', 'iasd'), 'title')
                ->defaultValue(__('IASD - Videos - Carousel', 'iasd')),

			ButtonGroup::make(__('Mode', 'iasd'), 'mode')
				->choices([
					'manual'  => __('Manual', 'iasd'),
					'popular' => __('Popular', 'iasd'),
					'latest' => __('Latest', 'iasd'),
				])
				->defaultValue('manual'),

            Relationship::make(__('Itens', 'iasd'), 'items')
                ->instructions(__('Video select', 'iasd'))
                ->postTypes(['post'])
                ->filters([
                    'search',
                    'taxonomy'
                ])
                ->elements(['featured_image'])
                ->returnFormat('id') // id or object (default)
                ->required()
				->conditionalLogic([
					ConditionalLogic::if('mode')->equals('manual')
				]),

			Number::make(__('Quantity', 'iasd'), 'items_count')
				->min(1)
				->required()
				->defaultValue(4)
				->conditionalLogic([
					ConditionalLogic::if('mode')->equals('popular')
				])
				->conditionalLogic([
					ConditionalLogic::if('mode')->equals('latest')
				])
		];
	}

	/**
	 * with Inject fields values into template
	 *
	 * @return array
	 */
	public function with(): array
    {
		$items = array();
		$mode = get_field('mode');

        if($mode == 'manual')
            $items = get_field('items');
		elseif($mode == 'latest')
			$items = (new \WP_Query([
				'fields'         => 'ids',
				'posts_per_page' => get_field('items_count'),
			]))->posts;
        elseif(function_exists('get_popular_posts'))
            $items = get_popular_posts([
                'fields'         => 'ids',
                'posts_per_page' => get_field('items_count'),
            ])->posts;

		return [
			'title'	=> get_field('title'),
			'items'	=> $items,
		];
	}

}
