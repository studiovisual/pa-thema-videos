<?php

use WordPlate\Acf\Fields\Number;
use WordPlate\Acf\Fields\Oembed;
use WordPlate\Acf\Location;

class PaAcfPostFields {

    public function __construct() {
        add_action('init', [$this, 'createACFFields']);
    }

    function createACFFields() {
        register_extended_field_group([
            'title' => __('Informações do vídeo', 'iasd'),
            'style' => 'default',
            'fields' => [
                Oembed::make(__('Vídeo', 'iasd'), 'video_url')
                    ->required(),
                Number::make(__('Duração', 'iasd'), 'video_length')
                    ->instructions(__('Será obtido ao salvar o post', 'iasd'))
                    ->readOnly(),
            ],
            'location' => [
                Location::if('post_type', 'post'),
            ]
        ]);
    }

}

$PaAcfPostFields = new PaAcfPostFields();
