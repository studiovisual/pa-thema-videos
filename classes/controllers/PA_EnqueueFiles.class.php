<?php 

class PA_Enqueue_Files {
	public function __construct(){
		add_action('wp_enqueue_scripts', [$this, 'RegisterChildAssets']);
		add_action('enqueue_block_editor_assets', [$this, 'enqueueAssets']);
	}

	public function RegisterChildAssets() {
		wp_enqueue_style( 'pa-child-style', get_stylesheet_uri());
	}

	function enqueueAssets() {
		wp_enqueue_script(
			'adventistas-admin2', 
			get_stylesheet_directory_uri() . '/assets/scripts/admin.js', 
			array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
		);
	}
}
new PA_Enqueue_Files();