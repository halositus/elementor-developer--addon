<?php

/**
 * Widget_Manager class.
 *
 * @category   Class
 * @package    ElementorAddons
 * @subpackage WordPress
 * @author     HaloSitus <fairuz@halositus.tech>
 * @copyright  2023 Halositus
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0-only
 * @link       link(https://halositus.tech,
 *             HaloSitus Elementor Add-ons)
 * @since      1.0.0
 * php version 7.4
 */

namespace ElementorAddon;

// Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * Main Widget Manager Class
 *
 * The class is intended to register elementor widget.
 */
class WidgetManager
{

    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
	 * Register Widgets
	 *
	 * Load widgets files and register new Elementor widgets.
	 *
	 * Fired by `elementor/widgets/register` action hook.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {

		require_once( __DIR__ . '/includes/widgets/widget-text.php' );
		$widgets_manager->register( new Includes\Widgets\TextWidget() );

	}

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
        // Register the widgets.
        add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets'));
    }
}

// Instantiate the Widgets class.
WidgetManager::instance();
