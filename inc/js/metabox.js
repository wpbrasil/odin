jQuery(document).ready(function($) {
    /**
     * Image field.
     */
    $(".odin_upload_image_button").click(function() {
        formfield = $(this).siblings(".odin_upload_image");
        preview = $(this).siblings(".odin_preview_image");
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

    $(".odin_clear_image_button").click(function() {
        var defaultImage = $(this).parent().siblings(".odin_default_image").text();
        $(this).parent().siblings(".odin_upload_image").val("");
        $(this).parent().siblings(".odin_preview_image").attr("src", defaultImage);
        return false;
    });
});