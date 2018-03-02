<?php if (! defined('EVENT_ESPRESSO_VERSION')) {
    exit('No direct script access allowed');
}



/**
 * Class  EED_Registration_Answers
 * This is where miscellaneous action and filters callbacks should be setup to
 * do your addon's business logic (that doesn't fit neatly into one of the
 * other classes in the mock addon)
 *
 * @package               Event Espresso
 * @subpackage            eea-registration-answers
 * @author                Brent Christensen
 * ------------------------------------------------------------------------
 */
class EED_Registration_Answers extends EED_Module
{



    /**
     * @return EED_Registration_Answers
     */
    public static function instance()
    {
        return parent::get_instance(__CLASS__);
    }



    /**
     *    set_hooks - for hooking into EE Core, other modules, etc
     *
     * @access    public
     * @return    void
     */
    public static function set_hooks()
    {
    }



    /**
     *    set_hooks_admin - for hooking into EE Admin Core, other modules, etc
     *
     * @access    public
     * @return    void
     */
    public static function set_hooks_admin()
    {
        //add an action for viewing registration answers
        add_filter('FHEE__Events_Admin_List_Table__column_actions__action_links',
            array(
                'EED_Registration_Answers',
                'add_action_to_event_list_table',
            ),
            10,
            2
        );
    }



    public static function add_action_to_event_list_table($action_links, EE_Event $event)
    {
        $page_query_args = array(
            'action'   => 'event_answers',
            'EVT_ID' => $event->ID(),
        );
        $event_answers_link = EE_Admin_Page::add_query_args_and_nonce($page_query_args, EE_REGISTRATION_ANSWERS_ADMIN_URL);
        $action_links[] = '<a href="' . $event_answers_link . '"'
            . ' title="' . esc_attr__('View Answers', 'event_espresso') . '">'
            . '<span class="dashicons dashicons-forms"></span>';
         return $action_links;
    }



    /**
     *    run - initial module setup
     *
     * @access    public
     * @param  WP $WP
     * @return    void
     */
    public function run($WP)
    {
    }



    /**
     *    enqueue_scripts - Load the scripts and css
     *
     * @access    public
     * @return    void
     */
    public function enqueue_scripts()
    {
        //Check to see if the registration_answers css file exists in the '/uploads/espresso/' directory
        if (is_readable(EVENT_ESPRESSO_UPLOAD_DIR . "css/registration_answers.css")) {
            //This is the url to the css file if available
            wp_register_style('espresso_registration_answers', EVENT_ESPRESSO_UPLOAD_URL . 'css/espresso_registration_answers.css');
        } else {
            // EE registration_answers style
            wp_register_style('espresso_registration_answers', EE_REGISTRATION_ANSWERS_URL . 'css/espresso_registration_answers.css');
        }
        // registration_answers script
        wp_register_script('espresso_registration_answers', EE_REGISTRATION_ANSWERS_URL . 'scripts/espresso_registration_answers.js', array('jquery'), EE_REGISTRATION_ANSWERS_VERSION, true);
        // is the shortcode or widget in play?
        if (EED_Registration_Answers::$shortcode_active) {
            wp_enqueue_style('espresso_registration_answers');
            wp_enqueue_script('espresso_registration_answers');
        }
    }
}
// End of file EED_Registration_Answers.module.php
// Location: /wp-content/plugins/eea-registration-answers/EED_Registration_Answers.module.php
