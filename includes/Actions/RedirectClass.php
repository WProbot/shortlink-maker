<?php

namespace Actions;

class RedirectClass {

  function __construct() {
    add_action('template_redirect', [$this, 'my_page_template_redirect']);
  }

  function my_page_template_redirect() {

    global $wp;
    $current_url_withslash = trailingslashit(home_url($wp->request));
    $current_url_withoutSlash = home_url($wp->request);
    $args = [
      'meta_query' => [
        'relation' => 'OR',
        [
          'key' => 'main_link',
          'value' => $current_url_withslash,
        ],
        [
          'key' => 'redirect_link',
          'value' => $current_url_withoutSlash,
        ],
      ],
      'post_type' => 'links',
      'posts_per_page' => -1,
    ];
    $posts = get_posts($args);
    if (isset($posts)) {
      if (sizeof($posts) > 0) {

        $post_id = $posts[0]->ID;
        $post_redirect_url = get_post_meta($post_id, "main_link", TRUE);
        $old_used_number = get_post_meta($post_id, "used_short_link", TRUE);
        if (!isset($old_used_number)) {
          $old_used_number = 0;
        }
        $new_used_number = $old_used_number + 1;
        update_post_meta($post_id, "used_short_link", $new_used_number);
        wp_redirect($post_redirect_url);
      }
    }
  }

}