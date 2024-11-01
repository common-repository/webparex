<?php
/**
 * Plugin Name: Webparex
 * Description: 17+ Carriers, Shipping Labels, Returns & Exchanges, NDR, RTO
 * Version: 1.0
 * Author: Tensor Logistics Pvt Ltd
 * Author URI: http://www.webparex.com
 */

 /*  Copyright 2022  Tensor Logistics Pvt Ltd 

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

register_activation_hook(__FILE__,'webparex_activate');
register_deactivation_hook(__FILE__,'webparex_deactivate');

function webparex_activate(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE `{$wpdb->base_prefix}webparex_config` (
        id int NOT NULL AUTO_INCREMENT,
        public_key varchar(255) NOT NULL,
        private_key varchar(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    $wpdb->query($sql);
}

global $jal_db_version;
$jal_db_version = '1.0';

add_option( 'jal_db_version', $jal_db_version );
add_action( 'admin_menu', 'webparex_menu' );
add_shortcode('webparex','webparex_tracking_order');

function webparex_menu() {
	add_menu_page('Webparex','Webparex',8,__FILE__,'webparex_config');
}

function webparex_config(){
    include('webparex_config.php');
}

function webparex_tracking_order(){
    if(!isset($_REQUEST['_locale'])){
        include('tracking.php');
    }
}

function webparex_deactivate(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "DROP TABLE `{$wpdb->base_prefix}webparex_config`";
    $wpdb->query($sql);
}

?>