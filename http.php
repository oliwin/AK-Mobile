<?php
/*

Plugin Name: Http Modifier
Description: Plugin replaces content depend on the HTTP headers of client
Version: 1.0.0
Author: Oleg Ponomarchuk

*/
/*  Copyright 2017  Oleg Ponomarchuk  (email : ponomarchukov@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
include(plugin_dir_path(__FILE__) . 'controllers/httprules.php');

$new_title       = null;
$new_description = null;
$TITLE_POST      = null;
$CONTENT_POST    = null;
$LINK = null;


function get_post_meta_u($post_id, $key = '', $single = false)
{
    return get_metadata('post', $post_id, $key, $single);
}

/* Ð¡Ð¾Ñ…Ñ€Ð°Ð½ÑÐµÐ¼ Ð´Ð°Ð½Ð½Ñ‹Ðµ, ÐºÐ¾Ð³Ð´Ð° Ð¿Ð¾ÑÑ‚ ÑÐ¾Ñ…Ñ€Ð°Ð½ÑÐµÑ‚ÑÑ */

function myplugin_save_postdata($post_id)
{

    // Ð¿Ñ€Ð¾Ð²ÐµÑ€ÑÐµÐ¼ nonce Ð½Ð°ÑˆÐµÐ¹ ÑÑ‚Ñ€Ð°Ð½Ð¸Ñ†Ñ‹, Ð¿Ð¾Ñ‚Ð¾Ð¼Ñƒ Ñ‡Ñ‚Ð¾ save_post Ð¼Ð¾Ð¶ÐµÑ‚ Ð±Ñ‹Ñ‚ÑŒ Ð²Ñ‹Ð·Ð²Ð°Ð½ Ñ Ð´Ñ€ÑƒÐ³Ð¾Ð³Ð¾ Ð¼ÐµÑÑ‚Ð°.

    if (!wp_verify_nonce($_POST['myplugin_noncename'], plugin_basename(__FILE__)))
        return $post_id;

    // Ð£Ð±ÐµÐ´Ð¸Ð¼ÑÑ Ñ‡Ñ‚Ð¾ Ð¿Ð¾Ð»Ðµ ÑƒÑÑ‚Ð°Ð½Ð¾Ð²Ð»ÐµÐ½Ð¾.

    if (!isset($_POST['myplugin_new_field']))
        return;

    // Ð’ÑÐµ ÐžÐš. Ð¢ÐµÐ¿ÐµÑ€ÑŒ, Ð½ÑƒÐ¶Ð½Ð¾ Ð½Ð°Ð¹Ñ‚Ð¸ Ð¸ ÑÐ¾Ñ…Ñ€Ð°Ð½Ð¸Ñ‚ÑŒ Ð´Ð°Ð½Ð½Ñ‹Ðµ
    // ÐžÑ‡Ð¸Ñ‰Ð°ÐµÐ¼ Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ðµ Ð¿Ð¾Ð»Ñ input.

    $my_data = sanitize_text_field($_POST['myplugin_new_field']);

    // ÐžÐ±Ð½Ð¾Ð²Ð»ÑÐµÐ¼ Ð´Ð°Ð½Ð½Ñ‹Ðµ Ð² Ð±Ð°Ð·Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ….

    update_post_meta($post_id, 'url_replacement', $my_data);
}

/* Ð”Ð¾Ð±Ð°Ð²Ð»ÑÐµÐ¼ Ð±Ð»Ð¾ÐºÐ¸ Ð² Ð¾ÑÐ½Ð¾Ð²Ð½ÑƒÑŽ ÐºÐ¾Ð»Ð¾Ð½ÐºÑƒ Ð½Ð° ÑÑ‚Ñ€Ð°Ð½Ð¸Ñ†Ð°Ñ… Ð¿Ð¾ÑÑ‚Ð¾Ð² Ð¸ Ð¿Ð¾ÑÑ‚. ÑÑ‚Ñ€Ð°Ð½Ð¸Ñ† */

function myplugin_add_custom_box()
{
    $screens = array(
        'post',
        'page'
    );
    foreach ($screens as $screen)
        add_meta_box('myplugin_sectionid', 'Http Cloaking', 'myplugin_meta_box_callback', $screen);
}

add_action('add_meta_boxes', 'myplugin_add_custom_box');

function myplugin_meta_box_callback()
{
    global $post;
    $meta = get_post_meta_u($post->ID, 'url_replacement', true);

    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    echo '<label for="myplugin_new_field">' . __("Post URL to replace", 'myplugin_textdomain') . '</label> ';
    echo '<input type="text" id= "myplugin_new_field" name="myplugin_new_field" value="' . $meta . '" size="25" />';
}

function my_admin_menu()
{
    add_menu_page(__('Http Cloaking', 'textdomain'), 'Http Cloaking', 'manage_options', 'http-modifier/rules.php', '', plugins_url('http-modifier/images/icon.png'), 100);
}

function post_callback($post)
{
    global $wpdb;
    global $post;
    global $new_title;
    global $TITLE_POST;
    global $LINK;
    $http_headers = new HttpRules($wpdb);
    $http_headers->start($post);

    // //

    if ($http_headers->allowReplacement($post)) {
        try {

            // Get post to replace

            $id           = url_to_postid($http_headers->url_replacement);
            $post_replace = get_post($id);
            // var_dump($post_replace); die();

            // Set title, description

            $post->post_title   = $post_replace->post_title;
            $post->post_name    = $post_replace->post_name;
            $post->post_content = $post_replace->post_content;
//."<input type='hidden' id='url' name='url' value='" . $http_headers->url_replacement . "'>";

            $new_title          = $post_replace->post_title;
            $new_description    = $post_replace->post_content;
            $TITLE_POST         = $post_replace->post_title;
            $CONTENT_POST =  $post_replace->post_content;



        }

        catch (Exception $e) {

            // var_dump($e); die();

        }
    }

}

function modify_content($content)
{
    global $post;
global $CONTENT_POST;
    return $post->post_content;
}


function cyb_author_archive_meta_desc()
{
    global $new_description;
    global $post;

    return _wp_render_title_tag();
    if (!is_null($new_description)) {
        echo '<title>adadadadad</title><meta name="description" content="' . $new_description . '">';
    } else {
        echo '<meta name="description" content="' . $post->post_content . '">';
    }
}


function themeslug_enqueue_style()
{
    wp_register_script('my_amazing_script', plugins_url('test.js', __FILE__), array(
        'jquery'
    ), true);
    wp_enqueue_script('my_amazing_script');
}

function db_install()
{
    global $wpdb;
    $table_name = "httprules";
    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        $sql = "CREATE TABLE " . $table_name . " (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  header VARCHAR(150) NOT NULL,
	  value VARCHAR(150) NOT NULL,
          comparison VARCHAR(50) NOT NULL,
          header_value VARCHAR(255) NOT NULL
	);";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }
}

// Create custom field

function add_custom_field_automatically($post_ID)
{
    global $wpdb;
    if (!wp_is_post_revision($post_ID)) {
        add_post_meta($post_ID, 'url_replacement', '', true);
    }
}

function custom_title($title_parts) {
$title_parts['title'] = "Page Title";
return $title_parts;
}

function wpse_filter_post_titles( $title ) {
global $post;
return $post->post_title;
}


function my_tpl_wp_title($title) {

global $CONTENT_POST;

    $title = (isset($_SESSION["title"])) ? $_SESSION["title"] : "ok";

    return $CONTENT_POST;
}


function init()
{


    // Init DB

    db_install();

    // Change description meta


    // Get current post and replace on another

    add_action('the_post', 'post_callback');

   add_filter('the_content', 'modify_content');

    add_filter( 'the_title', 'wpse_filter_post_titles' );


    // JS

    add_action('wp_enqueue_scripts', 'themeslug_enqueue_style');

    // Title page
    add_filter( 'wp_title', 'my_tpl_wp_title', 100 );

   add_action('wp_head', 'cyb_author_archive_meta_desc');


}

// Meta add

add_action('save_post', 'myplugin_save_postdata');

// Admin menu

add_action('admin_menu', 'my_admin_menu');

if (!is_admin()) {

    add_action('init', 'init');

}
