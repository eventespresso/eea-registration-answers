<h1><?php printf( esc_html__('Registration Answers for %1$s', 'event_espresso'), $event->name());?></h1>
<div id="event-answers-container">
    <?php foreach( $report_data as $question_group_data) {
        $question_group = $question_group_data['question_group'];
        $questions = $question_group_data['questions'];
        ?>
        <h2><?php $question_group->e('QSG_name');?></h2>
        <?php foreach($questions as $question_data){
            $question = $question_data['question'];
            $is_enum = $question_data['is_enum'];
            $options = $question_data['options'];
            $option_totals = $question_data['option_totals'];
            $registrations = $question_data['registrations'];
            ?>
            <h3><?php printf(esc_html__('Question: %1$s', 'event_espresso'), $question->get('QST_display_text'));?></h3>

            <?php if ($is_enum) {?>
                <h4><?php _e('Totals','event_espresso');?></h4>
                <table>
                    <thead>
                    <tr>
                        <td><?php esc_html_e('Option', 'event_espresso')?></td>
                        <td><?php esc_html_e('Count', 'event_espresso');?></td>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $option_totals as $option_value => $count) { ?>
                            <tr>
                                <td><?php echo $option_value;?></td>
                                <td><?php echo $count;?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            <?php } ?>
            <h4><?php esc_html_e('Registrations', 'event_espresso');?></h4>
            <table>
                <thead>
                <tr>
                    <td><?php esc_html_e('Attendee', 'event_espresso');?></td>
                    <td><?php esc_html_e('Registration ID', 'event_espresso');?></td>
                    <td><?php esc_html_e('Reg Code', 'event_espresso')?></td>
                    <td><?php esc_html_e('Answer', 'event_espresso');?></td>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $registration_data){
                    $registration = $registration_data['registration'];
                    $attendee_name = $registration->attendee() instanceof EE_Attendee ? $registration->attendee()->full_name() : '';
                    $answers = $registration_data['answers'];?>
                    <tr>
                        <td><?php echo $attendee_name;?></td>
                        <td><?php echo $registration->ID();?></td>
                        <td><?php echo $registration->reg_code();?></td>
                        <td><?php echo implode(', ', $answers);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <?php
        }?>


    <?php } ?>

</div>