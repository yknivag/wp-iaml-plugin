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
    * Save Mapping Folder
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

        if (@fclose(@fopen($fullFile,"r")))
        {
            $imageSize = getimagesize($fullFile);
            $imageWidth = $imageSize[0];
            $imageHeight = $imageSize[1];
            $fileType = $imageSize["mime"];
    
            $meta = array('aperture' => 0, 'credit' => '', 'camera' => '', 'caption' => $fileName, 'created_timestamp' => 0,
                'copyright' => '', 'focal_length' => 0, 'iso' => 0, 'shutter_speed' => 0, 'title' => $fileName);

            $attachment = array('post_mime_type' => $fileType, 'guid' => $filePath,
                'post_parent' => 0,	'post_title' => $fileName, 'post_content' => $description);

            $attach_id = wp_insert_attachment($attachment, $filePath, 0);
    
            $metadata = array("image_meta" => $meta, "width" => $imageWidth, "height" => $imageHeight,
                "file" => $filePath, "IAML" => TRUE);

            if(wp_update_attachment_metadata( $attach_id,  $metadata))
                return "<div class='updated'><p>File {$fileName} has been saved successfully.</p></div>";
        }
        else
            return "<div class='error'><p>File {$fileName} does not exist.</p></div>";
    }
    
} // end of class
?>
