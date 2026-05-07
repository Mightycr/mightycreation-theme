jQuery(document).ready(function ($) {

    // Nav Mobile
    $(".jsNavMobile").click(function () {
        $(".left-menu").toggleClass("left-menu-show");
        $(this).toggleClass("nav-mobile-close");
        $("body").toggleClass("no-scroll");
    });

    // Order logo - open right panel
    $(".jsOrderLogoShow").click(function () {
        $(".right-menu").addClass("right-menu-show");
        $("body").addClass("no-scroll");
        $(".left-menu").removeClass("left-menu-show");
        $(".jsNavMobile").removeClass("nav-mobile-close");
    });

    $(".jsRightMenuCLose").click(function () {
        $(".right-menu").removeClass("right-menu-show");
        $("body").removeClass("no-scroll");
    });

});


jQuery(window).load(function () {
    // Smooth fade-out of loading page, then stagger-animate article cards
    jQuery('#loading-page').fadeOut(700, function () {
        jQuery(this).remove();

        jQuery('.article-item').each(function (i) {
            var $item = jQuery(this);
            setTimeout(function () {
                $item.addClass('article-item-visible');
            }, i * 90);
        });
    });
});
