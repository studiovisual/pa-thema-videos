wp.domReady( function () {
    let blocks = [
        'acf/p-a-magazines', 
        'acf/p-a-list-news',
        'acf/p-a-carousel-downloads',
        'acf/p-a-list-downloads',
        'acf/p-a-carousel-ministry',
        'acf/p-a-list-buttons',
        'acf/p-a-list-items',
        'acf/p-a-list-icons',
        'acf/p-a-carousel-feature',
        'acf/p-a-list-videos'
    ];

    blocks.forEach( unregisterBlocks );

    function unregisterBlocks( block ) {
        wp.blocks.unregisterBlockType( block ); 
    }
});
