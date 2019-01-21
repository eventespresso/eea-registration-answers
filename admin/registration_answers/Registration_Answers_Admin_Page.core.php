<?php if (! defined('EVENT_ESPRESSO_VERSION')) {
    exit('NO direct script access allowed');
}



/**
 * Registration_Answers_Admin_Page
 * This contains the logic for setting up the Registration_Answers Addon Admin related pages.  Any methods without PHP doc comments have inline docs with parent class.
 *
 * @package               Registration_Answers_Admin_Page (registration_answers addon)
 * @subpackage            admin/Registration_Answers_Admin_Page.core.php
 * @author                Darren Ethier, Brent Christensen
 * ------------------------------------------------------------------------
 */
class Registration_Answers_Admin_Page extends EE_Admin_Page
{

    /**
     * Data for the registrations answers reports, set when enqueing scripts, but also used later when rendering the page
     * @var array
     */
    protected $report_data = array();

    protected function _init_page_props()
    {
        $this->page_slug = REGISTRATION_ANSWERS_PG_SLUG;
        $this->page_label = REGISTRATION_ANSWERS_LABEL;
        $this->_admin_base_url = EE_REGISTRATION_ANSWERS_ADMIN_URL;
        $this->_admin_base_path = EE_REGISTRATION_ANSWERS_ADMIN;
    }



    protected function _ajax_hooks()
    {
    }



    protected function _define_page_props()
    {
        $this->_admin_page_title = REGISTRATION_ANSWERS_LABEL;
        $this->_labels = array(
            'publishbox' => __('Update Settings', 'event_espresso'),
        );
    }



    protected function _set_page_routes()
    {
        $this->_page_routes = array(
            // 'default'         => '_basic_settings',
            // 'update_settings' => array(
            //     'func'     => '_update_settings',
            //     'noheader' => true,
            // ),
            'default'           => '_usage',
            'registration_answers'   => array(
                'func' => 'registrationAnswers',
                'capability' => 'ee_read_registrations',
            )
        );
    }



    protected function _set_page_config()
    {

        $this->_page_config = array(
            // 'default' => array(
            //     'nav'           => array(
            //         'label' => __('Settings', 'event_espresso'),
            //         'order' => 10,
            //     ),
            //     'metaboxes'     => array_merge($this->_default_espresso_metaboxes, array('_publish_post_box')),
            //     'require_nonce' => false,
            // ),
            'default'   => array(
                'nav'           => array(
                    'label' => __('Custom Question Reports', 'event_espresso'),
                    'order' => 30,
                ),
                'require_nonce' => false,
            ),
        );
    }



    protected function _add_screen_options()
    {
    }



    protected function _add_screen_options_default()
    {
    }



    protected function _add_feature_pointers()
    {
    }



    public function load_scripts_styles()
    {
        wp_register_script('espresso_registration_answers_admin', EE_REGISTRATION_ANSWERS_ADMIN_ASSETS_URL . 'espresso_registration_answers_admin.js', array('espresso_core'),
            EE_REGISTRATION_ANSWERS_VERSION, true);
        wp_enqueue_script('espresso_registration_answers_admin');
    }



    public function admin_init()
    {
        EE_Registry::$i18n_js_strings['confirm_reset'] = __('Are you sure you want to reset ALL your Event Espresso Custom Question Reports Information? This cannot be undone.', 'event_espresso');
    }



    public function admin_notices()
    {
    }



    public function admin_footer_scripts()
    {
    }



    protected function _basic_settings()
    {
        $this->_settings_page('registration_answers_basic_settings.template.php');
    }



    /**
     * _settings_page
     *
     * @param $template
     */
    protected function _settings_page($template)
    {
        $this->_template_args['registration_answers_config'] = EE_Config::instance()->get_config('addons', 'EED_Registration_Answers', 'EE_Registration_Answers_Config');
        add_filter('FHEE__EEH_Form_Fields__label_html', '__return_empty_string');
        $this->_template_args['yes_no_values'] = array(
            EE_Question_Option::new_instance(array('QSO_value' => 0, 'QSO_desc' => __('No', 'event_espresso'))),
            EE_Question_Option::new_instance(array('QSO_value' => 1, 'QSO_desc' => __('Yes', 'event_espresso'))),
        );
        $this->_template_args['return_action'] = $this->_req_action;
        $this->_template_args['reset_url'] = EE_Admin_Page::add_query_args_and_nonce(array('action' => 'reset_settings', 'return_action' => $this->_req_action), EE_REGISTRATION_ANSWERS_ADMIN_URL);
        $this->_set_add_edit_form_tags('update_settings');
        $this->_set_publish_post_box_vars(null, false, false, null, false);
        $this->_template_args['admin_page_content'] = EEH_Template::display_template(EE_REGISTRATION_ANSWERS_ADMIN_TEMPLATE_PATH . $template, $this->_template_args, true);
        $this->display_admin_page_with_sidebar();
    }



    protected function _usage()
    {
        $page_query_args = array(
            'action'   => 'registration_answers'
        );
        $reg_answers_link = EE_Admin_Page::add_query_args_and_nonce($page_query_args, EE_REGISTRATION_ANSWERS_ADMIN_URL);
        $this->_template_args['admin_page_content'] = EEH_Template::display_template(
            EE_REGISTRATION_ANSWERS_ADMIN_TEMPLATE_PATH . 'registration_answers_usage_info.template.php',
                array(
                    'all_reg_answers_link' => $reg_answers_link
            ),
            true);
        $this->display_admin_page_with_no_sidebar();
    }



    protected function _update_settings()
    {
        if (isset($_POST['reset_registration_answers']) && $_POST['reset_registration_answers'] == '1') {
            $config = new EE_Registration_Answers_Config();
            $count = 1;
        } else {
            $config = EE_Config::instance()->get_config('addons', 'EED_Registration_Answers', 'EE_Registration_Answers_Config');
            $count = 0;
            //otherwise we assume you want to allow full html
            foreach ($this->_req_data['registration_answers'] as $top_level_key => $top_level_value) {
                if (is_array($top_level_value)) {
                    foreach ($top_level_value as $second_level_key => $second_level_value) {
                        if (EEH_Class_Tools::has_property($config, $top_level_key) && EEH_Class_Tools::has_property($config->{$top_level_key}, $second_level_key)
                            && $second_level_value
                               != $config->{$top_level_key}->{$second_level_key}) {
                            $config->{$top_level_key}->{$second_level_key} = $this->_sanitize_config_input($top_level_key, $second_level_key, $second_level_value);
                            $count++;
                        }
                    }
                } else {
                    if (EEH_Class_Tools::has_property($config, $top_level_key) && $top_level_value != $config->{$top_level_key}) {
                        $config->{$top_level_key} = $this->_sanitize_config_input($top_level_key, null, $top_level_value);
                        $count++;
                    }
                }
            }
        }
        EE_Config::instance()->update_config('addons', 'EED_Registration_Answers', $config);
        $this->_redirect_after_action($count, 'Settings', 'updated', array('action' => $this->_req_data['return_action']));
    }

    /**
     * resets the registration_answers data and redirects to where they came from
     */
    //	protected function _reset_settings(){
    //		EE_Config::instance()->addons['registration_answers'] = new EE_Registration_Answers_Config();
    //		EE_Config::instance()->update_espresso_config();
    //		$this->_redirect_after_action(1, 'Settings', 'reset', array('action' => $this->_req_data['return_action']));
    //	}
    private function _sanitize_config_input($top_level_key, $second_level_key, $value)
    {
        $sanitization_methods = array(
            'display' => array(
                'enable_registration_answers' => 'bool',
                //				'registration_answers_height'=>'int',
                //				'enable_registration_answers_filters'=>'bool',
                //				'enable_category_legend'=>'bool',
                //				'use_pickers'=>'bool',
                //				'event_background'=>'plaintext',
                //				'event_text_color'=>'plaintext',
                //				'enable_cat_classes'=>'bool',
                //				'disable_categories'=>'bool',
                //				'show_attendee_limit'=>'bool',
            ),
        );
        $sanitization_method = null;
        if (isset($sanitization_methods[$top_level_key]) && $second_level_key === null && ! is_array($sanitization_methods[$top_level_key])) {
            $sanitization_method = $sanitization_methods[$top_level_key];
        } elseif (is_array($sanitization_methods[$top_level_key]) && isset($sanitization_methods[$top_level_key][$second_level_key])) {
            $sanitization_method = $sanitization_methods[$top_level_key][$second_level_key];
        }
        //		echo "$top_level_key [$second_level_key] with value $value will be sanitized as a $sanitization_method<br>";
        switch ($sanitization_method) {
            case 'bool':
                return (boolean)intval($value);
            case 'plaintext':
                return wp_strip_all_tags($value);
            case 'int':
                return intval($value);
            case 'html':
                return $value;
            default:
                $input_name = $second_level_key == null ? $top_level_key : $top_level_key . "[" . $second_level_key . "]";
                EE_Error::add_error(sprintf(__("Could not sanitize input '%s' because it has no entry in our sanitization methods array", "event_espresso"), $input_name), __FILE__, __FUNCTION__,
                    __LINE__);
                return null;
        }
    }


    public function load_scripts_styles_registration_answers()
    {
        wp_register_script(
            'ee-reg-answers-js',
            EE_REGISTRATION_ANSWERS_ADMIN_ASSETS_URL . 'espresso-_registration_answers_admin.js',
             array('google-charts'),
            EE_REGISTRATION_ANSWERS_VERSION,
            true
        );
        wp_enqueue_script('ee-reg-answers-js');
        $this->setupRegistrationAnswersData();
        $charts_data = array();
        foreach($this->report_data as $question_group_data) {
            foreach($question_group_data['questions'] as $question_data) {
                if ($question_data['is_enum'] &&  $question_data['question'] instanceof EE_Question) {
                    $question =  $question_data['question'];
                    $rows = array();
                    foreach($question_data['option_totals'] as $key => $value ) {
                        $rows[] = array($key, $value);
                    }
                    $charts_data[] = array(
                        'question_id' => $question->ID(),
                        'title' => $question->get('QST_display_text'),
                        'rows' =>  $rows
                    );
                }
            }
        }
        wp_localize_script(
            'ee-reg-answers-js',
            'ee_reg_answers_js_data',
            $charts_data
        );

    }



    /**
     * Based on the incoming request, sets up the registration answers data
     */
    protected function setupRegistrationAnswersData()
    {
        $report_data = array();
        if ( isset($this->_req_data['EVT_ID'])) {
            $EVT_ID = $this->_req_data['EVT_ID'];
        } else {
            $EVT_ID = null;
        }

        $reg_query_params = array(
            array(),
            'force_join' => array('Attendee')
        );
        if ($EVT_ID) {
            $reg_query_params[0]['EVT_ID'] = $this->_req_data['EVT_ID'];
        }
        //get all registrations
        $registrations = EEM_Registration::instance()->get_all($reg_query_params);

        $question_group_query_params = array(
            array(),
            'order_by' => array(
                'QSG_order' => 'ASC'
            )
        );
        if ($EVT_ID) {
            $question_group_query_params[0]['Event.EVT_ID'] = $this->_req_data['EVT_ID'];
        }
        $question_groups = EEM_Question_Group::instance()->get_all($question_group_query_params);
        //for each question group, gets its questions
        foreach ($question_groups as $question_group) {

            $questions_data = array();
            $questions = $question_group->questions(
                array(
                    array(
                        'OR' => [
                            'QST_system' => ['IS_NULL'],
                            'QST_system*' => ''
                        ]
                    )
                )
            );
            //for each question, loop through all the registrations, getting their answer to that question
            foreach ($questions as $question) {

                //if the question is an enum, take note of the options
                $question_is_enum = $question->should_have_question_options();
                if ($question_is_enum) {
                    $options = $question->options();
                    $option_totals = array();
                    foreach($options as $option) {
                        $option_totals[$option->value()] = 0;
                    }
                } else {
                    $options = null;
                    $option_totals = array();
                }
                $registrations_data = array();
                foreach ($registrations as $registration) {
                    $answer_values = (array)$registration->answer_value_to_question($question, false);
                    if($question_is_enum) {
                        foreach ($answer_values as $answer_value) {
                            $option_totals[$answer_value] += 1;
                        }
                    }

                    //take note of how many registration chose that option
                    $registrations_data[] = array(
                        'registration' => $registration,
                        'answers' => $answer_values,
                    );

                }
                arsort($option_totals);
                $questions_data[] = array(
                    'question' => $question,
                    'is_enum' => $question_is_enum,
                    'options' => $options,
                    'registrations' => $registrations_data,
                    'option_totals' => $option_totals,
                );
            }
            $report_data[] = array(
                'question_group' => $question_group,
                'questions' => $questions_data
            );
        }
        $this->report_data = $report_data;
    }

    /**
     * Gets all the answers for the registrations. Possibly filtered by event ID
     */
    public function registrationAnswers()
    {
        if ( isset($this->_req_data['EVT_ID'])) {
            $EVT_ID = $this->_req_data['EVT_ID'];
        } else {
            $EVT_ID = null;
        }

        //put into a format usable in a report
        $template_path = EE_REGISTRATION_ANSWERS_ADMIN_TEMPLATE_PATH . 'registration_answers_event.template.php';

        if($EVT_ID) {
            $event = EEM_Event::instance()->get_one_by_ID($EVT_ID);
            $page_title = printf( esc_html__('Custom Question Report for Event "%1$s"', 'event_espresso'), $event->name());
        } else {
            $page_title = esc_html__('Custom Question Reports', 'event_espresso');
        }
        $this->_template_args['admin_page_content'] = EEH_Template::display_template(
            $template_path,
            array(
                'report_data' => $this->report_data,
                'event' => $page_title
            ),
            true
        );
        // the final template wrapper
        $this->display_admin_page_with_no_sidebar();
    }



}
// End of file Registration_Answers_Admin_Page.core.php
// Location: /wp-content/plugins/eea-registration-answers/admin/registration_answers/Registration_Answers_Admin_Page.core.php