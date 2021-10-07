<?php

namespace Blocks\PAListVideosColumn;

use Blocks\Block;
use Blocks\Fields\MoreContent;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\ButtonGroup;
use WordPlate\Acf\Fields\Number;
use WordPlate\Acf\Fields\Relationship;
use WordPlate\Acf\Fields\Text;

/**
 * Class PAListVideosColumn
 * @package Blocks\PAListVideosColumn
 */
class PAListVideosColumn extends Block
{

    public function __construct()
    {
        // Set block settings
        parent::__construct([
            'title'       => 'IASD - Vídeos',
            'description' => 'Lista de vídeos em apenas uma coluna',
            'category'    => 'pa-adventista',
            'keywords'    => ['list', 'video'],
            'icon'        => 'playlist-video',
        ]);
    }

    /**
     * setFields Register ACF fields with WordPlate/Acf lib
     *
     * @return array Fields array
     */
    protected function setFields(): array
    {
        return array_merge(
            [
                Text::make('Título', 'title')
                    ->defaultValue('IASD - Vídeos')
                    ->required(),

                ButtonGroup::make('Modo', 'mode')
                    ->choices([
                        'manual'  => 'Manual',
                        'popular' => 'Mais vistos',
                        'latest' => 'Mais recentes'
                    ])
                    ->defaultValue('manual'),

                Relationship::make('Vídeos', 'items')
                    ->instructions('Selecione Vídeo')
                    ->postTypes(['post'])
                    ->filters([
                        'search',
                        'taxonomy'
                    ])
                    ->elements(['featured_image'])
                    ->min(1)
                    ->returnFormat('id') // id or object (default)
                    ->required()
                    ->conditionalLogic([
                        ConditionalLogic::if('mode')->equals('manual')
                    ]),

                Number::make('Quantidade', 'items_count')
                    ->min(1)
                    ->required()
                    ->defaultValue(4)
                    ->conditionalLogic([
                        ConditionalLogic::if('mode')->equals('popular')
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::if('mode')->equals('latest')
                    ])
            ],
            MoreContent::make()
        );
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
            'title'        => get_field('title'),
            'items'        => $items,
            'enable_link'  => get_field('enable_link'),
            'link'         => get_field('link'),
        ];
    }
    
}
