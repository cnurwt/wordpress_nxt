<?php

namespace ElementPack\Modules\BackgroundOverlay;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Plugin;
use ElementPack\Base\Element_Pack_Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Module extends Element_Pack_Module_Base {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'bdt-background-overlay';
	}

	public function register_controls( $widget, $args ) {

		$widget->start_controls_section(
			'ep_section_background_overlay',
			[ 
				'label'     => BDTEP_CP . esc_html__( 'Background Over/Underlay', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_ADVANCED,
			]
		);

		$widget->add_control(
            'element_pack_background_overlay',
            [
                'label'         => BDTEP_CP . esc_html__('Enable', 'bdthemes-element-pack'),
                'type'          => Controls_Manager::SWITCHER,
				'prefix_class'  => 'bdt-background-overlay-',
            ]
        );

		$widget->start_controls_tabs(
			'ep_tabs_background_overlay',
			[
				'condition' => [
					'element_pack_background_overlay' => 'yes',
				]
			]
		);

		$widget->start_controls_tab(
			'ep_tab_background_overlay_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$widget->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'ep_background_overlay',
				'selector' => '{{WRAPPER}}.bdt-background-overlay-yes:before',
			]
		);

		$widget->add_control(
			'ep_background_overlay_opacity',
			[ 
				'label'     => esc_html__( 'Opacity', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => .5,
				],
				'range'     => [ 
					'px' => [ 
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}}.bdt-background-overlay-yes:before' => 'opacity: {{SIZE}};',
				],
				'condition' => [ 
					'ep_background_overlay_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[ 
				'name'     => 'ep_css_filters',
				'selector' => '{{WRAPPER}}.bdt-background-overlay-yes:before',
			]
		);

		$widget->add_control(
			'ep_overlay_blend_mode',
			[ 
				'label'     => esc_html__( 'Blend Mode', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [ 
					''            => esc_html__( 'Normal', 'bdthemes-element-pack' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'luminosity'  => 'Luminosity',
				],
				'selectors' => [ 
					'{{WRAPPER}}.bdt-background-overlay-yes:before' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$widget->add_responsive_control(
			'ep_background_overlay_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'before',
				'selectors'  => [ 
					'{{WRAPPER}}.bdt-background-overlay-yes:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			'ep_background_overlay_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'before',
				'selectors'  => [ 
					'{{WRAPPER}}' => '--ep-overlay-margin-top: {{TOP}}{{UNIT}};  --ep-overlay-margin-right: {{RIGHT}}{{UNIT}}; --ep-overlay-margin-bottom: {{BOTTOM}}{{UNIT}}; --ep-overlay-margin-left: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_control(
			'ep_background_overlay_zindex',
			[ 
				'label'     => esc_html__( 'Z-Index', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::NUMBER,
				'dynamic'   => [ 
					'active' => true,
				],
				'selectors' => [ 
					'{{WRAPPER}}.bdt-background-overlay-yes:before' => 'z-index: {{VALUE}};',
				]
			]
		);

		$widget->end_controls_tab();
		$widget->start_controls_tab(
			'ep_tab_background_overlay_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$widget->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'ep_background_overlay_hover',
				'selector' => '{{WRAPPER}}.bdt-background-overlay-yes:hover:before',
			]
		);

		$widget->add_control(
			'ep_background_overlay_hover_opacity',
			[ 
				'label'     => esc_html__( 'Opacity', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => .5,
				],
				'range'     => [ 
					'px' => [ 
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}}.bdt-background-overlay-yes:hover:before' => 'opacity: {{SIZE}};',
				],
				'condition' => [ 
					'ep_background_overlay_hover_background' => [ 'classic', 'gradient' ],
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[ 
				'name'     => 'ep_css_filters_hover',
				'selector' => '{{WRAPPER}}.bdt-background-overlay-yes:hover:before',
			]
		);

		$widget->add_control(
			'ep_background_overlay_hover_transition_duration',
			[ 
				'label'     => esc_html__( 'Transition Duration', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => 0.3,
				],
				'range'     => [ 
					'px' => [ 
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'separator' => 'before',
				'selectors' => [ 
					'{{WRAPPER}}.bdt-background-overlay-yes:before' => 'transition: background {{SIZE}}s;',
				]
			]
		);

		$widget->add_responsive_control(
			'ep_background_overlay_hover_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'before',
				'selectors'  => [ 
					'{{WRAPPER}}.bdt-background-overlay-yes:hover:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_tab();
		$widget->end_controls_tabs();
		$widget->end_controls_section();
	}

	public function background_overlay_render( $widget ) {
		$settings = $widget->get_settings_for_display();

		if ( in_array( $widget->get_name(), [ 'column', 'section' ] ) ) {
			return;
		}

		if ( Plugin::instance()->editor->is_edit_mode() ) {
			return;
		}
	}

	protected function add_actions() {
		add_action( 'elementor/element/common/_section_background/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/after_add_attributes', [ $this, 'background_overlay_render' ], 10, 1 );
	}
}
