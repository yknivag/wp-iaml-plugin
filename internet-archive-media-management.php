<?php
$currentPath = plugin_dir_url(__FILE__);
$mappingFolder = get_option('iaml_prefix');
?>

<div id="info" style="display: none"></div>

<!--
Define Tabs
-->
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">About</a></li>
        <li><a href="#tabs-2">Map File</a></li>
        <li><a href="#tabs-3">Update archive.org URL prefix</a></li>
    </ul>
    
        <div id="tabs-1" style="background: whitesmoke;">
        <h4>Internet Archive Media Library</h4>
        Contributor          : Gavin Smalley<br>
        Requires at least    : Wordpress 3.5<br>
        Tested up to         : Wordpress 4.6<br>
        Version              : 1.0<br>
        License              : GPLv2 or later<br>
        License URI          : http://www.gnu.org/licenses/gpl-2.0.html<br>
        <p>Description:<br>
        Allows mapping file(s) from Internet Archive (archive.org) into the Wordpress Media library.
        </p>

        <p>Features:<br>
        - Mapping file(s) from Internet Archive (archive.org) into the Wordpress Media library.<br>
        - Attach Internet Archive (archive.org) files to Wordpress posts.<br>
        </p>

        <p>Required:<br>
        - PHP 5.3.0</p>
        
        <p>How it works:
		<ol>
			<li>Upload a file(s) to Internet Archive (archive.org).</li>
			<li>Set up IA prefix in Admin >> Media >> Internet Archive Media Library >> URL Prefix.</li>
			<li>Add file name in Wordpress Admin >> Media >> Internet Archive Media Library >> Map File.</li>
			<li>Go to Wordpress Admin >> Media >> Library. Now you can see your Internet Archive file in preview.</li>
		</ul>
        </p>
    </div> <!-- end of tab 1 -->

    <div id="tabs-2">
        <form id="frmMappingFile" name="frmMappingFile" method="post" action="<?php echo $currentPath ?>includes/process.php">
        <table>
            <tr>
                <td>File Name</td>
                <td>:</td>
                <td>
                    <input type="text" name="mappingFileName" title="eg: file.jpg" size="40" id="mappingFileName">
                </td>
            </tr>
            <tr>
                <td>File Description</td>
                <td>:</td>
                <td>
                    <input type="text" name="mappingFileDescription" title="eg: file description" size="80" id="mappingFileDescription">
                </td>
            </tr>
        </table>

        <?php $mappingFileNonce = wp_create_nonce( "mapping-file-nonce" ); ?>
        <input type="hidden" name="mapping-file-nonce" id="mapping-file-nonce" value="<?php echo $mappingFileNonce ?>">

        <p style="margin-left: 120px;">
            <button type="submit" id="btnSaveMappingFile"><?php _e('Save')?>
                <img src="<?php echo $currentPath ?>images/preloader-flat.gif" id="imgLoadingButton" style="display: none;">
            </button>
        </p>
        </form>
    </div> <!-- end of tab 2 -->

    <div id="tabs-3">
        <form id="frmMappingFolder" name="frmMappingFolder">
        <table>
            <tr>
                <td>Internet Archive URL base</td>
                <td>:</td>
                <td>
                    <input type="text" id="mappingFolder" name="mappingFolder" value="<?php echo $mappingFolder ?>"
                        title="eg: https://archive.org/download" size="40">
                </td>
            </tr>
        </table>

        <?php $mappingFolderNonce = wp_create_nonce( "mapping-folder-nonce" );?>
        <input type="hidden" name="mapping-folder-nonce" id="mapping-folder-nonce" value="<?php echo $mappingFolderNonce ?>" >
        <p style="margin-left:140px;">
            <button id="btnSaveMappingFolder"><?php _e('Save') ?>
                <img src="<?php echo $currentPath ?>images/preloader-flat.gif" id="imgFolderButton" style="display: none;">
            </button>
        </p>
        </form>
    </div> <!-- end of tab 3 -->

</div> <!-- end of tabs -->
