<?php

/*
Plugin Name: Custom Read More Block
Description: A custom Gutenberg block for inserting stylized anchor links for post.
Version: 1.0.0
Author: Aarti Khunti
*/

function load_custom_read_more_block() {
    wp_enqueue_script( 'custom-read-more-block-script', plugins_url('block.js', __FILE__), array(
        'wp-blocks', 'wp-editor', 'wp-components', 'wp-api-fetch'
    ), null, true, 'module');

    wp_enqueue_style('block-styles',plugins_url('style.css', __FILE__),array(),'1.0','all');
}

add_action('init', 'load_custom_read_more_block');

function register_custom_read_more_block() {
    register_block_type('custom-read-more-block/read-more-block', array(
        'editor_script' => 'custom-read-more-block-script',
    ));
}

add_action('init', 'register_custom_read_more_block');

if (defined('WP_CLI') && WP_CLI) {
    require_once plugin_dir_path(__FILE__) . 'dmg-read-more-cli.php';
}

