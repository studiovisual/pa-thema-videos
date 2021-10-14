<?php

namespace Blocks\PAListVideosColumn;

use Blocks\Block;
use Extended\LocalData;
use Fields\MoreContent;
use Extended\TaxonomyTerms;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\ButtonGroup;
use WordPlate\Acf\Fields\Number;
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
                        'manual'  => 'Últimos posts',
                        'popular' => 'Mais vistos',
                    ])
                    ->defaultValue('manual'),

                LocalData::make('Vídeos', 'items')
                    ->instructions('Selecionar vídeos')
                    ->postTypes(['post'])
                    ->initialLimit(4)
                    ->manualItems(false)
                    ->conditionalLogic([
                        ConditionalLogic::if('mode')->equals('manual')
                    ]),

                TaxonomyTerms::make('Taxonomias', 'taxonomies')
                  ->stylisedUi()
                  ->loadTerms(false)
                  ->saveTerms(false)
                  ->useAjax()
                  ->multiple()
                  ->returnFormat('object')
                  ->fieldType('select')
                  ->taxonomies([
                    'xtt-pa-colecoes',
                    'xtt-pa-editorias',
                    'xtt-pa-departamentos',
                    'xtt-pa-projetos',
                    'xtt-pa-sedes',
                  ])
                  ->conditionalLogic([
                    ConditionalLogic::if('mode')->equals('popular')
                  ]),
                Number::make('Quantidade', 'items_count')
                    ->min(1)
                    ->required()
                    ->defaultValue(4)
                    ->conditionalLogic([
                        ConditionalLogic::if('mode')->equals('popular')
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
            $items = array_column(get_field('items')['data'], 'id');
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
