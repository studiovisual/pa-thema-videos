<?php

namespace Blocks\PAListVideosColumn;

use Blocks\Block;
use Extended\LocalData;
use Fields\MoreContent;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\ButtonGroup;
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

        add_filter('acf/fields/localposts_data/query/name=items_popular', array($this, 'filter'));
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
                        'latest'  => 'Mais recentes',
                        'popular' => 'Mais vistos',
                    ])
                    ->defaultValue('latest'),

                LocalData::make('Vídeos', 'items_latest')
                    ->instructions('Selecionar vídeos')
                    ->postTypes(['post'])
                    ->initialLimit(4)
                    ->manualItems(false)
                    ->filterTaxonomies([
                      'xtt-pa-colecoes',
                      'xtt-pa-editorias',
                      'xtt-pa-departamentos',
                      'xtt-pa-projetos',
                      'xtt-pa-sedes',
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::if('mode')->equals('latest')
                    ]),

                LocalData::make('Vídeos', 'items_popular')
                  ->instructions('Selecionar vídeos')
                  ->postTypes(['post'])
                  ->initialLimit(4)
                  ->manualItems(false)
                  ->filterTaxonomies([
                    'xtt-pa-colecoes',
                    'xtt-pa-editorias',
                    'xtt-pa-departamentos',
                    'xtt-pa-projetos',
                    'xtt-pa-sedes',
                  ])
                  ->conditionalLogic([
                      ConditionalLogic::if('mode')->equals('popular')
                  ]),
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
        $mode = get_field('mode');

        return [
            'title'        => get_field('title'),
            'items'        => array_column(get_field("items_{$mode}")['data'], 'id'),
            'enable_link'  => get_field('enable_link'),
            'link'         => get_field('link'),
        ];
    }
    
    function filter(array $args): array {
      $args['meta_key'] = 'views_count';
      $args['orderby']  = 'meta_value_num';
      $args['order']    = 'DESC';

      return $args;
    }

}
