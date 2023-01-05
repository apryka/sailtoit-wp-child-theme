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
    wp_enqueue_script("child-scripts", get_stylesheet_directory_uri() . "/js/view.js", array("jquery"), "6.1.1", true);
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