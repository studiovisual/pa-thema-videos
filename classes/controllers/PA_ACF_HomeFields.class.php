<?php

use WordPlate\Acf\Fields\PostObject;
use WordPlate\Acf\Location;

class PaAcfHomeFields
{

    public function __construct()
    {
        add_action('init', [$this, 'createACFFields']);
    }

    function createACFFields()
    {
        register_extended_field_group([
            'title' => 'Opções da Página',
            'style' => 'default',
            'fields' => [
                PostObject::make('Post Destaque', 'post_destaque')
                    ->postTypes(['post'])
                    ->returnFormat('id'),
            ],
            'location' => [
                Location::if('page_template', 'page-front-page.php'),
            ]
        ]);
    }
}

$PaAcfHomeFields = new PaAcfHomeFields();
