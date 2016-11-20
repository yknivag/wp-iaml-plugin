<?php
$currentPath = plugin_dir_url( __FILE__ );
$mappingFolder = get_option( 'iaml_prefix' );
?>

<div id='info' style='display: none'></div>

<!-- Define Tabs -->

<div id='tabs'>
    
    <ul>
        <li><a href='#about'>About</a></li>
        <li><a href='#map-file'>Map File</a></li>
        <li><a href='#updateURLprefix'>Update archive.org URL prefix</a></li>
    </ul>
    
        <div id='about'>
        <h4>Internet Archive Media Library</h4>
        <p>Contributor          : Gavin Smalley<br>
        Requires at least    : Wordpress 3.5<br>
        Tested up to         : Wordpress 4.6<br>
        Version              : 0.1<br>
        License              : GPLv3 or later<br>
        License URI          : http://www.gnu.org/licenses/gpl-3.0.html</p>

        <h5>Description:</h5>
        <p>Mapping file(s) from Internet Archive (archive.org) into Wordpress Media Library.</p>

        <h5>Supported File Types:</h5>
        <ul>
            <li>Any file for general addition.</li>
            <li>JPG/PNG/GIF files for picture meta-data.</li>
            <li>[FUTURE (v1.1)] MP3 files for audio meta-data.</li>
            <li>[FUTURE] More types to be added in due-course.</li>
        </ul>
        
        <h5>Features:</h5>
        <ul>
            <li>Mapping file(s) from Internet Archive into WordPress Media Library.</li>
            <li> Determination of MIME type from file extension (for images and mp3 only).</li>
            <li>Real meta-data added for JPG/PNG/GIF files.</li>
            <li>[FUTURE (v1.1+ as above)] Addition of real meta-data to Wordpress for file where available, or sensible generic meta-data where not.</li>
            <li>[FUTURE (v1.2+ as above)] Option to manually edit the meta-data.</li>
        </ul>
        
        <h5>Required:</h5>
        <ul>
            <li>PHP 5.3.0.</li>
            <li>Wordpress 3.5 or greater.</li>
        </ul>

        <h5>How it works:</h5>
        <ol>
            <li>Upload file(s) to Internet Archive (archive.org).</li>
            <li>Set up IA prefix in Admin >> Media >> Internet Archive Media Library >> URL Prefix.</li>
            <li>Add file name in Wordpress Admin >> Media >> Internet Archive Media Library >> Map File.</li>
            <li>Go to Wordpress Admin >> Media >> Library. Now you can see your Internet Archive file in preview.</li>
        </ol>
        
        <h5>Installation</h5>
        <ol>
            <li>Extract internet-archive-media-library into your WordPress plugins directory (wp-content/plugins).</li>
            <li>Log in to WordPress Admin. Go to the Plugins page and click Activate for Internet Archive Media Library.</li>
            <li>On Wordpress Admin, go to Media => Internet Archive Media Library.</li>
            <li>Follow the instructions.</li>
        </ol>
        
    </div> <!-- end of about tab -->

    <div id='map-file'>
        
        <form id='frmMappingFile' name='frmMappingFile'>
            <p>Plesae Note: This currently only works for jpg, png, gif and mp3 files reliably.  All other file types are added as generic attachments with no mime type or meta-data, future versions will add more supported file types.</p>
            <p>To find the &quot;File Name&quot; go to the Internet Archive and browse to the item you wish to link to, click to view all files attached to the item and then copy the link from the exact file you wish to link to. Paste in the box below all of that link apart from the prefix.</p>
            <p><label for='mappingFileName'>File Name: </label><br>
                <?php echo $mappingFolder ?>/<input type='text' name='mappingFileName' title='Complete the URL (eg: item/file.ext)' size='40' id='mappingFileName'><br>
            <label for='mappingFileDescription'>File Description: </label>
            <input type='text' name='mappingFileDescription' title='eg: file description' size='80' id='mappingFileDescription'><br>
            <?php $mappingFileNonce = wp_create_nonce( 'mapping-file-nonce' ); ?>
            <input type='hidden' name='mapping-file-nonce' id='mapping-file-nonce' value='<?php echo $mappingFileNonce; ?>'>
            <button type='submit' id='btnSaveMappingFile'><?php _e( 'Save' )?>
                <img src='<?php echo $currentPath ?>images/preloader-flat.gif' id='imgLoadingButton' style='display: none;'>
            </button></p>
        </form>
        
    </div> <!-- end of map-file tab -->

    <div id='updateURLprefix'>
        <form id='frmMappingFolder' name='frmMappingFolder'>
            <p><label for='mappingFolder'>Internet Archive URL base: </label>
                <input type='text' id='mappingFolder' name='mappingFolder' value='<?php echo $mappingFolder ?>' title='eg: https://archive.org/download' size='40'> (do not include a trailing slash)<br>
            <?php $mappingFolderNonce = wp_create_nonce( 'mapping-folder-nonce' );?>
                <input type='hidden' name='mapping-folder-nonce' id='mapping-folder-nonce' value='<?php echo $mappingFolderNonce ?>' ><br>
            <button id='btnSaveMappingFolder'><?php _e( 'Save' ) ?>
                <img src='<?php echo $currentPath ?>images/preloader-flat.gif' id='imgFolderButton' style='display: none;'>
            </button></p>
        </form>
    </div> <!-- end of updateURLprefix tab -->

</div> <!-- end of tabs -->
