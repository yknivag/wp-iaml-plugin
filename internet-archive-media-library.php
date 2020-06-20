<?php
/*
    Plugin Name: Internet Archive Media Library
    Plugin URI: https://github.com/yknivag/wp-iaml-plugin
    Description: Mapping file from Internet Archive (archive.org) into Wordpress Media. [Based on Google Drive Media Library by Felix Wei]
    Author: Gavin Smalley
    Version: 1.0.1
    Author URI: https://github.com/yknivag/
    License: GNU General Public License v3.0 or later
    License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Copyright (c)2016 Gavin Smalley
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( 'includes/class-IAMLWeb.php' );

// BEGIN HOUSE-KEEPING //

function iaml_activate() {
    $defaultPrefix = 'https://archive.org/download';
    add_option( 'iaml_prefix', $defaultPrefix );
}
register_activation_hook( __FILE__, 'iaml_activate' );

function iaml_deactivate() {
    // There is nothing to do here, the option is removed at plugin-delete as per
    // Wordpress coding guidelines.  
  
    // We don't touch uploaded media because (whilst it will no longer work when the plugin is
    // deactivated) it will work again if we leave it and the plugin is re-activated, and
    // the user may not be expecting their media library to disapear!
}
register_deactivation_hook( __FILE__, 'iaml_deactivate' );

function iaml_delete() {
    // Remove option
    
    delete_option( 'iaml_prefix' );

    // Again, we don't touch uploaded media because (whilst it will no longer work when the plugin is
    // deactivated/deleted) it will work again if we leave it and the plugin is re-installed, and
    // the user may not be expecting their media library to disapear!
}
register_uninstall_hook( __FILE__, 'iaml_delete' );

// END HOUSE-KEEPING //

add_filter( 'wp_get_attachment_url', 'iaml_getMediaURLFile' );

function iaml_getMediaURLFile( $url ) {
    $prefix = esc_url( get_option( 'iaml_prefix' ) );
    $directory = wp_upload_dir();
    
    if( strpos( $url, 'IAML-Mapping/' ) )
    	$url = str_replace( $directory['baseurl'] . '/IAML-Mapping/', $prefix . '/', $url );

    return $url;
}


function iaml_adminScript() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-dialog' );
    wp_enqueue_script( 'jquery-ui-tooltip' );
    wp_enqueue_script( 'jquery-ui-tabs' );
    wp_enqueue_script( 'iaml-javascript',  plugin_dir_url( __FILE__ ) . 'js/iaml.js' );
    wp_enqueue_style ( 'iaml-css', plugin_dir_url( __FILE__ ) . 'css/iaml.css' );
    wp_enqueue_style ( 'jquery-ui-css-admin', plugin_dir_url( __FILE__ ) . 'css/jquery-ui-classic.css' );
}


function iaml_media_actions() {
    if( ! is_admin() ) {
        wp_die( 'You are not authorised to view this page.' );
    } else {
        //add_media_page( $page_title, $menu_title, $capability, $menu_slug, $function);
        add_media_page(
            'Internet Archive Media Library',
            'Internet Archive Media Library',
            'upload_files',
            'internet-archive-media-library-management',
            'iaml_media'
        );
        add_action('admin_enqueue_scripts', 'iaml_adminScript');

    }
}

function iaml_media() {
    include ( 'internet-archive-media-management.php' );
}

add_action( 'admin_menu', 'iaml_media_actions' );


function iaml_ajax_post() {
    if( isset( $_POST['mappingFolderNonce'] ) && wp_verify_nonce( $_POST['mappingFolderNonce'], 'mapping-folder-nonce' ) ) {

		$mappingFolder = sanitize_text_field( $_POST['mappingFolder'] );

        $IAMLWebService = new IAMLWeb();
        $message = $IAMLWebService->iaml_saveMappingFolder( $mappingFolder );

        echo $message;
    }
    elseif( isset( $_POST['mappingFileNonce'] ) && wp_verify_nonce( $_POST['mappingFileNonce'], 'mapping-file-nonce' ) ) {

	$fileName = sanitize_text_field( $_POST['mappingFileName'] );
        $description = sanitize_text_field( $_POST['mappingFileDescription'] );

        $IAMLWebService = new IAMLWeb();
        $folder = get_option( 'iaml_prefix' );
        $message = $IAMLWebService->iaml_saveMappingFile( $fileName, $folder, $description);

        echo $message;
    }
	else {
		die( '<div class="error"><p>Security check failed!</p></div>' );
	}

    die();
}

add_action( 'wp_ajax_iaml_action', 'iaml_ajax_post' );
