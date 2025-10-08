<?php
/**
 * Plugin Name: Project Automations
 * Description: Handles scheduled jobs and event-driven workflows
 * Version: 1.0.0
 * Author: Your Team
 * Text Domain: my-project-automation
 */

if (!defined('ABSPATH')) exit;

add_filter( 'cron_schedules', function( $schedules ) {
    if ( ! isset( $schedules['weekly'] ) ) {
        $schedules['weekly'] = [
            'interval' => 7 * 24 * 60 * 60, // 1 week in seconds
            'display'  => __( 'Once Weekly' ),
        ];
    }
    return $schedules;
});

register_activation_hook( __FILE__, function() {
    if ( ! wp_next_scheduled( 'my_weekly_event' ) ) {
        wp_schedule_event( time(), 'weekly', 'my_weekly_event' );
    }
});

register_deactivation_hook( __FILE__, function() {
    wp_clear_scheduled_hook( 'my_weekly_event' );
});

function my_run_scheduled_job( $context = 'manual' ) {
    // Example logic — replace with your own
    error_log( sprintf( '[My Plugin] Running job, context: %s at %s', $context, current_time( 'mysql' ) ) );

    // For example, clean up inactive users or send reports...
}

add_action( 'my_weekly_event', function() {
    my_run_scheduled_job( 'weekly_cron' );
});

add_action( 'user_register', function( $user_id ) {
    my_run_scheduled_job( 'new_user_' . $user_id );
});

add_action( 'admin_init', function() {
    if ( isset( $_GET['run_my_job'] ) ) {
        my_run_scheduled_job( 'manual_trigger' );
        wp_die( 'Job executed manually!' );
    }
});
