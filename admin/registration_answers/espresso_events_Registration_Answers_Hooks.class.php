<?php if ( ! defined( 'EVENT_ESPRESSO_VERSION' )) { exit('NO direct script access allowed'); }
/**
 *
 * espresso_events_Registration_Form_Hooks
 * Hooks various messages logic so that it runs on indicated Events Admin Pages.
 * Commenting/docs common to all children classes is found in the EE_Admin_Hooks parent.
 *
 *
 * @package			espresso_events_Registration_Answers_Hooks
 * @subpackage		wp-content/plugins/eea-registration-answers/admin/registration_answers/espresso_events_Registration_Answers_Hooks.class.php
 * @author				Darren Ethier
 *
 * ------------------------------------------------------------------------
 */
class espresso_events_Registration_Answers_Hooks extends EE_Admin_Hooks {

	protected function _set_hooks_properties() {
        $this->_name = 'registration_answers';
    }

	public function _redirect_action_early_update_category( $redirection_query_args ) { }

	public function _redirect_action_early_insert_category( $redirection_query_args ) { }

}
// End of file espresso_events_Registration_Answers_Hooks.class.php
// Location: /wp-content/plugins/eea-registration-answers/admin/registration_answers/espresso_events_Registration_Answers_Hooks.class.php