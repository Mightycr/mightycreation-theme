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
        if (!$modalTitle || !$modalTitle.length) {
            $modalTitle = $(".right-menu-wrapper").find("h1, h2, h3, h4").first();
            defaultModalTitle = $modalTitle.text();
        }
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

    // Close modal by clicking the black overlay
    $(".right-menu").on("click", function (e) {
        if (!$(e.target).closest(".right-menu-wrapper").length) {
            $(this).removeClass("right-menu-show");
            $("body").removeClass("no-scroll");
        }
    });

    // Hero: hide on CTA click, show again on scroll up
    var $hero = $("#site-hero");
    if ($hero.length) {
        var heroVisible = true;
        var heroLastScroll = 0;

        $("#hero-cta").on("click", function (e) {
            e.preventDefault();
            $hero.slideUp(500);
            heroVisible = false;
        });

        $(".main").on("scroll.hero", function () {
            var st = $(this).scrollTop();
            if (st < heroLastScroll && !heroVisible) {
                $hero.slideDown(400);
                heroVisible = true;
            }
            heroLastScroll = st <= 0 ? 0 : st;
        });
    }

    // Grid toggle: switch between 3 and 4 columns
    $(document).on("click", ".grid-toggle", function () {
        var cols = parseInt($(this).data("cols"), 10);
        $(".grid-toggle").removeClass("active");
        $(this).addClass("active");
        var $items = $(".product-item-wrap");
        var $grid  = $("#product-grid");
        if (cols === 4) {
            $items.removeClass("col-lg-4").addClass("col-lg-3");
            $grid.addClass("grid-4cols");
        } else {
            $items.removeClass("col-lg-3").addClass("col-lg-4");
            $grid.removeClass("grid-4cols");
        }
    });

});


jQuery(window).load(function () {
    jQuery('#loading-page').fadeOut(700, function () {
        jQuery(this).remove();
        jQuery('.article-item').each(function (i) {
            var $item = jQuery(this);
            setTimeout(function () {
                $item.addClass('article-item-visible');
            }, i * 90);
        });
    });

    jQuery(document).on('click', '.industry-filter-btn', function() {
        var filter = jQuery(this).data('filter');
        jQuery('.industry-filter-btn').removeClass('active');
        jQuery(this).addClass('active');
        if (filter === 'all') {
            jQuery('.product-item-wrap').show();
        } else {
            jQuery('.product-item-wrap').each(function() {
                var tags = (jQuery(this).data('tags') || '').split(' ');
                jQuery(this).toggle(tags.indexOf(filter) !== -1);
            });
        }
    });
});