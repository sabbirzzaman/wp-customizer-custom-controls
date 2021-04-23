<?php

/**
 * Enqueue scripts and styles.
 * Our sample Social Icons are using Font Awesome icons so we need to include the FA CSS when viewing our site
 * The Single Accordion Control is also displaying some FA icons in the Customizer itself, so we need to enqueue FA CSS in the Customizer too
 *
 * @return void
 */
if ( ! function_exists( 'textdomain_scripts_styles' ) ) {
	function textdomain_scripts_styles() {
		// Register and enqueue our icon font
		// We're using the awesome Font Awesome icon font. http://fortawesome.github.io/Font-Awesome
		wp_register_style( 'fontawesome', trailingslashit( get_template_directory_uri() ) . '/inc/assets/css/fontawesome-all.min.css' , array(), '5.8.2', 'all' );
		wp_enqueue_style( 'fontawesome' );
	}
}
add_action( 'wp_enqueue_scripts', 'textdomain_scripts_styles' );
add_action( 'customize_controls_print_styles', 'textdomain_scripts_styles' );

/**
 * Enqueue scripts for our Customizer preview
 *
 * @return void
 */
if ( ! function_exists( 'textdomain_customizer_preview_scripts' ) ) {
	function textdomain_customizer_preview_scripts() {
		wp_enqueue_script( 'textdomain-customizer-preview', trailingslashit( get_template_directory_uri() ) . '/inc/assets/js/assets-preview.js', array( 'customize-preview', 'jquery' ) );
	}
}
add_action( 'customize_preview_init', 'textdomain_customizer_preview_scripts' );
	

/**
 * Return a string containing the sample TinyMCE Control
 * This is a sample function to show how you can use the TinyMCE Control for footer credits in your Theme
 * Add the following three lines of code to your footer.php file to display the content of your sample TinyMCE Control
 * <div class="footer-credits">
 *		<?php echo textdomain_get_credits(); ?>
 *	</div>
 */
if ( ! function_exists( 'textdomain_get_credits' ) ) {
	function textdomain_get_credits() {
		$defaults = textdomain_generate_defaults();

		// wpautop this so that it acts like the new visual text widget, since we're using the same TinyMCE control
		return wpautop( get_theme_mod( 'sample_tinymce_editor', $defaults['sample_tinymce_editor'] ) );
	}
}

/**
* Set our Customizer default options
*/
if ( ! function_exists( 'textdomain_generate_defaults' ) ) {
	function textdomain_generate_defaults() {
		$customizer_defaults = array(
			'social_newtab' => 0,
			'social_urls' => '',
			'social_alignment' => 'alignright',
			'social_rss' => 0,
			'social_url_icons' => '',
			'contact_phone' => '',
			'search_menu_icon' => 0,
			'woocommerce_shop_sidebar' => 1,
			'woocommerce_product_sidebar' => 0,
			'sample_toggle_switch' => 0,
			'sample_slider_control' => 48,
			'sample_slider_control_small_step' => 2,
			'sample_sortable_repeater_control' => '',
			'sample_image_radio_button' => 'sidebarright',
			'sample_text_radio_button' => 'right',
			'sample_image_checkbox' => 'stylebold,styleallcaps',
			'sample_single_accordion' => '',
			'sample_alpha_color' => 'rgba(209,0,55,0.7)',
			'sample_wpcolorpicker_alpha_color' => 'rgba(55,55,55,0.5)',
			'sample_wpcolorpicker_alpha_color2' => 'rgba(33,33,33,0.8)',
			'sample_pill_checkbox' => 'tiger,elephant,hippo',
			'sample_pill_checkbox2' => 'captainmarvel,msmarvel,squirrelgirl',
			'sample_pill_checkbox3' => 'author,categories,comments',
			'sample_simple_notice' => '',
			'sample_dropdown_select2_control_single' => 'vic',
			'sample_dropdown_select2_control_multi' => 'Antarctica/McMurdo,Australia/Melbourne,Australia/Broken_Hill',
			'sample_dropdown_select2_control_multi2' => 'Atlantic/Stanley,Australia/Darwin',
			'sample_dropdown_posts_control' => '',
			'sample_tinymce_editor' => '',
			'sample_google_font_select' => json_encode(
				array(
					'font' => 'Open Sans',
					'regularweight' => 'regular',
					'italicweight' => 'italic',
					'boldweight' => '700',
					'category' => 'sans-serif'
				)
			),
			'sample_default_text' => '',
			'sample_email_text' => '',
			'sample_url_text' => '',
			'sample_number_text' => '',
			'sample_hidden_text' => '',
			'sample_date_text' => '',
			'sample_default_checkbox' => 0,
			'sample_default_select' => 'jet-fuel',
			'sample_default_radio' => 'spider-man',
			'sample_default_dropdownpages' => '1548',
			'sample_default_textarea' => '',
			'sample_default_color' => '#333',
			'sample_default_media' => '',
			'sample_default_image' => '',
			'sample_default_cropped_image' => '',
			'sample_date_only' => '2017-08-28',
			'sample_date_time' => '2017-08-28 16:30:00',
			'sample_date_time_no_past_date' => date( 'Y-m-d' ),
		);

		return apply_filters( 'textdomain_customizer_defaults', $customizer_defaults );
	}
}

/**
* Load all our Customizer options
*/
include_once trailingslashit( dirname(__FILE__) ) . 'inc/customizer.php';
