<?php
class IAMLWeb
{
    /*
    * Verify nonce for security
    * */
    public function iaml_validateNonce($nonce, $field)
    {
        if (!wp_verify_nonce($nonce, $field)) 
            die('<div class="error"><p>Security check failed!</p></div>');
    }


    /*
    * Save URL Prefix
    * */
    public function iaml_saveMappingFolder($mappingFolder, $nonce, $nonceField)
    {
        
        $this->iaml_validateNonce($nonce, $nonceField);
        $url = $mappingFolder . "/";
        
        if(empty($mappingFolder))
            return "<div class='error'><p>Internet Archive URL prefix is required.</p></div>";

        $mappingFolder = sanitize_text_field($mappingFolder);
        
        if(update_option('iaml_prefix', $mappingFolder))
            return "<div class='updated'><p>Internet Archive URL prefix has been saved successfully.</p></div>";
    }
    
    /*
    * Save Mapping File
    * */
    function iaml_saveMappingFile($fileName, $folder, $description, $nonce, $nonceField)
    {
        $this->iaml_validateNonce($nonce, $nonceField);
        
        // Verify Google Drive mapping folder
        if(empty($folder))
            return "<div class='error'><p>Please set up Internet Archive URL prefix before mapping a file.</p></div>";
        
        // Verify file name
        if(empty($fileName))
            return "<div class='error'><p>File name is required.</p></div>";
        
        $filePath = "IAML-Mapping/" . $fileName;
        $fullFile = $prefix . "/" .$fileName;
        $fileExt = pathinfo(basename($fileName), PATHINFO_EXTENSION);
        $fileType = wp_check_filetype(basename($fileName), null);
        $fileMime = $fileType['type'];
        
        switch ($fileExt) {
            case 'jpg':
            case 'JPG':
            case 'jpeg':
            case 'JPEG':
            case 'png':
            case 'PNG':
            case 'gif':
            case 'GIF':
                $imageSize = getimagesize($fullFile);
                $imageWidth = $imageSize[0];
                $imageHeight = $imageSize[1];
                //$fileMime = $imageSize["mime"];
                
                $sizes = array();
                $keywords = array();
                
                $meta = array(
                    'aperture' => 0,
                    'credit' => '',
                    'camera' => '',
                    'caption' => $description,
                    'created_timestamp' => 0,
                    'copyright' => '',
                    'focal_length' => 0,
                    'iso' => 0,
                    'shutter_speed' => 0,
                    'title' => $description,
                    'orientation' => 0,
                    'keywords' => $keywords
                );
                
                $metadata = array(
                    'image_meta' => $meta,
                    'sizes' => $sizes,
                    'width' => $imageWidth,
                    'height' => $imageHeight,
                    'file' => $filePath,
                    'IAML' => TRUE
                );
                
                break;
            
            case 'mp3':
            case 'MP3':
                //$fileMime = "audio/mpeg";
                
                $metadata = array(
                    'dataformat' => 'mp3',
                    'channels' => 2,
                    'sample_rate' => 0,
                    'bitrate' => 0,
                    'channelmode' => 'joint stereo',
                    'bitrate_mode' => '',
                    'codec' => '',
                    'encoder' => '',
                    'lossless' => '',
                    'encoder_options' => '',
                    'compression_ratio' => '',
                    'fileformat' => 'mp3',
                    'filesize' => 0,
                    'mime_type' => $fileType,
                    'length' => 0,
                    'length_formatted' => '',
                    'encoder_settings' => '',
                    'title' => $description,
                    'year' => '',
                    'artist' => '',
                    'album' => '',
                    'IAML' => TRUE
                );
                
                break;
                
            default:
                //$fileMime = "text/plain";
                $metadata = array('IAML'=>TRUE);
                break;
        }

        //Check removed as takes too long for large files, will re-write with a curl routine.
        //if (@fclose(@fopen($fullFile,"r")))
        //{
        
            $attachment = array(
                'post_mime_type' => $fileMime,
                'guid' => $filePath,
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($fileName)),
                'post_content' => $description,
                'post_status'    => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $filePath, 0);

            if(wp_update_attachment_metadata($attach_id, $metadata)) {
                return "<div class='updated'><p>File {$fileName} has been saved successfully.</p></div>";
            }
        //}
        //else {
            //return "<div class='error'><p>File {$fileName} does not exist.</p></div>";
        //}
    }
    
} // end of class
?>
