<?php

/**
 * Widget-Text class.
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

namespace ElementorAddon\Includes\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * Text widget class.
 *
 * @since 1.0.0
 */
class TextWidget extends Widget_Base
{
    /**
     * Class constructor.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);
        wp_enqueue_style('text-widget', plugins_url('/assets/css/text-widget-style.css', ELEMENTORADDONS), array(), '1.0.0');
        wp_enqueue_script('text-widget', plugins_url('/assets/js/text-widget-style.js', ELEMENTORADDONS), array('jquery'), '1.0.0', true);
    }

    /**
     * Widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'text-addons';
    }

    /**
     * Widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Text Addon', 'elementor-addons');
    }

    /**
     * Widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-editor-h1';
    }

    /**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return array('basic');
	}

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __('Content', 'elementor-addons'),
            )
        );

        $this->add_control(
            'title',
            array(
                'label'   => __('Title', 'elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Washington, DC', 'elementor-addons'),
            )
        );

        $this->add_control(
            'description',
            array(
                'label'   => __('Description', 'elementor-addons'),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('Washington, DC, the U.S. capital, is a compact city on the Potomac River, bordering the states of Maryland and Virginia.', 'elementor-addons'),
            )
        );

        $this->add_control(
            'content',
            array(
                'label'   => __('Content', 'elementor-addons'),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => __('United States', 'elementor-addons'),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('title', 'none');
        $this->add_inline_editing_attributes('description', 'basic');
        $this->add_inline_editing_attributes('content', 'advanced');
    ?>
        <div class="text-widget-addon-wrap">
            <h2 class="text" <?php echo $this->get_render_attribute_string('title'); ?>><?php echo $settings['title']; ?></h2>
            <div <?php echo $this->get_render_attribute_string('description'); ?>><?php echo $settings['description']; ?></div>
            <p <?php echo $this->get_render_attribute_string('content'); ?>><?php echo $settings['content']; ?></p>
            <div>Current time <span class='current-time'></span></div>
        </div>
    <?php
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function content_template()
    {
    ?>
        <# view.addInlineEditingAttributes( 'title' , 'none' ); 
        view.addInlineEditingAttributes( 'description' , 'basic' ); 
        view.addInlineEditingAttributes( 'content' , 'advanced' ); #>
        <div class="text-widget-addon-wrap">
            <h2 class="text" {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
            <div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
            <p {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</p>
            <div>Current time <span class='current-time'></span></div>
        </div>
    <?php
    }
}
