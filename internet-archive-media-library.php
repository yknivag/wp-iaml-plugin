<?php
/*
    Plugin Name: Internet Archive Media Library
    Plugin URI: 
    Description: Mapping file from Internet Archive (archive.org) into Wordpress Media. [Based on Google Drive Media Library by Felix Wei]
    Author: Gavin Smalley
    Version: 1.0
    Author URI: http://www.gavinsmalley.co.uk/
    License: GNU General Public License v2.0 or later
    License URI: http://www.opensource.org/licenses/gpl-license.php
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


require_once ('includes/class-IAMLWeb.php');

function iaml_install() {
    $defaultPrefix = 'https://archive.org/download';
    update_option('iaml_prefix', $defaultPrefix);
}
register_activation_hook( __FILE__, 'iaml_install');

add_filter('wp_get_attachment_url', 'iaml_getMediaURLFile');
function iaml_getMediaURLFile($url)
{
    $prefix = get_option('iaml_prefix');
    $directory = wp_upload_dir();
    
    if(strpos($url, 'IAML-Mapping/'))
    	$url = str_replace($directory['baseurl'] . '/IAML-Mapping/', $prefix . '/', $url);

    return $url;
}


function iaml_adminScript()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-tooltip');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('iaml-javascript',  plugin_dir_url(__FILE__) . 'js/iaml.js');
    wp_enqueue_style ('iaml-css', plugin_dir_url(__FILE__) . 'css/iaml.css');
    wp_enqueue_style ('jquery-ui-css-admin', plugin_dir_url( __FILE__ ) . 'css/jquery-ui-classic.css' );
}


function iaml_media_actions()
{
    if(!is_admin()) 
        wp_die('You are not authorised to view this page.');
    else 
    {
        add_media_page(
            'Internet Archive Media Library',
            'Internet Archive Media Library',
            1,
            'internet-archive-media-library-management',
            'iaml_media'
        );
        add_action('admin_enqueue_scripts', 'iaml_adminScript');

    }
}

function iaml_media()
{
    include ('internet-archive-media-management.php');
}

add_action('admin_menu', 'iaml_media_actions');


function iaml_ajax_post()
{
    if(isset($_POST['mappingFolderNonce']))
    {
        $IAMLWebService = new IAMLWeb();
        $message = $IAMLWebService->iaml_saveMappingFolder($_POST['mappingFolder'], 
            $_POST['mappingFolderNonce'], 'mapping-folder-nonce');
        echo $message;
    }

    if(isset($_POST['mappingFileNonce']))
    {
        $IAMLWebService = new IAMLWeb();
        $folder = get_option('iaml_prefix');
        $message = $IAMLWebService->iaml_saveMappingFile($_POST['mappingFileName'], $folder, $_POST['mappingFileDescription'],
            $_POST['mappingFileNonce'], 'mapping-file-nonce');
        echo $message;
    }

    die();
}

add_action('wp_ajax_iaml_action', 'iaml_ajax_post');
