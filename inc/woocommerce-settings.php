<?php
class Smashing_Fields_Plugin {

public function __construct() {
	// Hook into the admin menu
	add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
	add_action( 'admin_init', array( $this, 'setup_sections' ) );
	add_action( 'admin_init', array( $this, 'setup_fields' ) );

}

public function create_plugin_settings_page() {
	// Add the menu item and page
	$page_title = 'My Awesome Settings Page';
	$menu_title = 'Awesome Plugin';
	$capability = 'manage_options';
	$slug = 'smashing_fields';
	$callback = array( $this, 'plugin_settings_page_content' );
	$icon = 'dashicons-admin-plugins';
	$position = 100;

	add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback );
}

public function plugin_settings_page_content() { ?>
	<div class="wrap">
		<h2>My Awesome Settings Page</h2>
		<form method="post" action="options.php">
            <?php
                settings_fields( 'smashing_fields' );
                do_settings_sections( 'smashing_fields' );
                submit_button();
            ?>
		</form>
	</div> <?php
}
public function setup_sections() {
	add_settings_section( 'our_first_section', 'My First Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
	add_settings_section( 'our_second_section', 'My Second Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
	add_settings_section( 'our_third_section', 'My Third Section Title', array( $this, 'section_callback' ), 'smashing_fields' );
}

public function section_callback( $arguments ) {
	switch( $arguments['id'] ){
		case 'our_first_section':
			echo 'This is the first description here!';
			break;
		case 'our_second_section':
			echo 'This one is number two';
			break;
		case 'our_third_section':
			echo 'Third time is the charm!';
			break;
	}
}

public function setup_fields() {
    add_settings_field( 'our_first_field', 'Field Name', array( $this, 'field_callback' ), 'smashing_fields', 'our_first_section' );
}

public function field_callback( $arguments ) {
	echo '<input name="our_first_field" id="our_first_field" type="text" value="' . get_option( 'our_first_field' ) . '" />';
	register_setting( 'smashing_fields', 'our_first_field' );
}


}
new Smashing_Fields_Plugin();