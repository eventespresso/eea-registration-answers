<?php
/*
  Plugin Name: Event Espresso - Custom Question Reports (EE 4.8+)
  Plugin URI: http://www.eventespresso.com
  Description: The Event Espresso Registration Answers add-on adds reports that facilitate viewing registrations' answers to custom questions.
  Version: 1.0.0.dev.000
  Author: Event Espresso
  Author URI: http://www.eventespresso.com
  Copyright 2014 Event Espresso (email : support@eventespresso.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA02110-1301USA
 *
 * ------------------------------------------------------------------------
 *
 * Event Espresso
 *
 * Event Registration and Management Plugin for WordPress
 *
 * @ package		Event Espresso
 * @ author			Event Espresso
 * @ copyright	(c) 2008-2014 Event Espresso  All Rights Reserved.
 * @ license		http://eventespresso.com/support/terms-conditions/   * see Plugin Licensing *
 * @ link				http://www.eventespresso.com
 * @ version	 	EE4
 *
 * ------------------------------------------------------------------------
 */
// define versions and this file
define( 'EE_REGISTRATION_ANSWERS_CORE_VERSION_REQUIRED', '4.8.0.rc.0000' );
define( 'EE_REGISTRATION_ANSWERS_VERSION', '1.0.0.dev.001' );
define( 'EE_REGISTRATION_ANSWERS_PLUGIN_FILE',  __FILE__ );




/**
 *    captures plugin activation errors for debugging
 */
function espresso_registration_answers_plugin_activation_errors() {

	if ( WP_DEBUG ) {
		$activation_errors = ob_get_contents();
		file_put_contents( EVENT_ESPRESSO_UPLOAD_DIR . 'logs' . DS . 'espresso_registration_answers_plugin_activation_errors.html', $activation_errors );
	}
}
add_action( 'activated_plugin', 'espresso_registration_answers_plugin_activation_errors' );



/**
 *    registers addon with EE core
 */
function load_espresso_registration_answers() {
  if ( class_exists( 'EE_Addon' )) {
      // registration_answers version
      require_once ( plugin_dir_path( __FILE__ ) . 'EE_Registration_Answers.class.php' );
      EE_Registration_Answers::register_addon();
  } else {
    add_action( 'admin_notices', 'espresso_registration_answers_activation_error' );
  }
}
add_action( 'AHEE__EE_System__load_espresso_addons', 'load_espresso_registration_answers' );



/**
 *    verifies that addon was activated
 */
function espresso_registration_answers_activation_check() {
  if ( ! did_action( 'AHEE__EE_System__load_espresso_addons' ) ) {
    add_action( 'admin_notices', 'espresso_registration_answers_activation_error' );
  }
}
add_action( 'init', 'espresso_registration_answers_activation_check', 1 );



/**
 *    displays activation error admin notice
 */
function espresso_registration_answers_activation_error() {
  unset( $_GET[ 'activate' ] );
  unset( $_REQUEST[ 'activate' ] );
  if ( ! function_exists( 'deactivate_plugins' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  }
  deactivate_plugins( plugin_basename( EE_REGISTRATION_ANSWERS_PLUGIN_FILE ) );
  ?>
  <div class="error">
    <p><?php printf( __( 'Event Espresso Registration Answers could not be activated. Please ensure that Event Espresso version %1$s or higher is running', 'event_espresso' ), EE_REGISTRATION_ANSWERS_CORE_VERSION_REQUIRED ); ?></p>
  </div>
<?php
}



// End of file espresso_registration_answers.php
// Location: wp-content/plugins/eea-registration-answers/espresso_registration_answers.php