var minimal_grid_file_frame;

jQuery(function ($) {

    // Uploads.
    jQuery(document).on('click', 'input.select-img', function (event) {

        var $this = $(this);

        event.preventDefault();

        var CustomThemeImage = wp.media.controller.Library.extend({
            defaults: _.defaults({
                id: 'custom-theme-insert-image',
                title: $this.data('uploader_title'),
                allowLocalEdits: false,
                displaySettings: true,
                displayUserSettings: false,
                multiple: false,
                library: wp.media.query({type: 'image'})
            }, wp.media.controller.Library.prototype.defaults)
        });

        // Create the media frame.
        minimal_grid_file_frame = wp.media.frames.minimal_grid_file_frame = wp.media({
            button: {
                text: jQuery(this).data('uploader_button_text')
            },
            state: 'custom-theme-insert-image',
            states: [
                new CustomThemeImage()
            ],
            multiple: false
        });

        // When an image is selected, run a callback.
        minimal_grid_file_frame.on('select', function () {

            var state = minimal_grid_file_frame.state('custom-theme-insert-image');
            var selection = state.get('selection');
            var display = state.display(selection.first()).toJSON();
            var obj_attachment = selection.first().toJSON();
            display = wp.media.string.props(display, obj_attachment);

            var image_field = $this.siblings('.img');
            var imgurl = display.src;

            // Copy image URL.
            image_field.val(imgurl);
            image_field.trigger('change');
            // Show in preview.
            var image_preview_wrap = $this.siblings('.image-preview-wrap');
            var image_html = '<img src="' + imgurl + '" alt="" style="max-width:100%;max-height:200px;" />';
            image_preview_wrap.html(image_html);
            // Show Remove button.
            var image_remove_button = $this.siblings('.btn-image-remove');
            image_remove_button.css('display', 'inline-block');
        });

        // Finally, open the modal.
        minimal_grid_file_frame.open();
    });

    // Remove image.
    jQuery(document).on('click', 'input.btn-image-remove', function (e) {

        e.preventDefault();
        var $this = $(this);
        var image_field = $this.siblings('.img');
        image_field.val('');
        var image_preview_wrap = $this.siblings('.image-preview-wrap');
        image_preview_wrap.html('');
        $this.css('display', 'none');
        image_field.trigger('change');

    });

    /*For Youtube Video Slider Widget*/
    jQuery(document).on('click', ".me_add_youtube_url", function (e) {

        e.preventDefault();
        var template = wp.template('me-youtube-urls');

        /*Add proper name attribute on the html that will be appended*/
        var container = jQuery(this).closest('.widget-content').find('.me-youtube-urls');
        var data_name = container.attr('data-widget-name');
        var html = template({ name: data_name });
        /**/

        container.append( html );
    });

    jQuery( document ).on( 'click', '.me-remove-youtube-url', function(e){
        e.preventDefault();
        jQuery(this).prev('input').trigger('change');
        jQuery(this).parent().remove();
    });
    /**/

});
