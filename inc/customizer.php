<?php
/**
 * Customizer Setup and Custom Controls
 *
 */

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Textdomain_initialise_customizer_settings {
	// Get our default values
	private $defaults;

	public function __construct() {
		// Get our Customizer defaults
		$this->defaults = textdomain_generate_defaults();

		// Register our Panels
		add_action( 'customize_register', array( $this, 'textdomain_add_customizer_panels' ) );

		// Register our sections
		add_action( 'customize_register', array( $this, 'textdomain_add_customizer_sections' ) );

		// Register our sample Custom Control controls
		add_action( 'customize_register', array( $this, 'textdomain_register_sample_custom_controls' ) );

	}

	/**
	 * Register the Customizer panels
	 */
	public function textdomain_add_customizer_panels( $wp_customize ) {
		/**
		 * Add our Header & Navigation Panel
		 */
		 $wp_customize->add_panel( 'cusotm_controls_panel',
		 	array(
				'title' => __( 'Custom Controls', 'textdomain' ),
				'priority' => 10
			)
		);
	}

	/**
	 * Register the Customizer sections
	 */
	public function textdomain_add_customizer_sections( $wp_customize ) {
		/**
		 * Add our section that contains examples of our Custom Controls
		 */
		$wp_customize->add_section( 'sample_custom_controls_section',
			array(
				'title' => __( 'Sample Custom Controls', 'textdomain' ),
				'description' => esc_html__( 'These are an example of Customizer Custom Controls.', 'textdomain'  ),
				'panel' => 'cusotm_controls_panel'
			)
		);

		/**
		 * Add our Upsell Section
		 */
		$wp_customize->add_section( new Textdomain_Upsell_Section( $wp_customize, 'upsell_section',
			array(
				'title' => __( 'Your Upsell URL', 'textdomain' ),
				'url' => '#',
				'backgroundcolor' => '#344860',
				'textcolor' => '#fff',
				'priority' => 0,
			)
		) );
	}

	/**
	 * Register our sample custom controls
	 */
	public function textdomain_register_sample_custom_controls( $wp_customize ) {

		// Test of Toggle Switch Custom Control
		$wp_customize->add_setting( 'sample_toggle_switch',
			array(
				'default' => $this->defaults['sample_toggle_switch'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_switch_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Toggle_Switch_Custom_control( $wp_customize, 'sample_toggle_switch',
			array(
				'label' => __( 'Toggle switch', 'textdomain' ),
				'section' => 'sample_custom_controls_section'
			)
		) );

		// Test of Slider Custom Control
		$wp_customize->add_setting( 'sample_slider_control',
			array(
				'default' => $this->defaults['sample_slider_control'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control( new Textdomain_Slider_Custom_Control( $wp_customize, 'sample_slider_control',
			array(
				'label' => __( 'Slider Control (px)', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'min' => 10,
					'max' => 90,
					'step' => 1,
				),
			)
		) );

		// Another Test of Slider Custom Control
		$wp_customize->add_setting( 'sample_slider_control_small_step',
			array(
				'default' => $this->defaults['sample_slider_control_small_step'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_range_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Slider_Custom_Control( $wp_customize, 'sample_slider_control_small_step',
			array(
				'label' => __( 'Slider Control With a Small Step', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'min' => 0,
					'max' => 4,
					'step' => .5,
				),
			)
		) );

		// Add our Sortable Repeater setting and Custom Control for Social media URLs
		$wp_customize->add_setting( 'sample_sortable_repeater_control',
			array(
				'default' => $this->defaults['sample_sortable_repeater_control'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_url_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Sortable_Repeater_Custom_Control( $wp_customize, 'sample_sortable_repeater_control',
			array(
				'label' => __( 'Sortable Repeater', 'textdomain' ),
				'description' => esc_html__( 'This is the control description.', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'button_labels' => array(
					'add' => __( 'Add Row', 'textdomain' ),
				)
			)
		) );

		// Test of Image Radio Button Custom Control
		$wp_customize->add_setting( 'sample_image_radio_button',
			array(
				'default' => $this->defaults['sample_image_radio_button'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_radio_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Image_Radio_Button_Custom_Control( $wp_customize, 'sample_image_radio_button',
			array(
				'label' => __( 'Image Radio Button Control', 'textdomain' ),
				'description' => esc_html__( 'Sample custom control description', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'choices' => array(
					'sidebarleft' => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'inc/assets/images/sidebar-left.png',
						'name' => __( 'Left Sidebar', 'textdomain' )
					),
					'sidebarnone' => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'inc/assets/images/sidebar-none.png',
						'name' => __( 'No Sidebar', 'textdomain' )
					),
					'sidebarright' => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'inc/assets/images/sidebar-right.png',
						'name' => __( 'Right Sidebar', 'textdomain' )
					)
				)
			)
		) );

		// Test of Text Radio Button Custom Control
		$wp_customize->add_setting( 'sample_text_radio_button',
			array(
				'default' => $this->defaults['sample_text_radio_button'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_radio_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Text_Radio_Button_Custom_Control( $wp_customize, 'sample_text_radio_button',
			array(
				'label' => __( 'Text Radio Button Control', 'textdomain' ),
				'description' => esc_html__( 'Sample custom control description', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'choices' => array(
					'left' => __( 'Left', 'textdomain' ),
					'centered' => __( 'Centered', 'textdomain' ),
					'right' => __( 'Right', 'textdomain'  )
				)
			)
		) );

		// Test of Image Checkbox Custom Control
		$wp_customize->add_setting( 'sample_image_checkbox',
			array(
				'default' => $this->defaults['sample_image_checkbox'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Image_checkbox_Custom_Control( $wp_customize, 'sample_image_checkbox',
			array(
				'label' => __( 'Image Checkbox Control', 'textdomain' ),
				'description' => esc_html__( 'Sample custom control description', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'choices' => array(
					'stylebold' => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'inc/assets/images/Bold.png',
						'name' => __( 'Bold', 'textdomain' )
					),
					'styleitalic' => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'inc/assets/images/Italic.png',
						'name' => __( 'Italic', 'textdomain' )
					),
					'styleallcaps' => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'inc/assets/images/AllCaps.png',
						'name' => __( 'All Caps', 'textdomain' )
					),
					'styleunderline' => array(
						'image' => trailingslashit( get_template_directory_uri() ) . 'inc/assets/images/Underline.png',
						'name' => __( 'Underline', 'textdomain' )
					)
				)
			)
		) );

		// Test of Single Accordion Control
		$sampleIconsList = array(
			'Behance' => __( '<i class="fab fa-behance"></i>', 'textdomain' ),
			'Bitbucket' => __( '<i class="fab fa-bitbucket"></i>', 'textdomain' ),
			'CodePen' => __( '<i class="fab fa-codepen"></i>', 'textdomain' ),
			'DeviantArt' => __( '<i class="fab fa-deviantart"></i>', 'textdomain' ),
			'Discord' => __( '<i class="fab fa-discord"></i>', 'textdomain' ),
			'Dribbble' => __( '<i class="fab fa-dribbble"></i>', 'textdomain' ),
			'Etsy' => __( '<i class="fab fa-etsy"></i>', 'textdomain' ),
			'Facebook' => __( '<i class="fab fa-facebook-f"></i>', 'textdomain' ),
			'Flickr' => __( '<i class="fab fa-flickr"></i>', 'textdomain' ),
			'Foursquare' => __( '<i class="fab fa-foursquare"></i>', 'textdomain' ),
			'GitHub' => __( '<i class="fab fa-github"></i>', 'textdomain' ),
			'Google+' => __( '<i class="fab fa-google-plus-g"></i>', 'textdomain' ),
			'Instagram' => __( '<i class="fab fa-instagram"></i>', 'textdomain' ),
			'Kickstarter' => __( '<i class="fab fa-kickstarter-k"></i>', 'textdomain' ),
			'Last.fm' => __( '<i class="fab fa-lastfm"></i>', 'textdomain' ),
			'LinkedIn' => __( '<i class="fab fa-linkedin-in"></i>', 'textdomain' ),
			'Medium' => __( '<i class="fab fa-medium-m"></i>', 'textdomain' ),
			'Patreon' => __( '<i class="fab fa-patreon"></i>', 'textdomain' ),
			'Pinterest' => __( '<i class="fab fa-pinterest-p"></i>', 'textdomain' ),
			'Reddit' => __( '<i class="fab fa-reddit-alien"></i>', 'textdomain' ),
			'Slack' => __( '<i class="fab fa-slack-hash"></i>', 'textdomain' ),
			'SlideShare' => __( '<i class="fab fa-slideshare"></i>', 'textdomain' ),
			'Snapchat' => __( '<i class="fab fa-snapchat-ghost"></i>', 'textdomain' ),
			'SoundCloud' => __( '<i class="fab fa-soundcloud"></i>', 'textdomain' ),
			'Spotify' => __( '<i class="fab fa-spotify"></i>', 'textdomain' ),
			'Stack Overflow' => __( '<i class="fab fa-stack-overflow"></i>', 'textdomain' ),
			'Tumblr' => __( '<i class="fab fa-tumblr"></i>', 'textdomain' ),
			'Twitch' => __( '<i class="fab fa-twitch"></i>', 'textdomain' ),
			'Twitter' => __( '<i class="fab fa-twitter"></i>', 'textdomain' ),
			'Vimeo' => __( '<i class="fab fa-vimeo-v"></i>', 'textdomain' ),
			'Weibo' => __( '<i class="fab fa-weibo"></i>', 'textdomain' ),
			'YouTube' => __( '<i class="fab fa-youtube"></i>', 'textdomain' ),
		);
		$wp_customize->add_setting( 'sample_single_accordion',
			array(
				'default' => $this->defaults['sample_single_accordion'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Single_Accordion_Custom_Control( $wp_customize, 'sample_single_accordion',
			array(
				'label' => __( 'Single Accordion Control', 'textdomain' ),
				'description' => $sampleIconsList,
				'section' => 'sample_custom_controls_section'
			)
		) );

		// Test of Alpha Color Picker Control
		$wp_customize->add_setting( 'sample_alpha_color',
			array(
				'default' => $this->defaults['sample_alpha_color'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'textdomain_hex_rgba_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Customize_Alpha_Color_Control( $wp_customize, 'sample_alpha_color',
			array(
				'label' => __( 'Alpha Color Picker Control', 'textdomain' ),
				'description' => esc_html__( 'Sample custom control description', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'show_opacity' => true,
				'palette' => array(
					'#000',
					'#fff',
					'#df312c',
					'#df9a23',
					'#eef000',
					'#7ed934',
					'#1571c1',
					'#8309e7'
				)
			)
		) );

		// Test of WPColorPicker Alpha Color Picker Control
		$wp_customize->add_setting( 'sample_wpcolorpicker_alpha_color',
			array(
				'default' => $this->defaults['sample_wpcolorpicker_alpha_color'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_hex_rgba_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Alpha_Color_Control( $wp_customize, 'sample_wpcolorpicker_alpha_color',
			array(
				'label' => __( 'WP ColorPicker Alpha Color Picker', 'textdomain' ),
				'description' => esc_html__( 'Sample color control with Alpha channel', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'palette' => array(
						'#000000',
						'#222222',
						'#444444',
						'#777777',
						'#999999',
						'#aaaaaa',
						'#dddddd',
						'#ffffff',
					)
				),
			)
		) );

		// Another Test of WPColorPicker Alpha Color Picker Control
		$wp_customize->add_setting( 'sample_wpcolorpicker_alpha_color2',
			array(
				'default' => $this->defaults['sample_wpcolorpicker_alpha_color2'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_hex_rgba_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Alpha_Color_Control( $wp_customize, 'sample_wpcolorpicker_alpha_color2',
			array(
				'label' => __( 'WP ColorPicker Alpha Color Picker', 'textdomain' ),
				'description' => esc_html__( 'Sample color control with Alpha channel', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'resetalpha' => false,
					'palette' => array(
						'rgba(99,78,150,1)',
						'rgba(67,78,150,1)',
						'rgba(34,78,150,.7)',
						'rgba(3,78,150,1)',
						'rgba(7,110,230,.9)',
						'rgba(234,78,150,1)',
						'rgba(99,78,150,.5)',
						'rgba(190,120,120,.5)',
					),
				),
			)
		) );

		// Test of Pill Checkbox Custom Control
		$wp_customize->add_setting( 'sample_pill_checkbox',
			array(
				'default' => $this->defaults['sample_pill_checkbox'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Pill_Checkbox_Custom_Control( $wp_customize, 'sample_pill_checkbox',
			array(
				'label' => __( 'Pill Checkbox Control', 'textdomain' ),
				'description' => esc_html__( 'This is a sample Pill Checkbox Control', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'sortable' => false,
					'fullwidth' => false,
				),
				'choices' => array(
					'tiger' => __( 'Tiger', 'textdomain' ),
					'lion' => __( 'Lion', 'textdomain' ),
					'giraffe' => __( 'Giraffe', 'textdomain'  ),
					'elephant' => __( 'Elephant', 'textdomain'  ),
					'hippo' => __( 'Hippo', 'textdomain'  ),
					'rhino' => __( 'Rhino', 'textdomain'  ),
				)
			)
		) );

		// Test of Pill Checkbox Custom Control
		$wp_customize->add_setting( 'sample_pill_checkbox2',
			array(
				'default' => $this->defaults['sample_pill_checkbox2'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Pill_Checkbox_Custom_Control( $wp_customize, 'sample_pill_checkbox2',
			array(
				'label' => __( 'Pill Checkbox Control', 'textdomain' ),
				'description' => esc_html__( 'This is a sample Sortable Pill Checkbox Control', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'sortable' => true,
					'fullwidth' => false,
				),
				'choices' => array(
					'captainamerica' => __( 'Captain America', 'textdomain' ),
					'ironman' => __( 'Iron Man', 'textdomain' ),
					'captainmarvel' => __( 'Captain Marvel', 'textdomain'  ),
					'msmarvel' => __( 'Ms. Marvel', 'textdomain'  ),
					'Jessicajones' => __( 'Jessica Jones', 'textdomain'  ),
					'squirrelgirl' => __( 'Squirrel Girl', 'textdomain'  ),
					'blackwidow' => __( 'Black Widow', 'textdomain'  ),
					'hulk' => __( 'Hulk', 'textdomain'  ),
				)
			)
		) );

		// Test of Pill Checkbox Custom Control
		$wp_customize->add_setting( 'sample_pill_checkbox3',
			array(
				'default' => $this->defaults['sample_pill_checkbox3'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Pill_Checkbox_Custom_Control( $wp_customize, 'sample_pill_checkbox3',
			array(
				'label' => __( 'Pill Checkbox Control', 'textdomain' ),
				'description' => esc_html__( 'This is a sample Sortable Fullwidth Pill Checkbox Control', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'sortable' => true,
					'fullwidth' => true,
				),
				'choices' => array(
					'date' => __( 'Date', 'textdomain' ),
					'author' => __( 'Author', 'textdomain' ),
					'categories' => __( 'Categories', 'textdomain'  ),
					'tags' => __( 'Tags', 'textdomain'  ),
					'comments' => __( 'Comments', 'textdomain'  ),
				)
			)
		) );

		// Test of Simple Notice control
		$wp_customize->add_setting( 'sample_simple_notice',
			array(
				'default' => $this->defaults['sample_simple_notice'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Simple_Notice_Custom_control( $wp_customize, 'sample_simple_notice',
			array(
				'label' => __( 'Simple Notice Control', 'textdomain' ),
				'description' => __( 'This Custom Control allows you to display a simple title and description to your users. You can even include <a href="http://google.com" target="_blank">basic html</a>.', 'textdomain' ),
				'section' => 'sample_custom_controls_section'
			)
		) );

		// Test of Dropdown Select2 Control (single select)
		$wp_customize->add_setting( 'sample_dropdown_select2_control_single',
			array(
				'default' => $this->defaults['sample_dropdown_select2_control_single'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Dropdown_Select2_Custom_Control( $wp_customize, 'sample_dropdown_select2_control_single',
			array(
				'label' => __( 'Dropdown Select2 Control', 'textdomain' ),
				'description' => esc_html__( 'Sample Dropdown Select2 custom control (Single Select)', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'placeholder' => __( 'Please select a state...', 'textdomain' ),
					'multiselect' => false,
				),
				'choices' => array(
					'nsw' => __( 'New South Wales', 'textdomain' ),
					'vic' => __( 'Victoria', 'textdomain' ),
					'qld' => __( 'Queensland', 'textdomain' ),
					'wa' => __( 'Western Australia', 'textdomain' ),
					'sa' => __( 'South Australia', 'textdomain' ),
					'tas' => __( 'Tasmania', 'textdomain' ),
					'act' => __( 'Australian Capital Territory', 'textdomain' ),
					'nt' => __( 'Northern Territory', 'textdomain' ),
				)
			)
		) );

		// Test of Dropdown Select2 Control (Multi-Select)
		$wp_customize->add_setting( 'sample_dropdown_select2_control_multi',
			array(
				'default' => $this->defaults['sample_dropdown_select2_control_multi'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Dropdown_Select2_Custom_Control( $wp_customize, 'sample_dropdown_select2_control_multi',
			array(
				'label' => __( 'Dropdown Select2 Control', 'textdomain' ),
				'description' => esc_html__( 'Sample Dropdown Select2 custom control  (Multi-Select)', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'multiselect' => true,
				),
				'choices' => array(
					__( 'Antarctica', 'textdomain' ) => array(
						'Antarctica/Casey' => __( 'Casey', 'textdomain' ),
						'Antarctica/Davis' => __( 'Davis', 'textdomain' ),
						'Antarctica/DumontDurville' => __( 'DumontDUrville', 'textdomain' ),
						'Antarctica/Macquarie' => __( 'Macquarie', 'textdomain' ),
						'Antarctica/Mawson' => __( 'Mawson', 'textdomain' ),
						'Antarctica/McMurdo' => __( 'McMurdo', 'textdomain' ),
						'Antarctica/Palmer' => __( 'Palmer', 'textdomain' ),
						'Antarctica/Rothera' => __( 'Rothera', 'textdomain' ),
						'Antarctica/Syowa' => __( 'Syowa', 'textdomain' ),
						'Antarctica/Troll' => __( 'Troll', 'textdomain' ),
						'Antarctica/Vostok' => __( 'Vostok', 'textdomain' ),
					),
					__( 'Atlantic', 'textdomain' ) => array(
						'Atlantic/Azores' => __( 'Azores', 'textdomain' ),
						'Atlantic/Bermuda' => __( 'Bermuda', 'textdomain' ),
						'Atlantic/Canary' => __( 'Canary', 'textdomain' ),
						'Atlantic/Cape_Verde' => __( 'Cape Verde', 'textdomain' ),
						'Atlantic/Faroe' => __( 'Faroe', 'textdomain' ),
						'Atlantic/Madeira' => __( 'Madeira', 'textdomain' ),
						'Atlantic/Reykjavik' => __( 'Reykjavik', 'textdomain' ),
						'Atlantic/South_Georgia' => __( 'South Georgia', 'textdomain' ),
						'Atlantic/Stanley' => __( 'Stanley', 'textdomain' ),
						'Atlantic/St_Helena' => __( 'St Helena', 'textdomain' ),
					),
					__( 'Australia', 'textdomain' ) => array(
						'Australia/Adelaide' => __( 'Adelaide', 'textdomain' ),
						'Australia/Brisbane' => __( 'Brisbane', 'textdomain' ),
						'Australia/Broken_Hill' => __( 'Broken Hill', 'textdomain' ),
						'Australia/Currie' => __( 'Currie', 'textdomain' ),
						'Australia/Darwin' => __( 'Darwin', 'textdomain' ),
						'Australia/Eucla' => __( 'Eucla', 'textdomain' ),
						'Australia/Hobart' => __( 'Hobart', 'textdomain' ),
						'Australia/Lindeman' => __( 'Lindeman', 'textdomain' ),
						'Australia/Lord_Howe' => __( 'Lord Howe', 'textdomain' ),
						'Australia/Melbourne' => __( 'Melbourne', 'textdomain' ),
						'Australia/Perth' => __( 'Perth', 'textdomain' ),
						'Australia/Sydney' => __( 'Sydney', 'textdomain' ),
					)
				)
			)
		) );

		// Test of Dropdown Select2 Control (Multi-Select) with single array choice
		$wp_customize->add_setting( 'sample_dropdown_select2_control_multi2',
			array(
				'default' => $this->defaults['sample_dropdown_select2_control_multi2'],
				'transport' => 'refresh',
				'sanitize_callback' => 'textdomain_text_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Dropdown_Select2_Custom_Control( $wp_customize, 'sample_dropdown_select2_control_multi2',
			array(
				'label' => __( 'Dropdown Select2 Control', 'textdomain' ),
				'description' => esc_html__( 'Another Sample Dropdown Select2 custom control (Multi-Select)', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'multiselect' => true,
				),
				'choices' => array(
					'Antarctica/Casey' => __( 'Casey', 'textdomain' ),
					'Antarctica/Davis' => __( 'Davis', 'textdomain' ),
					'Antarctica/DumontDurville' => __( 'DumontDUrville', 'textdomain' ),
					'Antarctica/Macquarie' => __( 'Macquarie', 'textdomain' ),
					'Antarctica/Mawson' => __( 'Mawson', 'textdomain' ),
					'Antarctica/McMurdo' => __( 'McMurdo', 'textdomain' ),
					'Antarctica/Palmer' => __( 'Palmer', 'textdomain' ),
					'Antarctica/Rothera' => __( 'Rothera', 'textdomain' ),
					'Antarctica/Syowa' => __( 'Syowa', 'textdomain' ),
					'Antarctica/Troll' => __( 'Troll', 'textdomain' ),
					'Antarctica/Vostok' => __( 'Vostok', 'textdomain' ),
					'Atlantic/Azores' => __( 'Azores', 'textdomain' ),
					'Atlantic/Bermuda' => __( 'Bermuda', 'textdomain' ),
					'Atlantic/Canary' => __( 'Canary', 'textdomain' ),
					'Atlantic/Cape_Verde' => __( 'Cape Verde', 'textdomain' ),
					'Atlantic/Faroe' => __( 'Faroe', 'textdomain' ),
					'Atlantic/Madeira' => __( 'Madeira', 'textdomain' ),
					'Atlantic/Reykjavik' => __( 'Reykjavik', 'textdomain' ),
					'Atlantic/South_Georgia' => __( 'South Georgia', 'textdomain' ),
					'Atlantic/Stanley' => __( 'Stanley', 'textdomain' ),
					'Atlantic/St_Helena' => __( 'St Helena', 'textdomain' ),
					'Australia/Adelaide' => __( 'Adelaide', 'textdomain' ),
					'Australia/Brisbane' => __( 'Brisbane', 'textdomain' ),
					'Australia/Broken_Hill' => __( 'Broken Hill', 'textdomain' ),
					'Australia/Currie' => __( 'Currie', 'textdomain' ),
					'Australia/Darwin' => __( 'Darwin', 'textdomain' ),
					'Australia/Eucla' => __( 'Eucla', 'textdomain' ),
					'Australia/Hobart' => __( 'Hobart', 'textdomain' ),
					'Australia/Lindeman' => __( 'Lindeman', 'textdomain' ),
					'Australia/Lord_Howe' => __( 'Lord Howe', 'textdomain' ),
					'Australia/Melbourne' => __( 'Melbourne', 'textdomain' ),
					'Australia/Perth' => __( 'Perth', 'textdomain' ),
					'Australia/Sydney' => __( 'Sydney', 'textdomain' ),
				)
			)
		) );

		// Test of Dropdown Posts Control
		$wp_customize->add_setting( 'sample_dropdown_posts_control',
			array(
				'default' => $this->defaults['sample_dropdown_posts_control'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control( new Textdomain_Dropdown_Posts_Custom_Control( $wp_customize, 'sample_dropdown_posts_control',
			array(
				'label' => __( 'Dropdown Posts Control', 'textdomain' ),
				'description' => esc_html__( 'Sample Dropdown Posts custom control description', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'posts_per_page' => -1,
					'orderby' => 'name',
					'order' => 'ASC',
				),
			)
		) );

		// Test of TinyMCE control
		$wp_customize->add_setting( 'sample_tinymce_editor',
			array(
				'default' => $this->defaults['sample_tinymce_editor'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
			)
		);
		$wp_customize->add_control( new Textdomain_TinyMCE_Custom_control( $wp_customize, 'sample_tinymce_editor',
			array(
				'label' => __( 'TinyMCE Control', 'textdomain' ),
				'description' => __( 'This is a TinyMCE Editor Custom Control', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					'mediaButtons' => true,
				)
			)
		) );
		$wp_customize->selective_refresh->add_partial( 'sample_tinymce_editor',
			array(
				'selector' => '.footer-credits',
				'container_inclusive' => false,
				'render_callback' => 'textdomain_get_credits_render_callback',
				'fallback_refresh' => false,
			)
		);

		// Test of Google Font Select Control
		$wp_customize->add_setting( 'sample_google_font_select',
			array(
				'default' => $this->defaults['sample_google_font_select'],
				'sanitize_callback' => 'textdomain_google_font_sanitization'
			)
		);
		$wp_customize->add_control( new Textdomain_Google_Font_Select_Custom_Control( $wp_customize, 'sample_google_font_select',
			array(
				'label' => __( 'Google Font Control', 'textdomain' ),
				'description' => esc_html__( 'All Google Fonts sorted alphabetically', 'textdomain' ),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'font_count' => 'all',
					'orderby' => 'alpha',
				),
			)
		) );
	}
}

/**
 * Render Callback for displaying the footer credits
 */
function textdomain_get_credits_render_callback() {
	echo textdomain_get_credits();
}

/**
 * Load all our Customizer Custom Controls
 */
require_once trailingslashit( dirname(__FILE__) ) . 'custom-controls.php';

/**
 * Initialise our Customizer settings
 */
$textdomain_settings = new textdomain_initialise_customizer_settings();
