jQuery(document).ready(function($)
{
    /*
     * Define jquery tab function
     * */

    $('#tabs').tabs();

    //hover states on the static widgets
    $('#dialog_link, ul#icons li').hover(
        function() {$(this).addClass('ui-state-hover');},
        function() {$(this).removeClass('ui-state-hover');}
    );


    /*
     * Define jquery button function
     * */
    $('#btnSaveMappingFile, #btnSaveMappingFolder').button();

    $('#btnSaveMappingFile').click(function()
    {
        // Show loading animation image
        $('#btnSaveMappingFile').button('disable');
        $('#imgLoadingButton').fadeIn();
        $('#info').fadeOut();

        // Declare data
        var data = {
            action:                 'iaml_action',
            mappingFileName:        $('#mappingFileName').val(),
            mappingFileDescription: $('#mappingFileDescription').val(),
            mappingFileNonce:       $('#mapping-file-nonce').val()
        };

        $.post(ajaxurl, data, function(msg)
        {
            // Hide loading animation image
            $('#btnSaveMappingFile').button('enable');
            $('#imgLoadingButton').fadeOut();
            $('#info').html(msg);
            $('#info').fadeIn();
        });
        return false;
        
    }); // end of button

    $('#btnSaveMappingFolder').click(function()
    {
        // Show loading animation image
        $('#btnSaveMappingFolder').button('disable');
        $('#imgFolderButton').fadeIn();
        $('#info').fadeOut();

        // Declare data
        var data = {
            action:             'iaml_action',
            mappingFolder:      $('#mappingFolder').val(),
            mappingFolderNonce: $('#mapping-folder-nonce').val()
        };

        $.post(ajaxurl, data, function(msg)
        {
            // Hide loading animation image
            $('#btnSaveMappingFolder').button('enable');
            $('#imgFolderButton').fadeOut();
            $('#info').html(msg);
            $('#info').fadeIn();
        });    
        return false;

    }); // end of button


    /*
     * Define jquery tooltips function
     * */
    var tooltips = $( '[title]' ).tooltip({
        position: {
            my: 'left top',
            at: 'right+5 top-5'
        }
    }); // end of tooltips

}); // end of jQuery
