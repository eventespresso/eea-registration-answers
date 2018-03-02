<?php if ( ! defined( 'EVENT_ESPRESSO_VERSION' ) ) {
	exit();
}
// define the plugin directory path and URL
define( 'EE_REGISTRATION_ANSWERS_BASENAME', plugin_basename( EE_REGISTRATION_ANSWERS_PLUGIN_FILE ) );
define( 'EE_REGISTRATION_ANSWERS_PATH', plugin_dir_path( __FILE__ ) );
define( 'EE_REGISTRATION_ANSWERS_URL', plugin_dir_url( __FILE__ ) );
define( 'EE_REGISTRATION_ANSWERS_ADMIN', EE_REGISTRATION_ANSWERS_PATH . 'admin' . DS . 'registration_answers' . DS );

/**
 * Class  EE_Registration_Answers
 *
 * @package     Event Espresso
 * @subpackage  eea-registration-answers
 * @author      Brent Christensen
 */
Class  EE_Registration_Answers extends EE_Addon {

    /**
     * EE_Registration_Answers constructor.
     * !!! IMPORTANT !!!
     * you should NOT run any logic in the constructor for addons
     * because addon construction should NOT result in code execution.
     * Successfully registering the addon via the EE_Register_Addon API
     * should be the ONLY way that code should execute.
     * This prevents errors happening due to incompatibilities between addons and core.
     * If you run code here, but core deems it necessary to NOT activate this addon,
     * then fatal errors could happen if this code attempts to reference
     * other classes that do not exist because they have not been loaded.
     * That said, it's still a better idea to any extra code
     * in the after_registration() method below.
     */
    // public function __construct()
    // {
    //     // if for some reason you absolutely, positively NEEEED a constructor...
    //     // then at least make sure to call the parent class constructor,
    //     // or things may not operate as expected.
    //     parent::__construct();
    // }



    /**
     * !!! IMPORTANT !!!
	 * this is not the place to perform any logic or add any other filter or action callbacks
	 * this is just to bootstrap your addon; and keep in mind the addon might be DE-registered
	 * in which case your callbacks should probably not be executed.
     * EED_Registration_Answers is typically the best place for most filter and action callbacks
     * to be placed (relating to the primary business logic of your addon)
     * IF however for some reason, a module does not work because you have some logic
     * that needs to run earlier than when the modules load,
     * then please see the after_registration() method below.
     *
     * @throws \EE_Error
	 */
	public static function register_addon() {
		// register addon via Plugin API
		EE_Register_Addon::register(
			'Registration_Answers',
			array(
				'version'               => EE_REGISTRATION_ANSWERS_VERSION,
				'plugin_slug'           => 'espresso_registration_answers',
				'min_core_version'      => EE_REGISTRATION_ANSWERS_CORE_VERSION_REQUIRED,
				'main_file_path'        => EE_REGISTRATION_ANSWERS_PLUGIN_FILE,
				'namespace'             => array(
					'FQNS' => 'EventEspresso\RegistrationAnswers',
					'DIR'  => __DIR__,
				),
				'admin_path'            => EE_REGISTRATION_ANSWERS_ADMIN,
				'admin_callback'        => '',
				'config_class'          => 'EE_Registration_Answers_Config',
				'config_name'           => 'EE_Registration_Answers',
				'autoloader_paths'      => array(
					'EE_Registration_Answers_Config'       => EE_REGISTRATION_ANSWERS_PATH . 'EE_Registration_Answers_Config.php',
					'Registration_Answers_Admin_Page'      => EE_REGISTRATION_ANSWERS_ADMIN . 'Registration_Answers_Admin_Page.core.php',
					'Registration_Answers_Admin_Page_Init' => EE_REGISTRATION_ANSWERS_ADMIN . 'Registration_Answers_Admin_Page_Init.core.php',
				),
				'module_paths'          => array( EE_REGISTRATION_ANSWERS_PATH . 'EED_Registration_Answers.module.php' ),
			)
		);
	}



    /**
     * uncomment this method and use it as
     * a safe space to add additional logic like setting hooks
     * that will run immediately after addon registration
     * making this a great place for code that needs to be "omnipresent"
     *
     * @since 4.9.26
     */
    public function after_registration()
    {
        // your logic here
    }



    /**
     * Override parent so the link appears as "usage" only
     * @param $links
     * @param $file
     * @return mixed
     */
    public function plugin_action_links($links, $file)
    {
        if ($file === $this->plugin_basename() && $this->plugin_action_slug() !== '') {
            // before other links
            array_unshift(
                $links,
                '<a href="admin.php?page=' . $this->plugin_action_slug() . '">'
                . esc_html__('Instructions', 'event_espresso')
                . '</a>'
            );
        }
        return $links;
    }



}
// End of file EE_Registration_Answers.class.php
// Location: wp-content/plugins/eea-registration-answers/EE_Registration_Answers.class.php
