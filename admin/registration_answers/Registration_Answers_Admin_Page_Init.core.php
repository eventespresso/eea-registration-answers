<?php if ( ! defined('EVENT_ESPRESSO_VERSION')) exit('No direct script access allowed');
/**
*
* Registration_Answers_Admin_Page_Init class
*
* This is the init for the Registration_Answers Addon Admin Pages.  See EE_Admin_Page_Init for method inline docs.
*
* @package			Event Espresso (registration_answers addon)
* @subpackage		admin/Registration_Answers_Admin_Page_Init.core.php
* @author				Darren Ethier
*
* ------------------------------------------------------------------------
*/
class Registration_Answers_Admin_Page_Init extends EE_Admin_Page_Init  {

	/**
	 * 	constructor
	 *
	 * @access public
	 * @return \Registration_Answers_Admin_Page_Init
	 */
	public function __construct() {

		do_action( 'AHEE_log', __FILE__, __FUNCTION__, '' );

		define( 'REGISTRATION_ANSWERS_PG_SLUG', 'espresso_registration_answers' );
		define( 'REGISTRATION_ANSWERS_LABEL', __( 'Registration Answers', 'event_espresso' ));
		define( 'EE_REGISTRATION_ANSWERS_ADMIN_URL', admin_url( 'admin.php?page=' . REGISTRATION_ANSWERS_PG_SLUG ));
		define( 'EE_REGISTRATION_ANSWERS_ADMIN_ASSETS_PATH', EE_REGISTRATION_ANSWERS_ADMIN . 'assets' . DS );
		define( 'EE_REGISTRATION_ANSWERS_ADMIN_ASSETS_URL', EE_REGISTRATION_ANSWERS_URL . 'admin' . DS . 'registration_answers' . DS . 'assets' . DS );
		define( 'EE_REGISTRATION_ANSWERS_ADMIN_TEMPLATE_PATH', EE_REGISTRATION_ANSWERS_ADMIN . 'templates' . DS );
		define( 'EE_REGISTRATION_ANSWERS_ADMIN_TEMPLATE_URL', EE_REGISTRATION_ANSWERS_URL . 'admin' . DS . 'registration_answers' . DS . 'templates' . DS );

		parent::__construct();
		$this->_folder_path = EE_REGISTRATION_ANSWERS_ADMIN;

	}





	protected function _set_init_properties() {
		$this->label = REGISTRATION_ANSWERS_LABEL;
	}



	/**
	*		_set_menu_map
	*
	*		@access 		protected
	*		@return 		void
	*/
	protected function _set_menu_map() {
		$this->_menu_map = new EE_Admin_Page_Sub_Menu( array(
			'menu_group' => 'addons',
			'menu_order' => 25,
			'show_on_menu' => EE_Admin_Page_Menu_Map::BLOG_ADMIN_ONLY,
			'parent_slug' => 'espresso_events',
			'menu_slug' => REGISTRATION_ANSWERS_PG_SLUG,
			'menu_label' => REGISTRATION_ANSWERS_LABEL,
			'capability' => 'administrator',
			'admin_init_page' => $this
		));
	}



}
// End of file Registration_Answers_Admin_Page_Init.core.php
// Location: /wp-content/plugins/eea-registration-answers/admin/registration_answers/Registration_Answers_Admin_Page_Init.core.php
