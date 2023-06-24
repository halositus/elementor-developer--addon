<?php

/**
 * Compatibility_Check class.
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

if (!defined('ABSPATH')) {
    // Exit if accessed directly.
    exit;
}

/**
 * Main Compatibility Check Class
 *
 * The class is intended to make sure that the plugin's minimum requirements are met.
 */
final class CompatibilityCheck
{

    /**
     * Plugin Version
     *
     * @since 1.0.0
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the add-ons plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.13.4';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.4';

    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
        // Load the translation.
        add_action('init', array($this, 'i18n'));

        // Initialize the plugin.
        add_action('plugins_loaded', array($this, 'init'));
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function i18n()
    {
        load_plugin_textdomain('elementor-addons');
    }

    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the other plugin class.
     *
     * Fired by `plugins_loaded` action hook see https://developer.wordpress.org/reference/hooks/plugins_loaded/.
     *
     * @since 1.0.0
     * @access public
     */
    public function init()
    {

        // Check if Elementor installed and activated.
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
            return;
        }

        // Check for required Elementor version.
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
            return;
        }

        // Check for required PHP version.
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
            return;
        }

        // Once requirement met, Include other plugin classes.
        require_once 'widget-manager.php';
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {
        deactivate_plugins(plugin_basename(HALOSITUSELEMENTOR));

        return sprintf(
            wp_kses(
                '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> to be installed and activated.</p></div>',
                array(
                    'div' => array(
                        'class'  => array(),
                        'p'      => array(),
                        'strong' => array(),
                    ),
                )
            ),
            'Elementor Addons',
            'Elementor'
        );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {
        deactivate_plugins(plugin_basename(HALOSITUSELEMENTOR));

        return sprintf(
            wp_kses(
                '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
                array(
                    'div' => array(
                        'class'  => array(),
                        'p'      => array(),
                        'strong' => array(),
                    ),
                )
            ),
            'Elementor Addons',
            'Elementor',
            self::MINIMUM_ELEMENTOR_VERSION
        );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {
        deactivate_plugins(plugin_basename(ELEMENTOR_AWESOMESAUCE));

        return sprintf(
            wp_kses(
                '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
                array(
                    'div' => array(
                        'class'  => array(),
                        'p'      => array(),
                        'strong' => array(),
                    ),
                )
            ),
            'Elementor Addons',
            'PHP',
            self::MINIMUM_PHP_VERSION
        );
    }
}

// Instantiate Elementor_Awesomesauce.
new CompatibilityCheck();
