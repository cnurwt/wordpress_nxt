<?php
namespace MTLCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Elementor_Services_Widget extends Widget_Base {

	public function get_name() {
		return 'mtl-services';
	}

	public function get_title() {
		return __( 'MTL Services', 'mtl-core' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	private function mtl_get_all_services_categories( $post_type ) {

		$options = array();

		$taxonomy = 'services_categories';

		if ( ! empty( $taxonomy ) ) {
			// Get categories for services type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}

		return $options;
	}

	protected function register_controls() {

		$this->mtl_content_layout_options();
		$this->mtl_content_query_options();

	  	$this->mtl_style_layout_options();
		$this->mtl_style_box_options();
		$this->mtl_style_image_options();

		$this->mtl_style_title_options();
		$this->mtl_style_meta_options();
		$this->mtl_style_content_options();
		$this->mtl_style_readmore_options();

	}

	/**
	 * Content Layout Options.
	 */
	private function mtl_content_layout_options() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'mtl-core' ),
			]
		);

		$this->add_control(
			'grid_style',
			[
				'label' => __( 'Style', 'mtl-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Layout 1', 'mtl-core' ),
					'2' => esc_html__( 'Layout 2', 'mtl-core' ),
					'3' => esc_html__( 'Layout 3', 'mtl-core' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Grid Columns', 'mtl-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
				'selectors' => [
					'.elementor-msie {{WRAPPER}} .elementor-services-item' => 'width: calc( 100% / {{SIZE}} )',
				],
			]
		);

		$this->add_control(
			'post_per_page',
			[
				'label' => __( 'Servicess Per Page', 'mtl-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Image', 'mtl-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'mtl-core' ),
				'label_off' => __( 'Hide', 'mtl-core' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'full',
				'prefix_class' => 'post-thumbnail-size-',
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Title', 'mtl-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'mtl-core' ),
				'label_off' => __( 'Hide', 'mtl-core' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'mtl-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_data',
			[
				'label' => __( 'Meta Data', 'mtl-core' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => [ 'date', 'comments' ],
				'multiple' => true,
				'options' => [
					'author' => __( 'Author', 'mtl-core' ),
					'date' => __( 'Date', 'mtl-core' ),
					'categories' => __( 'Categories', 'mtl-core' ),
					'comments' => __( 'Comments', 'mtl-core' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'meta_separator',
			[
				'label' => __( 'Separator Between', 'mtl-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '/',
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-meta span + span:before' => 'content: "{{VALUE}}"',
				],
				'condition' => [
					'meta_data!' => [],
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Excerpt', 'mtl-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'mtl-core' ),
				'label_off' => __( 'Hide', 'mtl-core' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'mtl-core' ),
				'type' => Controls_Manager::NUMBER,
				/** This filter is documented in wp-includes/formatting.php */
				'default' => apply_filters( 'excerpt_length', 25 ),
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_append',
			[
				'label' => __( 'Excerpt Append', 'mtl-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '&hellip;',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label' => __( 'Read More', 'mtl-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'mtl-core' ),
				'label_off' => __( 'Hide', 'mtl-core' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More Text', 'mtl-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More »', 'mtl-core' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_align',
			[
				'label' => __( 'Alignment', 'mtl-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'mtl-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'mtl-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'mtl-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .services-grid-inner' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}


	/**
	 * Content Query Options.
	 */
	private function mtl_content_query_options() {

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'mtl-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// Services categories
		$this->add_control(
			'services_categories',
			[
				'label'       => __( 'Categories', 'mtl-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->mtl_get_all_services_categories( 'services' ),

			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'mtl-core' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'mtl-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'services_date',
				'options' => [
					'services_date' => __( 'Date', 'mtl-core' ),
					'services_title' => __( 'Title', 'mtl-core' ),
					'rand' => __( 'Random', 'mtl-core' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'mtl-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'mtl-core' ),
					'desc' => __( 'DESC', 'mtl-core' ),
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Layout Options.
	 */
	private function mtl_style_layout_options() {

		// Layout.
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Layout', 'mtl-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Columns margin.
		$this->add_responsive_control(
			'grid_style_columns_margin',
			[
				'label'     => __( 'Columns margin', 'mtl-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',

				],
			]
		);

		// Row margin.
		$this->add_responsive_control(
			'grid_style_rows_margin',
			[
				'label'     => __( 'Rows margin', 'mtl-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Box Options.
	 */
	private function mtl_style_box_options() {

		// Box.
		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'Box', 'mtl-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_box_border_width',
			[
				'label'      => __( 'Border Widget', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Border Radius.
		$this->add_control(
			'grid_style_border_radius',
			[
				'label'     => __( 'Border Radius', 'mtl-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Box internal padding.
		$this->add_responsive_control(
			'grid_items_style_padding',
			[
				'label'      => __( 'Padding', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label'     => __( 'Normal', 'mtl-core' ),
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_button_style_normal_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'mtl-core' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Normal border color.
		$this->add_control(
			'grid_button_style_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'mtl-core' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .mtl_services_wrapper .mtl-services',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label'     => __( 'Hover', 'mtl-core' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_button_style_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'mtl-core' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'grid_button_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'mtl-core' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .mtl_services_wrapper .mtl-services:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Style Image Options.
	 */
	private function mtl_style_image_options() {

		// Box.
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'mtl-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .services-grid-inner .services-grid-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_style_image_margin',
			[
				'label'      => __( 'Margin', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
             	'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 15,
					'left' => 0,
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .services-grid-inner .services-grid-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style > Title.
	 */
	private function mtl_style_title_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label'     => __( 'Title', 'mtl-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .mtl_services_wrapper .mtl-services .title, {{WRAPPER}} .mtl_services_wrapper .mtl-services .title > a',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_title_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'mtl-core' ),
			)
		);

		// Title color.
		$this->add_control(
			'grid_title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'mtl-core' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .title, {{WRAPPER}} .mtl_services_wrapper .mtl-services .title > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_title_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'mtl-core' ),
			)
		);

		// Title hover color.
		$this->add_control(
			'grid_title_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'mtl-core' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .title, {{WRAPPER}} .mtl_services_wrapper .mtl-services .title > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Title margin.
		$this->add_responsive_control(
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
              	'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 10,
					'left' => 0,
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .title, {{WRAPPER}} .mtl_services_wrapper .mtl-services .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Meta.
	 */
	private function mtl_style_meta_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_meta_style',
			[
				'label'     => __( 'Meta', 'mtl-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Meta typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_meta_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-meta span',
			]
		);

		// Meta color.
		$this->add_control(
			'grid_meta_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'mtl-core' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-meta span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-meta span a' => 'color: {{VALUE}};',
				],
			]
		);

		// Meta margin.
		$this->add_responsive_control(
			'grid_meta_style_margin',
			[
				'label'      => __( 'Margin', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
              	'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 10,
					'left' => 0,
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Content.
	 */
	private function mtl_style_content_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_content_style',
			[
				'label' => __( 'Content', 'mtl-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Content typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_content_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-excerpt p',
			]
		);

		// Content color.
		$this->add_control(
			'grid_content_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'mtl-core' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-excerpt p' => 'color: {{VALUE}};',
				],
			]
		);

		// Content margin
		$this->add_responsive_control(
			'grid_content_style_margin',
			[
				'label'      => __( 'Margin', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services .services-grid-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Readmore.
	 */
	private function mtl_style_readmore_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_readmore_style',
			[
				'label' => __( 'Read More', 'mtl-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		// Readmore typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_readmore_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn',
			]
		);

		$this->start_controls_tabs( 'grid_readmore_color_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_readmore_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'mtl-core' ),
			)
		);

		// Readmore color.
		$this->add_control(
			'grid_readmore_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'mtl-core' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn' => 'color: {{VALUE}};',
				],
			]
		);

		// Readmore background color.
		$this->add_control(
			'grid_readmore_style_background_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'mtl-core' ),
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Readmore border color.
		$this->add_control(
			'grid_readmore_style_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'mtl-core' ),
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_readmore_style_color_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'mtl-core' ),
			)
		);

		// Readmore hover color.
		$this->add_control(
			'grid_readmore_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'mtl-core' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn:hover' => 'color: {{VALUE}};',
				),
			)
		);

		// Readmore hover background color.
		$this->add_control(
			'grid_readmore_style_hover_background_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'mtl-core' ),
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Readmore hover border color.
		$this->add_control(
			'grid_readmore_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'mtl-core' ),
				'selectors' => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Readmore border width.
		$this->add_control(
			'grid_readmore_style_border_width',
			[
				'type'       => Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Width', 'mtl-core' ),
				'separator'  => 'before',
				'size_units' => array( 'px' ),
				'selectors'  => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Readmore border radius.
		$this->add_control(
			'grid_readmore_style_border_radius',
			array(
				'label'     => esc_html__( 'Border Radius', 'mtl-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		// Readmore button padding.
		$this->add_responsive_control(
			'grid_readmore_style_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		// Readmore margin.
		$this->add_responsive_control(
			'grid_readmore_style_margin',
			[
				'label'      => __( 'Margin', 'mtl-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .mtl_services_wrapper .mtl-services a.read-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {

		// Get settings.
		$settings = $this->get_settings();

		?>
		<div class="mtl_services_wrapper">
			<?php

			$columns_desktop = ( ! empty( $settings['columns'] ) ? 'mtl-grid-desktop-' . $settings['columns'] : 'mtl-grid-desktop-3' );

			$columns_tablet = ( ! empty( $settings['columns_tablet'] ) ? ' mtl-grid-tablet-' . $settings['columns_tablet'] : ' mtl-grid-tablet-2' );

			$columns_mobile = ( ! empty( $settings['columns_mobile'] ) ? ' mtl-grid-mobile-' . $settings['columns_mobile'] : ' mtl-grid-mobile-1' );

			$grid_style = $settings['grid_style'];

			$grid_class = '';

			if( 5 == $grid_style ){

				$grid_class = ' grid-meta-bottom';

			}
      
			?>
			<div class="mtl-grid-container elementor-grid <?php echo $columns_desktop.$columns_tablet.$columns_mobile.$grid_class; ?>">
			
				<?php

				$post_per_page = ( ! empty( $settings['post_per_page'] ) ?  $settings['post_per_page'] : 3 );

                $cats = is_array( $settings['services_categories'] ) ? implode( ',', $settings['services_categories'] ) : $settings['services_categories'];
                if($cats != null ){
                  $query_args = array(
                    'post_type'         	=> 'services',
                    'posts_per_page' 		=> absint( $post_per_page ),
                    'no_found_rows'  		=> true,
                    'post_status'         	=> 'publish',
                    'ignore_sticky_posts'   => true,
                    'tax_query' => array(
                      array(
                        'taxonomy' => 'services_categories',
                        'field' => 'slug',
                        'terms' => $cats
                      )
                    )
                  );
                } else {
                  $query_args = array(
                    'post_type'         	=> 'services',
                    'posts_per_page' 		=> absint( $post_per_page ),
                    'no_found_rows'  		=> true,
                    'post_status'         	=> 'publish',
                    'ignore_sticky_posts'   => true,
                    'category_name' 		=> $cats,

                  );
                }

		        // Order by.
		        if ( ! empty( $settings['orderby'] ) ) {
		        	$query_args['orderby'] = $settings['orderby'];
		        }

		        // Order .
		        if ( ! empty( $settings['order'] ) ) {
		        	$query_args['order'] = $settings['order'];
		        }

		        $all_servicess = new \WP_Query( $query_args );

		        if ( $all_servicess->have_posts() ) :

					if( 3 == $grid_style ){

		        		include( __DIR__ . '/layouts/layout-3.php' );

		        	}elseif( 2 == $grid_style ){

		        		include( __DIR__ . '/layouts/layout-2.php' );

		        	}else{

		        		include( __DIR__ . '/layouts/layout-1.php' );

		        	}

		        endif; ?>

			</div>
		</div>
		<?php

	}

	public function mtl_filter_excerpt_length( $length ) {

		$settings = $this->get_settings();

		$excerpt_length = (!empty( $settings['excerpt_length'] ) ) ? absint( $settings['excerpt_length'] ) : 25;

		return absint( $excerpt_length );
	}

	public function mtl_filter_excerpt_more( $more ) {
		$settings = $this->get_settings();

		return $settings['excerpt_append'];
	}

	protected function render_thumbnail() {

		$settings = $this->get_settings();

		$show_image = $settings['show_image'];

		if ( 'yes' !== $show_image ) {
			return;
		}

		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( has_post_thumbnail() ) :  ?>
			<div class="services-grid-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( $post_thumbnail_size ); ?>
				</a>
			</div>
        <?php endif;
	}

	protected function render_title() {

		$settings = $this->get_settings();

		$show_title = $settings['show_title'];

		if ( 'yes' !== $show_title ) {
			return;
		}

		$title_tag = $settings['title_tag'];

		if ($title_tag == 'h1' || $title_tag == 'h2' || $title_tag == 'h3' || $title_tag == 'h4' || $title_tag == 'h5' || $title_tag == 'h6' || $title_tag == 'div' ||  $title_tag == 'span' ||  $title_tag == 'p') {
            $final_title_tag = $title_tag;
        } else {
            $final_title_tag = 'h1';
        }

		?>
		<<?php echo $final_title_tag; ?> class="title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</<?php echo $final_title_tag; ?>>
		<?php
	}

	protected function render_meta() {

		$settings = $this->get_settings();

		$meta_data = $settings['meta_data'];

		if ( empty( $meta_data ) ) {
			return;
		}

		?>
		<div class="services-grid-meta">
			<?php
			if ( in_array( 'author', $meta_data ) ) { ?>

				<span class="services-author"><?php the_author(); ?></span>

				<?php
			}

			if ( in_array( 'date', $meta_data ) ) { ?>

				<span class="services-date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( get_option( 'date_format' ) ) ); ?></time></span>

				<?php
			}

			if ( in_array( 'categories', $meta_data ) ) {

				$categories_list = get_the_category_list( esc_html__( ', ', 'mtl-core' ) );

				if ( $categories_list ) {
				    printf( '<span class="services-categories">%s</span>', $categories_list ); // WPCS: XSS OK.
				}

			}

			if ( in_array( 'comments', $meta_data ) ) { ?>

				<span class="services-comments"><?php comments_number(); ?></span>

				<?php
			}
			?>
		</div>
		<?php

	}

	protected function render_excerpt() {

		$settings = $this->get_settings();

		$show_excerpt = $settings['show_excerpt'];

		if ( 'yes' !== $show_excerpt ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'mtl_filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'mtl_filter_excerpt_length' ], 9999 );

		?>
		<div class="services-grid-excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'mtl_filter_excerpt_length' ], 9999 );
		remove_filter( 'excerpt_more', [ $this, 'mtl_filter_excerpt_more' ], 20 );
	}

	protected function render_readmore() {

		$settings = $this->get_settings();

		$show_read_more = $settings['show_read_more'];
		$read_more_text = $settings['read_more_text'];

		if ( 'yes' !== $show_read_more ) {
			return;
		}

		?>
		<a class="read-more-btn" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_more_text ); ?></a>
		<?php

	}

}
