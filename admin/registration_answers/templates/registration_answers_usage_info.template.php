<div class="padding">
    <h2>
        <?php _e('Directions', 'event_espresso'); ?>
    </h2>
    <h3>
        <?php _e( 'Registration Answers Per Event', 'event_espresso');?>
    </h3>
    <p><?php printf(
            __('From the WP Dashboard, go to your event list. Under "actions", click on the new %1$s "View Answers" button.', 'event_espresso'),
        '<span class="dashicons dashicons-forms"></span>'
    ); ?>
    </p>
    <p>
        <?php printf(
            esc_html__('From there, you will see all the answers to custom questions given by registrants. %1$sWatch this demo video%2$s', 'event_espresso'),
            '<a href="https://drive.google.com/file/d/1XNGNrMkrt5Y6tdo-4N17JFzom_J3Xkl3/view" target="_blank">',
            '</a>'
        );?>
    </p>
    <h3>
        <?php _e( 'All Registration Answers', 'event_espresso');?>
    </h3>
    <a href="<?php echo $all_reg_answers_link;?>" class="button"><?php _e('View All Registration Answers', 'event_espresso');?></a>
    <p>
        <?php _e('Note: if you have over 100 registrations, this option probably won\'t work for you.', 'event_espresso'); ?>
    </p>
</div>
<!-- / .padding -->