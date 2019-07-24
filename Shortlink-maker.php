<?php
/**
 * Plugin Name: Shortlink Maker
 * Description: A Sample WordPress Plugin
 * Plugin URI:  https://hamyarwoo.com
 * Version:     1.0.0
 * Author:      Iman Heydari
 * Author URI:  https://iranimij.com
 * License:     MIT
 * Text Domain: short-link-maker
 * Domain Path: /languages
 */

add_action('plugins_loaded', [
  Shortlink_WordPress_Plugin::get_instance(),
  'plugin_setup',
]);

class Shortlink_WordPress_Plugin {

  /**
   * Plugin instance.
   *
   * @see get_instance()
   * @type object
   */
  protected static $instance = NULL;

  /**
   * URL to this plugin's directory.
   *
   * @type string
   */
  public $plugin_url = '';

  /**
   * Path to this plugin's directory.
   *
   * @type string
   */
  public $plugin_path = '';

  /**
   * Access this plugin’s working instance
   *
   * @wp-hook plugins_loaded
   * @since   2012.09.13
   * @return  object of this class
   */
  public static function get_instance() {
    NULL === self::$instance and self::$instance = new self;
    return self::$instance;
  }

  /**
   * Used for regular plugin work.
   *
   * @wp-hook plugins_loaded
   * @return  void
   */
  public function plugin_setup() {
    $this->plugin_url = plugins_url('/', __FILE__);
    $this->plugin_path = plugin_dir_path(__FILE__);
    $this->load_language('shortlink-maker-wordpress-plugin');

    spl_autoload_register([$this, 'autoload']);
    new \Setup\PostType();
    new \Setup\MetaBox();
    new \Actions\RedirectClass();
    new \Setup\ShortCode();

  }

  /**
   * Constructor. Intentionally left empty and public.
   *
   * @see plugin_setup()
   */
  public function __construct() {
  }

  /**
   * Loads translation file.
   *
   * Accessible to other classes to load different language files (admin and
   * front-end for example).
   *
   * @wp-hook init
   *
   * @param   string $domain
   *
   * @return  void
   */
  public function load_language($domain) {
    load_plugin_textdomain($domain, FALSE, $this->plugin_path . '/languages');
  }

  /**
   * @param $class
   *
   */
  public function autoload($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    if (!class_exists($class)) {
      $class_full_path = $this->plugin_path . 'includes/' . $class . '.php';

      if (file_exists($class_full_path)) {
        require $class_full_path;
      }
    }
  }
}