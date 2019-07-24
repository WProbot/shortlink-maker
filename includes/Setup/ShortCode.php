<?php
/**
 * Created by PhpStorm.
 * User: iman
 * Date: 24/07/2019
 * Time: 09:00 PM
 */

namespace Setup;


class ShortCode {
    function __construct() {
      add_shortcode("short_links",[$this,"showShortLinks"]);
    }

    function showShortLinks(){
      ob_start();
      $main_obj = \Shortlink_WordPress_Plugin::get_instance();
      require_once $main_obj->plugin_path.'/templates/shortcode/short_link_template.php';
      return ob_get_clean();
    }
}