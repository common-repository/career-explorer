<?php

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// If accessed directly, then exit.
if ( ! defined('ABSPATH') ) {
    exit;
}
global $wpdb;
$SF_form_setting = $wpdb->prefix . 'SF_form_setting';
$wpdb->query( $wpdb->prepare("DROP TABLE IF EXISTS %s", $SF_form_setting) );
