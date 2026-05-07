jQuery(document).ready(function ($) {

    // Nav Mobile
    $(".jsNavMobile").click(function () {
        $(".left-menu").toggleClass("left-menu-show");
        $(this).toggleClass("nav-mobile-close");
        $("body").toggleClass("no-scroll");
    });

    // Order logo - open popup modal
    var $modalTitle = null;
    var defaultModalTitle = null;

    $(".jsOrderLogoShow").click(function () {
        // Lazily find the form title heading on first open
        if (!$modalTitle || !$modalTitle.length) {
            $modalTitle = $(".right-menu-wrapper").find("h1, h2, h3, h4").first();
            defaultModalTitle = $modalTitle.text();
        }

        // Replace title with logo name if button carries one, else restore default
        var productName = $(this).data("product-name");
        if (productName) {
            $modalTitle.text(productName);
        } else {
            $modalTitle.text(defaultModalTitle);
        }

        $(".right-menu").addClass("right-menu-show");
        $("body").addClass("no-scroll");
        $(".left-menu").removeClass("left-menu-show");
        $(".jsNavMobile").removeClass("nav-mobile-close");
    });

    // Close modal via X button
    $(".jsRightMenuCLose").click(function () {
        $(".right-menu").removeClass("right-menu-show");
        $("body").removeClass("no-scroll");
    });

    // Close modal by clicking the black overlay (outside the content box)
    $(".right-menu").on("click", function (e) {
        if (!$(e.target).closest(".right-menu-wrapper").length) {
            $(this).removeClass("right-menu-show");
            $("body").removeClass("no-scroll");
        }
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
