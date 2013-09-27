jQuery(document).ready(function($) {
    // fitVids.
    $(".entry-content").fitVids();

    // Responsive wp_video_shortcode().
    $(".wp-video-shortcode").parent("div").css("width", "auto");

    /**
     * Odin Core shortcodes
     */
    $(".odin-tabs a").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
    });

});
