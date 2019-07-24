<?php
namespace Setup;
/**
 * Created by PhpStorm.
 * User: iman
 * Date: 24/07/2019
 * Time: 06:54 PM
 */
class PostType {

  function __construct() {
    add_action('init', [$this,'handlePostType']);
  }

  function handlePostType() {

    $labels1 = [
      'name' => _x('Links', 'post type general name', 'shortlink-maker-wordpress-plugin'),
      'singular_name' => _x('Links', 'post type singular name', 'shortlink-maker-wordpress-plugin'),
      'menu_name' => _x('Links', 'admin menu', 'shortlink-maker-wordpress-plugin'),
      'name_admin_bar' => _x('Links', 'add new on admin bar', 'shortlink-maker-wordpress-plugin'),
      'add_new' => _x('Add new', 'book', 'shortlink-maker-wordpress-plugin'),
      'add_new_item' => _x('Add new', 'shortlink-maker-wordpress-plugin'),
      'new_item' => _x('Add new', 'shortlink-maker-wordpress-plugin'),
    ];
    $args1 = [
      'labels' => $labels1,
      'description' => __('Links', 'shortlink-maker-wordpress-plugin'),
      'public' => TRUE,
      'publicly_queryable' => TRUE,
      'show_ui' => TRUE,
      'show_in_menu' => TRUE,
      'show_in_nav_menus' => TRUE,
      'show_in_admin_bar' => TRUE,
      'query_var' => TRUE,
      'capability_type' => 'post',
      'has_archive' => TRUE,
      'hierarchical' => FALSE,
      'menu_position' => NULL,
      'supports' => [
        'title',
        'author',
      ],
    ];

    register_post_type("links", $args1);
  }

}