jQuery(document).ready(function ($) {

    $('#owl-logos').owlCarousel({
        margin: 15,
        loop: false,
        items: 5,
        dots: false,
        nav: true,
        rewind:true,
        navText: ["<span class='slide-prev'></span>", "<span class='slide-next'></span>"],
        autoplay: true,
        autoplayTimeout: 6000,
        responsive: {

            0: {
                items: 1,

            },
            480: {
                items: 2,
            },
            767: {
                items: 3,
            },
            992: {
                items: 4,
            },
            1300: {
                items: 5,
            }
        }
    });


});
