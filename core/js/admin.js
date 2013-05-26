/*global odin_admin_params */

/**
 * Theme Options and Metaboxes.
 */
jQuery(document).ready(function($) {
    // Stores the original information of the send_to_editor().
    var default_send_to_editor = window.send_to_editor;

    /**
     * Image field.
     */
    $(".odin-upload-image-button").on('click', function() {
        formfield = $(this).siblings(".odin-upload-image");
        preview = $(this).siblings(".odin-preview-image");
        tb_show("", "media-upload.php?type=image&TB_iframe=true");

        // Restore send_to_editor() when tb closed.
        $("#TB_window").bind('tb_unload', function() {
            window.send_to_editor = default_send_to_editor;
        });

        window.send_to_editor = function(html) {
            imgurl = $("img", html).attr("src");
            classes = $("img", html).attr("class");
            id = classes.replace(/(.*?)wp-image-/, "");
            formfield.val(id);
            preview.attr("src", imgurl);
            tb_remove();
        };

        return false;
    });

    $(".odin-clear-image-button").click(function() {
        var defaultImage = $(this).parent().siblings(".odin-default-image").text();

        $(this).parent().siblings(".odin-upload-image").val("");
        $(this).parent().siblings(".odin-preview-image").attr("src", defaultImage);

        return false;
    });

    /**
     * Upload.
     */
    $(".odin-upload-button").on('click', function() {
        uploadID = $(this).prev("input");
        formfield = $(this).attr("name");
        tb_show("", "media-upload.php?post_id=&amp;type=image&amp;TB_iframe=true");

        // Restore send_to_editor() when tb closed.
        $("#TB_window").bind('tb_unload', function() {
            window.send_to_editor = default_send_to_editor;
        });

        window.send_to_editor = function(html) {
            imgurl = $("img", html).attr("src");
            uploadID.val(imgurl);
            tb_remove();
        };

        return false;
    });

    /**
     * Color Picker.
     */
    $(".odin-color-field").wpColorPicker();

    /**
     * Image plupload adds.
     */
    $(".odin-gallery-container").on("click", ".odin-gallery-add", function(e) {
        e.preventDefault();

        var gallery_frame,
            gallery_wrap = $(this).parent(".odin-gallery-container");
            image_gallery_ids = $(".odin-gallery-field", gallery_wrap),
            images = $("ul.odin-gallery-images", gallery_wrap),
            attachment_ids = image_gallery_ids.val();

        // If the media frame already exists, reopen it.
        if (gallery_frame) {
            gallery_frame.open();

            return;
        }

        // Create the media frame.
        gallery_frame = wp.media.frames.downloadable_file = wp.media({
            title: odin_admin_params.gallery_title,
            button: {
                text: odin_admin_params.gallery_button
            },
            multiple: true
        });

        // When an image is selected, run a callback.
        gallery_frame.on("select", function() {

            var selection = gallery_frame.state().get("selection");

            selection.map(function(attachment) {

                attachment = attachment.toJSON();

                if (attachment.id) {
                    attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                    images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment.url + '" /><ul class="actions"><li><a href="#" class="delete" title="' + odin_admin_params.gallery_remove + '">X</a></li></ul></li>');
                }

            });

            image_gallery_ids.val(attachment_ids);
        });

        // Finally, open the modal.
        gallery_frame.open();
    });

    /**
     * Image plupload ordering.
     */
    $(".odin-gallery-container").on("mouseover", "ul.odin-gallery-images", function() {
        var gallery_wrap = $(this).parent(".odin-gallery-container"),
            image_gallery_ids = $(".odin-gallery-field", gallery_wrap);

        // Call the sortable action.
        $(this).sortable({
            items: "li.image",
            cursor: "move",
            scrollSensitivity: 40,
            forcePlaceholderSize: true,
            forceHelperSize: false,
            helper: "clone",
            opacity: 0.65,
            placeholder: "wc-metabox-sortable-placeholder",
            start: function(event, ui) {
                ui.item.css("background-color","#f6f6f6");
            },
            stop: function(event, ui) {
                ui.item.removeAttr("style");
            },
            update: function(event, ui) {
                var attachment_ids = "";

                // Gets the current ids.
                $("li.image", $(this)).css("cursor", "default").each(function() {
                    var attachment_id = $(this).attr("data-attachment_id");
                    attachment_ids = attachment_ids + attachment_id + ",";
                });

                // Return the new value.
                image_gallery_ids.val(attachment_ids);
            }
        });
    });

    /**
     * Image plupload remove link.
     */
    $(".odin-gallery-container").on("click", "a.delete", function(e) {
        e.preventDefault();

        var gallery_wrap = $(this).parents(".odin-gallery-container"),
            image_gallery_ids = $(".odin-gallery-field", gallery_wrap);

        // Remove the item.
        $(this).closest("li.image").remove();

        var attachment_ids = "";

        // Gets the current ids.
        $("ul li.image", gallery_wrap).css("cursor","default").each(function() {
            var attachment_id = $(this).attr("data-attachment_id");
            attachment_ids = attachment_ids + attachment_id + ",";
        });

        // Return the new value.
        image_gallery_ids.val(attachment_ids);
    });
});