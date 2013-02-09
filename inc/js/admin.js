/**
 * Functions to Theme Options and Metaboxs.
 */
jQuery(document).ready(function($) {
    /**
     * Image field.
     */
    $(".odin-upload-image-button").click(function() {
        formfield = $(this).siblings(".odin-upload-image");
        preview = $(this).siblings(".odin-preview-image");
        tb_show("", "media-upload.php?type=image&TB_iframe=true");
        window.send_to_editor = function(html) {
            imgurl = $("img",html).attr("src");
            classes = $("img", html).attr("class");
            id = classes.replace(/(.*?)wp-image-/, "");
            formfield.val(id);
            preview.attr("src", imgurl);
            tb_remove();
        }
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
    $(".odin-upload-button").click(function() {
        uploadID = $(this).prev("input");
        formfield = $(this).attr("name");
        tb_show("", "media-upload.php?post_id=&amp;type=image&amp;TB_iframe=true");
        return false;
    });
    window.send_to_editor = function(html) {
        imgurl = $("img", html).attr("src");
        uploadID.val(imgurl);
        tb_remove();
    }

    /**
     * Color Picker.
     */
    $(".odin-color-field").wpColorPicker();
});