<?php
// add_action("wp_enqueue_scripts", "wp_child_theme", 10);
// function wp_child_theme() 
// {
//     if((esc_attr(get_option("wp_child_theme_setting")) != "Yes")) 
//     {
// 		wp_enqueue_style("parent-stylesheet", get_template_directory_uri()."/style.css");
//     }

// 	wp_enqueue_style("child-stylesheet", get_stylesheet_uri());
// 	wp_enqueue_script("child-scripts", get_stylesheet_directory_uri() . "/js/view.js", array("jquery"), "6.1.1", true);
// }

add_action( 'wp_enqueue_scripts', 'wp_child_theme' );
function wp_child_theme() {
    $parenthandle = 'twenty-twenty-one-style'; // This is 'twenty-twenty-one-style' for the Twenty Twenty-one theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-stylesheet', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
    wp_enqueue_script("child-scripts-count-up", get_stylesheet_directory_uri() . "/js/countUp.min.js", array("jquery"), "6.1.1", true);
    wp_enqueue_script("child-scripts-counter", get_stylesheet_directory_uri() . "/js/counter.js", array("jquery"), "6.1.1", true);
}

function wp_child_theme_register_settings() 
{ 
	register_setting("wp_child_theme_options_page", "wp_child_theme_setting", "wct_callback");
}
add_action("admin_init", "wp_child_theme_register_settings");

function wp_child_theme_register_options_page() 
{
	add_options_page("Child Theme Settings", "Child Theme", "manage_options", "wp_child_theme", "wp_child_theme_register_options_page_form");
}
add_action("admin_menu", "wp_child_theme_register_options_page");

function wp_child_theme_register_options_page_form()
{ 
?>
<div id="wp_child_theme">
    <h1>Child Theme Options</h1>
    <h2>Include or Exclude Parent Theme Stylesheet</h2>
    <form method="post" action="options.php">
        <?php settings_fields("wp_child_theme_options_page"); ?>
        <p><label><input size="3" type="checkbox" name="wp_child_theme_setting" id="wp_child_theme_setting" <?php if((esc_attr(get_option("wp_child_theme_setting")) == "Yes")) { echo " checked "; } ?> value="Yes"> Tick To Disable The Parent Stylesheet (style.css) In Your Site HTML<label></p>
        <?php submit_button(); ?>
    </form>
    <p>Only Tick This Box If When You Inspect Your Source Code It Contains Your Parent Stylesheet style.css Two Times.</label></p>
</div>
<?php
}

add_action('customize_register','customizer_options');
function customizer_options( $wp_customize ) {

  $wp_customize->add_setting( 'logo_width', array(
    'default' => __( '', 'twentytwentyone' ),
  ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'custom_logo_width',
            array(
                'label'          => __( 'Logo width', 'twentytwentyone' ),
                'section'        => 'title_tagline',
                'settings'       => 'logo_width',
                'type'           => 'text',
            )
        )
    );

    $wp_customize->add_setting( 'custom_mobile_menu_background', array(
        'default'           => '#0e2e29',
        'capability'        => 'edit_theme_options',
        ) );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize, 
            'mobile_menu_background', array(
        'label'    => __('Mobile menu background', 'twentytwentyone'),
        'section'  => 'colors',
        'settings' => 'custom_mobile_menu_background',
    )));

    $wp_customize->add_setting( 'custom_mobile_menu_text_color', array(
        'default'           => '#ffffff',
        'capability'        => 'edit_theme_options',
    ) );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize, 
            'mobile_menu_text color', array(
        'label'    => __('Mobile menu text color', 'twentytwentyone'),
        'section'  => 'colors',
        'settings' => 'custom_mobile_menu_text_color',
    )));

};

function custom_logo_width( $attr, $attachment, $size ) {

	if ( is_admin() ) {
		return $attr;
	}

	if ( isset( $attr['class'] ) && false !== strpos( $attr['class'], 'custom-logo' ) ) {

        $custom_logo_width = get_theme_mod( 'logo_width' );
        if ( isset($custom_logo_width) ) {
            $attr['style'] = isset( $attr['style'] ) ? $attr['style'] : '';
            $attr['style'] = 'width:' . $custom_logo_width . 'px;' . $attr['style']; 
        }

		return $attr;
	}

	$width  = false;
	$height = false;

	if ( is_array( $size ) ) {
		$width  = (int) $size[0];
		$height = (int) $size[1];
	} elseif ( $attachment && is_object( $attachment ) && $attachment->ID ) {
		$meta = wp_get_attachment_metadata( $attachment->ID );
		if ( isset( $meta['width'] ) && isset( $meta['height'] ) ) {
			$width  = (int) $meta['width'];
			$height = (int) $meta['height'];
		}
	}

	if ( $width && $height ) {

		// Add style.
		$attr['style'] = isset( $attr['style'] ) ? $attr['style'] : '';
		$attr['style'] = 'width:100%;height:' . round( 100 * $height / $width, 2 ) . '%;max-width:' . $width . 'px;' . $attr['style'];
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'custom_logo_width', 10, 3 );