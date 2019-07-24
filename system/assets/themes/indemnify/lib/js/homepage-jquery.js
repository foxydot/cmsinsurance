jQuery(document).ready(function($) {
    $('.gallery-slider .gallery .gallery-item').removeClass('gallery-item');
    $('.gallery-slider .gallery').slick({
        autoplay: true,
        arrows: true,
        infinite: true,
        speed: 1000,
        slidesPerRow: 5,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});