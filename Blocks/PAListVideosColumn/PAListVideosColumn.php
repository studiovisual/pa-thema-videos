<?php

namespace Blocks\PAListVideosColumn;

use Blocks\Block;
use Blocks\Fields\MoreContent;
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
            'title'       => 'IASD - Vídeos Recomendados',
            'description' => 'Lista de vídeos sem thumb de destaque e em apenas uma coluna',
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
                    ->defaultValue('Vídeos Recomendados')
                    ->required(),

                Relationship::make('Vídeos Recomendados', 'items')
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
        return [
            'title'        => field('title'),
            'items'        => field('items'),
            'enable_link'  => field('enable_link'),
            'link'         => field('link')['url'],
        ];
    }
}
