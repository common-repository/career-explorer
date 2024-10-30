<?php
/*
Plugin Name:  Career Explorer
Description:  The ultimate solution for managing job listings and empowering job seekers and employers.
Requires at least: 6.2
Tested up to: 6.3
Requires PHP: 7.4
Version: 1.0
Stable tag: 1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if (!defined('ABSPATH')) {
    die("Can't access");
}

add_action('admin_menu', 'ESCJ_form_fun');
function ESCJ_form_fun() {
    add_menu_page('Career Explorer', 'Career Explorer', 'manage_options', 'career_explorer', '', 'dashicons-businessman', 6);
    add_submenu_page('career_explorer', 'Settings', 'Settings', 'manage_options', 'customize_form', 'EFSP_page');
    remove_submenu_page('career_explorer', 'career_explorer');
}

function EFSP_page() {
    include("formsetting.php");
}

function DRAT_Table($table_name, $columns, $data) {
    global $wpdb;

    // Define the table structure
    $table_structure = [];
    foreach ($columns as $column) {
        $table_structure[] = "{$column[0]} {$column[1]} NOT NULL";
    }
    $table_structure[] = "PRIMARY KEY ({$columns[0][0]})";

    // Construct the SQL for creating the table
    $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}SF_{$table_name} (
        " . implode(",\n", $table_structure) . "
    ) ENGINE = InnoDB;";

    // Include WordPress upgrade functions
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // Execute the SQL to create/update the table
    dbDelta($sql);

    // Insert data into the table
    foreach ($data as $item) {
        $wpdb->insert("{$wpdb->prefix}SF_{$table_name}", $item);
    }
}




function ESCJ_activation() {
    global $wpdb;

    $form_table = 'form_setting';
    $form_columns = [
        ['id', 'INT NOT NULL AUTO_INCREMENT'],
        ['box_width', 'VARCHAR(255) NOT NULL'],
        ['bg_color', 'VARCHAR(255) NOT NULL'],
        ['border_color', 'VARCHAR(255) NOT NULL'],
        ['font', 'VARCHAR(255) NOT NULL'],
        ['text_color', 'VARCHAR(255) NOT NULL'],
        ['link_color', 'VARCHAR(255) NOT NULL'],
        ['status', 'VARCHAR(255) NOT NULL'],
        ['title', 'VARCHAR(255) NOT NULL'],
        ['keywords', 'VARCHAR(255) NOT NULL'],
        ['location', 'VARCHAR(255) NOT NULL'],
    ];

    $form_data = [
        [
            'box_width' => '1000',
            'bg_color' => '#ebdef0',
            'border_color' => '#4a235a',
            'font' => 'Times New Roman, serif',
            'text_color' => '#2c3e50',
            'link_color' => '#3498db',
            'status' => '1',
            'title' => 'Job Search',
            'keywords' => 'PHP Developer',
            'location' => 'Indore'
        ]
    ];

    // Create and populate tables
    DRAT_Table($form_table, $form_columns, $form_data);
}
register_activation_hook(__FILE__, 'ESCJ_activation');


function ESCJ_deactivation() {
    global $wpdb;
       $wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . "SF_form_setting");

    // Insert a new record into the table
    $data_to_insert = array(
        'box_width'    => '1000',
        'bg_color'     => '#ccc',
        'border_color' => '#000',
        'font'         => 'Times New Roman, serif"',
        'text_color'   => '#000',
        'link_color'   => '#000',
        'status'       => '1',
        'title'        => 'Job Search',
        'keywords'     => 'PHP Developer',
        'location'     => 'Indore'
    );

    $wpdb->insert($table_name, $data_to_insert);
}
register_deactivation_hook(__FILE__, 'ESCJ_deactivation');




function ECECP_search()
{
    include("searchfromrun.php");
}
add_shortcode('TCJSPE', 'ECECP_search');


// Enqueue CSS file
function ESCJ_enqueue_styles() {
    // Register the stylesheet
    wp_register_style( 'bootstrap-style', plugin_dir_url( __FILE__ ) . 'assets/css/bootstrap-style.css', array(), '1.0', 'all' );

    // Enqueue the stylesheet
    wp_enqueue_style( 'bootstrap-style' );
}
add_action( 'wp_enqueue_scripts', 'ESCJ_enqueue_styles' );


?>
