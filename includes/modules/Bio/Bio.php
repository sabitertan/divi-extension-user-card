<?php

class DIVIUSERCARD_Bio extends ET_Builder_Module {
	function init() {
		$this->bios_query = new WP_User_Query( array( 'role__not_in' => 'Subscriber' ) );
		
		$this->name       = esc_html__( 'Bio', 'et_builder' );
		$this->plural     = esc_html__( 'Bios', 'et_builder' );
		$this->slug       = 'divicf_bio';
		$this->vb_support = 'on';

		$this->main_css_element = '%%order_class%%.divicf_bio';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'et_builder' ),
					'image'        => esc_html__( 'Image', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'icon'  => esc_html__( 'Icon', 'et_builder' ),
					'image' => esc_html__( 'Image', 'et_builder' ),
					'text'  => array(
						'title'    => esc_html__( 'Text', 'et_builder' ),
						'priority' => 49,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'et_builder' ),
						'priority' => 90,
					),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'                 => array(
				'name' => array(
					'label'    => esc_html__( 'Name', 'et_builder' ),
					'css'      => array(
						'main'      => "{$this->main_css_element} .bio-name",
						'important' => 'plugin_only',
					),
				),
				'job_title' => array(
					'label'    => esc_html__( 'Job Title', 'et_builder' ),
					'css'      => array(
						'main'      => "{$this->main_css_element} .bio-title",
						'important' => 'plugin_only',
					),
				),
				'direct_phone' => array(
					'label'    => esc_html__( 'Phone', 'et_builder' ),
					'css'      => array(
						'main'      => "{$this->main_css_element} .bio-phone a.phone",
						'important' => 'plugin_only',
					),
				),
				'body'   => array(
					'label'    => esc_html__( 'Description', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .bio-description",
					),
				),
			),
			'background'            => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'borders'               => array(
				'default' => array(),
				'image' => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element} .bio-photo-wrapper img",
							'border_styles' => "{$this->main_css_element} .bio-photo-wrapper img",
						),
					),
					'label_prefix' => esc_html__( 'Image', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'image',
				),
			),
			'box_shadow'            => array(
				'default' => array(),
				'image'   => array(
					'label'           => esc_html__( 'Image Box Shadow', 'et_builder' ),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'image',
					'css'          => array(
						'main'         => '%%order_class%% .bio-photo-wrapper img',
						'custom_style' => true,
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
			'max_width'             => array(
				'css' => array(
					'module_alignment' => '%%order_class%%.divicf_bio.et_pb_module',
				),
			),
			'text'                  => array(
				'use_background_layout' => true,
				'options' => array(
					'background_layout' => array(
						'default' => 'light',
						'hover'   => 'tabs',
					),
				),
				'css' => array(
					'main' => implode(', ', array(
						'%%order_class%% .et_pb_module_header',
						'%%order_class%% .et_pb_member_position',
						'%%order_class%% .divicf_bio_description p',
					))
				)
			),
			'filters'               => array(
				'css' => array(
					'main' => '%%order_class%%',
				),
				'child_filters_target' => array(
					'tab_slug' => 'advanced',
					'toggle_slug' => 'image',
				),
			),
			'image'                 => array(
				'css' => array(
					'main' => '%%order_class%% .bio-photo-wrapper img',
				),
			),
			'button'                => false,
		);

		$this->custom_css_fields = array(
			'member_image' => array(
				'label'    => esc_html__( 'Bio Image', 'et_builder' ),
				'selector' => '.bio-photo-wrapper img',
			),
			'member_description' => array(
				'label'    => esc_html__( 'Bio Description', 'et_builder' ),
				'selector' => '.bio-description',
			),
			'member_phone' => array(
				'label'    => esc_html__( 'Bio Phone', 'et_builder' ),
				'selector' => '.bio-phone',
			),
			'member_name' => array(
				'label'    => esc_html__( 'Bio Name', 'et_builder' ),
				'selector' => '.bio-name',
			),
			'member_position' => array(
				'label'    => esc_html__( 'Job Title', 'et_builder' ),
				'selector' => '.bio-title',
			),
			'member_social_links' => array(
				'label'    => esc_html__( 'Bio Social Links', 'et_builder' ),
				'selector' => '.bio-social',
			),
		);
		

		$this->help_videos = array(
			array(
				'id'   => esc_html( 'rrKmaQ0n7Hw' ),
				'name' => esc_html__( 'An introduction to the Person module', 'et_builder' ),
			),
		);
	}

	function get_fields() {
		$options=[];
		$bios = $this->bios_query->get_results();
		foreach($bios as $bio){
			$bio_info = get_userdata($bio->ID);
			$options[$bio->ID] = esc_html__( $bio_info->last_name . ' ' . $bio_info->first_name, 'et_builder' );
		}
		/*
		$bio_profile = [];
		if($this->props['bio']!=0){
			$selected_bio = $this->props['bio'];
			$meta_values = get_cfc_meta( 'bio_profile', $bio);
			$bio_profile = $meta_values[0];
		}
		*/

		$fields = array(
			'bio' => array(
				'label'           => esc_html__( 'Bio', 'divicf-divi-custom-fields' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'Select Bio.', 'divicf-divi-custom-fields' ),
				'toggle_slug'     => 'main_content',
				'options'         => $options,
				'priority'          => 80,
				'default'           => $bios[0]->ID,
				'default_on_front'  => $bios[0]->ID,
			),
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon',
				'hover'             => 'tabs',
			),
		);

		return $fields;
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();

		$fields['icon_color'] = array( 'color' => '%%order_class%% .et_pb_member_social_links a' );

		return $fields;
	}

	function get_pre_suffix($suffix){
		if (!empty($suffix)){
			return  ', ' . $suffix;  
		}
		return '';
	}

	function render( $attrs, $content = null, $render_slug ) {
		$bio_id = $this->props['bio'];
		$bio_profile = get_userdata( $bio_id  );
		$bio_profile->twitter = get_the_author_meta( 'twitter', $bio_id );
		$bio_profile->facebook = get_the_author_meta( 'facebook', $bio_id );
		$bio_profile->linkedin = get_the_author_meta( 'linkedin', $bio_id );
		$bio_profile->job_title = get_the_author_meta( 'job_title', $bio_id );
		$bio_profile->direct_phone = get_the_author_meta( 'direct_phone', $bio_id );
		$bio_profile->image = get_the_author_meta( 'image', $bio_id );
		//var_dump($bio_profile);
		if($bio_profile->display_name!=""){
			$name = $bio_profile->display_name;
		} else {
			$name =  $bio_profile->first_name . ' ' . $bio_profile->last_name;
		}
		
		$position                        = $bio_profile->job_title;
		$avatar                       = get_avatar_url($bio_id);
		$thumbnail_id = get_avatar_url($bio_id);
		$alt_text = $name;
		$animation                       = $this->props['animation'];
		$twitter_url                     = $bio_profile->twitter;
		$facebook_url                    = $bio_profile->facebook;
		$email                      	 = $bio_profile->user_email;
		$phone 							 = $bio_profile->direct_phone;
		$linkedin_url                    = $bio_profile->linkedin;
		$background_layout               = $this->props['background_layout'];
		$background_layout_hover         = et_pb_hover_options()->get_value( 'background_layout', $this->props, 'light' );
		$background_layout_hover_enabled = et_pb_hover_options()->is_enabled( 'background_layout', $this->props );
		$icon_color                      = $this->props['icon_color'];
		$header_level                    = $this->props['header_level'];
		$hover                           = et_pb_hover_options();

		$image = $social_links = '';

		if ( '' !== $icon_color ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_member_social_links a',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $icon_color )
				),
			) );
		}

		if ( $hover->is_enabled( 'icon_color', $this->props ) && $hover->get_value( 'icon_color', $this->props ) ) {
			ET_Builder_Element::set_style( $render_slug,
				array(
					'selector'    => '%%order_class%% .et_pb_member_social_links a:hover',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $hover->get_value( 'icon_color', $this->props ) )
					),
				) );
		}

		// Added for backward compatibility
		if ( empty( $animation ) ) {
			$animation = 'top';
		}

		if ( '' !== $image ) {
			// Images: Add CSS Filters and Mix Blend Mode rules (if set)
			$generate_css_filters_image = '';
			if ( array_key_exists( 'image', $this->advanced_fields ) && array_key_exists( 'css', $this->advanced_fields['image'] ) ) {
				$generate_css_filters_image = $this->generate_css_filters(
					$render_slug,
					'child_',
					self::$data_utils->array_get( $this->advanced_fields['image']['css'], 'main', '%%order_class%%' )
				);
			}

			$image_pathinfo = pathinfo( $image );
			$is_image_svg   = isset( $image_pathinfo['extension'] ) ? 'svg' === $image_pathinfo['extension'] : false;

			$image = sprintf(
				'<div class="divicf_bio_image et-waypoint%3$s%4$s%5$s">
					<img src="%1$s" alt="%2$s" />
				</div>',
				esc_attr( $image ),
				esc_attr( $name ),
				esc_attr( " et_pb_animation_{$animation}" ),
				$generate_css_filters_image,
				$is_image_svg ? esc_attr( " et-svg" ) : ''
			);
		}

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		// Module classnames
		$this->add_classname( array(
			"et_pb_bg_layout_{$background_layout}",
			'clearfix',
			$this->get_text_orientation_classname()
		) );

		if ( '' === $image ) {
			$this->add_classname( 'divicf_bio_no_image' );
		}

		$data_background_layout       = '';
		$data_background_layout_hover = '';
		if ( $background_layout_hover_enabled ) {
			$data_background_layout = sprintf(
				' data-background-layout="%1$s"',
				esc_attr( $background_layout )
			);
			$data_background_layout_hover = sprintf(
				' data-background-layout-hover="%1$s"',
				esc_attr( $background_layout_hover )
			);
		}

		//$template ='<div' . $this->module_id() . ' class="' . $this->module_classname( $render_slug ) . '" ' . et_core_esc_previously( $data_background_layout ). et_core_esc_previously( $data_background_layout_hover ). '>';
		$template = $parallax_image_background;
		$template .= $video_background;
		$template .='<div class="card-container">';
			$template .= '<div class="bio-photo">';
			$template .= '<div class="bio-photo-wrapper">';
			$template .= '<a href=" ' . $bio_profile->user_url . '" target="_new"><img src="' . $bio_profile->image . '" alt="' . $alt_text . '" class="loadafter"></a>';
			$template .= '</div>';
			$template .= '</div>';
			$template .= '<div class="bio-name">';
			$template .= '<a href="' . $bio_profile->user_url . '" target="_new">' .$name . '</a>';
			$template .= '</div>';
			
			if($position!=""){
				$template .= '<div class="bio-title">';
				$template .= $position;
				$template .= '</div>';
			}
			$template .= '<div class="bio-social">';
			if($email!=""){
				$template .= '<div class="social-box">';
				$template .= '<a href="mailto:' . $email . '" target="_blank" rel="noopener">';
				$template .= '<i title="email Link" class="fa fa-envelope circle"></i>';
				$template .= '</a>';
				$template .= '</div>';
			}

			if($twitter_url!=""){
				$template .= '<div class="social-box">';
				$template .= '<a href="https://twitter.com/' . $twitter_url . '" target="_blank" rel="noopener">';
				$template .= '<i title="twitter Link" class="fa fa-twitter-square circle"></i>';
				$template .= '</a>';
				$template .= '</div>';
			}
			if($facebook_url!=""){
				$template .= '<div class="social-box">';
				$template .= '<a href="https://facebook.com/' . $twitter_url . '" target="_blank" rel="noopener">';
				$template .= '<i title="facebook Link" class="fa fa-facebook-square circle"></i>';
				$template .= '</a>';
				$template .= '</div>';
			}
			
			if($linkedin_url!=""){
				$template .= '<div class="social-box">';
				$template .= '<a href="https://www.linkedin.com/in/' . $linkedin_url . '" target="_blank" rel="noopener">';
				$template .= '<i title="linkedin Link" class="fa fa-linkedin-square circle"></i>';
				$template .= '</a>';
				$template .= '</div>';
			}
			$template .= '</div>'; // .bio-social
			if($phone!=""){
				$template .= '<div class="bio-phone">';
				$template .= '<a href="tel:' . str_replace(array("(",")"," ","-"),'', $phone) . '" class="phone">' . $phone . '</a>';
				$template .= '</div>';		
			}
			if($bio_profile->description!=""){
				$template .= '<div class="bio-description">';
				$template .= '<p> ' . $bio_profile->description. ' </p>';
				$template .= '</div>';
			}
			$template .='<div class="bio-about">';
			$template .='<a class="et_pb_button et_pb_more_button" href="'.$bio_profile->user_url.'">Read ' . $bio_profile->first_name. '\'s Full Bio</a>';
			$template .='</div>';
			$template .= '</div>'; // .card-container
		//$template.='</div>';

		return $template;
	}
}

new DIVIUSERCARD_Bio;
