<?php
// load parent and child stylesheets
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
require_once('functions-staff.php');
require_once('functions-templates.php');
require_once 'functions-settings.php';
require_once 'functions-duplicate.php';
require_once 'functions-publish-post-hook.php';
require_once 'functions-editor.php';
require_once 'functions-shortcodes.php';
require_once 'functions-metabox.php';

