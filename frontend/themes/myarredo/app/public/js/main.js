// Global Scoupe
// Функция для инициализации range-sliders для фильтров
function rangeInit() {
    // если нужный элемент присутствует на странице
    if ($('.myarredo-slider').length > 0) {
        // проходимся по ним
        var allSlides = document.getElementsByClassName('myarredo-slider');
        $(allSlides).each(function(i, elem) {
            var minInput = $(elem).next('.filter-slider-box').children('.cur.min').children('input[type="text"]');
            var maxInput = $(elem).next('.filter-slider-box').children('.cur.max').children('input[type="text"]');
            if (minInput.val() == maxInput.val()) {
                maxInput.val(maxInput.val() + 1);
            }
            if (allSlides[i] != null) {
                noUiSlider.create(allSlides[i], {
                    start: [Number($(allSlides[i]).attr('data-min')), Number($(allSlides[i]).attr('data-max'))],
                    connect: true,
                    animate: true,
                    animationDuration: 300,
                    range: {
                        'min': Number(minInput.attr('data-default')),
                        'max': Number(maxInput.attr('data-default'))
                    },
                    format: wNumb({
                        decimals: 0
                    })

                });

                allSlides[i].noUiSlider.on('update', function () {
                    var arrResult = allSlides[i].noUiSlider.get();
                    minInput.val(arrResult[0]);
                    maxInput.val(arrResult[1]);
                });

                minInput.change(function () {
                    allSlides[i].noUiSlider.set([$(this).val(), maxInput.val()]);
                });

                maxInput.change(function () {
                    allSlides[i].noUiSlider.set([minInput.val(), $(this).val()]);
                });
            }
        });
    }


}

// Функция для отслеживания и открития элементов фильтров в которых выбран хоть один элемент
function runDesctop() {
  
    setTimeout(function () {
        // Запускаем цыкл по всем элементам всех фильтров
        $('.filters').find('.one-filter').find('.list-item').children('a').each(function (i, elem) {
            // Если обнаруживаем выбраный элемент в фильтре
            if ($(elem).hasClass('selected')) {
                // оставляем фильтр открытым
                $(elem).closest('.one-filter').addClass('open');
            }
        });
    }, 500);

    if ($('.js-numbers').hasClass('slick-slider')) {
        $('.js-numbers').slick('unslick');
    }
    if ($('.best-price .right-part').hasClass('slick-slider')) {
        $('.best-price .right-part').slick('unslick');
    }
}
// Функция для инициализации слайдера композиций
function initCompSlider() {
    
}

// Функция для открития первого элемента по умолчанию в модалке - показать фабрики 
function selectFirstFEl() {
    if ($(".alphabet-tab a").length > 0) {
        $(".alphabet-tab a").eq(0).trigger("click"); //показываем первый элемент по умолчанию
    }
}

// Функция для инициализации слайдеров - Варианты отделки и Композиции
function slickInit() {
    if ($("#panel2 .row").length > 0) {
        $("#panel2 .row").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            nextArrow: "<a href=javascript:void(0) class='fa fa-angle-left'></a>",
            prevArrow: "<a href=javascript:void(0) class='fa fa-angle-right'></a>",
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 540,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
    if ($('#comp-slider').length > 0) {
        $('#comp-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            // autoplay: true,
            prevArrow: '<a href=javascript:void(0) class="slick-prev fa fa-angle-left"></a>',
            nextArrow: '<a href=javascript:void(0) class="slick-next fa fa-angle-right"></a>', 
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 540,
                    arrows: false,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        setTimeout(function() {
            $('#comp-slider').slick('slickNext');
        }, 300);
    }

}

$(document).ready(function () {

    // удаляем прелоадер
    $('#preload_box').hide();

    // инициализация LazyLoad
    var lazyLoadInstance = new LazyLoad({
        elements_selector: ".lazy"

    });

    // footer custom-lazy init
    if ($('.custom-lazy').length > 0) {
        setTimeout(function () {
            var custlazyUrl = $('.custom-lazy').attr('data-background');
            $('.custom-lazy').css('background-image', 'url(' + custlazyUrl + ')');
        }, 1000);
    }

    // for hide h1 for about page
    (function () {
        if ($('.about-container').length > 0 && $('.about-presents-titlebox').length > 0) {
            $('.about-container').find('.about-title').slideUp();
        }
    })();

    // Smooth scrols (W3C recomended)
    // Функционал плавного скрола по рекомендациям W3C
    // можно добавлять новые ссылки через запятую
    $(".totopbox a").on('click', function (event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 900, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
    $(window).scroll(function (ev) {
        // add to top button
        if ($(this).scrollTop() > 500) {
            $('.totopbox').show();
        } else {
            $('.totopbox').hide();
        }
    });

    var state = {
        _device: "",
        _mobInit: function () {
            runMobile();
        },
        _tabletInit: function () {
            runTablet();
        },
        _descInit: function () {
            runDesctop();
        },
        _preWindowWidth: $(window).width(),
        _windowIncreases: function () {
            if (state._preWindowWidth > $(window).width()) {
                state._preWindowWidth = $(window).width();
                return false;
            } else if (state._preWindowWidth < $(window).width()) {
                state._preWindowWidth = $(window).width();
                return true;
            }
        }
    };

    (function ($) {
        $.fn.getDevice = function (braikPointMob, braikPointTablet) {
            Object.defineProperty(state, "device", {

                get: function () {
                    return this._device;
                },

                set: function (value) {
                    this._device = value;
                    if (value == "desctop") {
                        state._descInit();

                    } else if (value == "tablet") {
                        state._tabletInit();
                    } else if (value == "mobile") {
                        state._mobInit();
                    }
                }
            });

            $(this).on("resize load", function () {
                if ($(this).width() < braikPointMob && state.device != "mobile") {
                    state.device = "mobile";
                } else if ($(this).width() > braikPointMob && $(this).width() < braikPointTablet && state.device != "tablet") {
                    state.device = "tablet";
                } else if ($(this).width() > braikPointTablet && state.device != "desctop") {
                    state.device = "desctop";
                }
            });
        };
    })(jQuery);

    $(window).getDevice(540, 768);

    //console.log(state.device);

    function runMobile() {
        //console.log('mobile');
        //Слайдер с номерками
        $('.js-numbers').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true
        });
        $('.best-price .right-part').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true
        });
        /*--конец Главная--*/
    }

    function runTablet() {
        //console.log('tablet');
        //$('.filters .one-filter').removeClass('open');
        if ($('.js-numbers').hasClass('slick-slider')) {
            $('.js-numbers').slick('unslick');
        }
        if ($('.best-price .right-part').hasClass('slick-slider')) {
            $('.best-price .right-part').slick('unslick');
        }
    }

    (function () {
        // Запускаем цыкл по всем элементам всех фильтров
        $('.filters').find('.one-filter').find('.list-item').children('a').each(function (i, elem) {
            // Если обнаруживаем выбраный элемент в фильтре
            if ($(elem).hasClass('selected')) {
                // оставляем фильтр открытым
                $(elem).closest('.one-filter').addClass('open');
            }
        });
    })();

    /*--Конец определения девайса--*/

    /*--Открыть/закрыть города--*/
    (function () {
        $('#select-city,#close-top').click(function () {
            $('.city-select-cont').slideToggle(500);
        });
    })();
    /*--конец Открыть закрыть города--*/

    /*--Слайдер Главная--*/
    $('#home-slider').carousel({});
    /*--конец Слайдер Главная--*/

    /*--Слайдер новинки--*/
    $('#novelties-slider').carousel({});
    /*--конец Слайдер новинки--*/

    /*--Слайдер новинки--*/
    $('#sale-slider').carousel({});
    /*--конец Слайдер новинки--*/

    /*--Слайдер новинки--*/
    $('#reviews-slider').carousel({});
    /*--конец Слайдер новинки--*/


    // Instantiate the Bootstrap carousel
    $('.multi-item-carousel').carousel({
        interval: false
    });

// for every slide in carousel, copy the next slide's item in the slide.
// Do the same for the next, next item.
    $('.multi-item-carousel .item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
            //console.log(next);
        }

        next.children(':first-child').clone().appendTo($(this));
        next.next().children(':first-child').clone().appendTo($(this));
        if (next.next().length > 0) {
            next.next().next().children(':first-child').clone().appendTo($(this));
        } else {
            $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
        }
    });

    $('#rec-prod-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        prevArrow: '<a href=javascript:void(0) class="slick-prev fa fa-angle-left"></a>',
        nextArrow: '<a href=javascript:void(0) class="slick-next fa fa-angle-right"></a>',
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    /*--Изменение вида в каталоге--*/
    (function () {
        $('.location-buts > a').click(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            if ($(this).attr('data-style') == 'large') {
                $(this).closest('.cont-area').addClass('large-tiles');
            } else {
                $(this).closest('.cont-area').removeClass('large-tiles');
            }
        });
    })();
    /*--конец Изменение вида в каталоге--*/

    /*--Ползунок каталог--*/
    rangeInit();
    /*--конец ползунок--*/

    /*--Открыть\закрыть категорию в каталоге--*/
    $(document).on('click', '.filt-but', function () {
        var parent = $(this).parent('.one-filter');
        if (parent.hasClass('open')) {
            parent.removeClass('open');
            parent.find('.list-item').slideUp();
        } else {
            parent.addClass('open');
            parent.find('.list-item').slideDown();
        }
        //parent.find('.list-item').slideToggle();
    });

    /*--конец Открыть\закрыть категорию в каталоге--*/

    // js for default close filters for mobile and tablets
    function closeFilter() {
        if ($(window).width() < 992) {
            setTimeout(function () {
                $('#catalog_filter').children('.one-filter').removeClass('open');
            }, 1000);
        }
    }

    closeFilter();

    $('.factory-page .view-all').click(function () {
        $(this).parent('.all-list').find('.post-list').slideToggle();
    });

    /*--Блокнот--*/
    $(".notebook-page .basket-item-info").each(function (i, item) {
        if (i > 2) {
            $(item).hide();
        }
    });
    $(".notebook-page .show-all").click(function () {
        $(".basket-item-info").show();
        $(this).remove();
    });


    $('.notebook-page').find('.basket-item-info').on('mouseenter', '.read-more', function (e) {
        var item = $(this).closest('.basket-item-info');
        var itemHeight = item.outerHeight();
        item.addClass("read-more");
        item.css('min-height', itemHeight + 'px');
    });
    $('.notebook-page').find('.basket-item-info').on('mouseleave', function (e) {
        var item = $(this);
        var cartbutton = $('.notebook-page').find('.basket-item-info').find('.read-more');
        if (!cartbutton.is(e.target)) {
            item.removeClass("read-more");
        }
    });


    /*--конец Блокнот--*/

    /*--открыть/закрыть заказ (кабинет фабрики)--*/
    $(".manager-history-list .orders-title-block").click(function () {
        var item = $(this).closest(".item");
        item.toggleClass("open");
        item.siblings().removeClass("open");
        item.siblings().find(".hidden-order-info").slideUp();
        item.find(".hidden-order-info").slideToggle();
        if (typeof item.attr("data-hash") !== "undefined") {
            var hash = item.attr("data-hash");
            window.location.hash = hash;
        }
    });

    window.onload = function () {
        if (window.location !== "") {
            var hash = window.location.hash.replace("#", "");
            var el = $('[data-hash="' + String(hash) + '"]');
            if (el.length) {
                var top = el.offset().top;
                $("html,body").animate({"scrollTop": top}, 100);
                el.click();
            }
        }
    };

    if (window.location.hash !== "") {
        var itemHash = window.location.hash.replace("#", "");
        $("[data-hash='" + itemHash + "']").find(".orders-title-block").click();
    }
    /*--конец открыть/зыкрыть заказ (кабинет фабрики)--*/

    /*--поиск по списку (кабинет фабрики)--*/
    $(".drop-down-find .find").on("input", function () {
        var In = $(this).val();
        var dropDown = $(this).closest('.drop-down-find').find('li a');
        dropDown.each(function (i, item) {
            if ($(item).text().indexOf(In) !== 0) {
                $(item).parent().hide();
            } else {
                $(item).parent().show();
            }
        });
    });
    $(".drop-down-find li a").click(function () {
        var parent = $(this).closest(".arr-drop");
        var text = $(this).text();
        parent.find(".dropdown-toggle").text(text);
    });
    $(".arr-drop .dropdown-toggle").click(function () {
        var parent = $(this).closest(".arr-drop");
        parent.find(".find").val("");
        parent.find(".drop-down-find li").show();
    });
    /*--конец поиск по списку (кабинет фабрики)--*/

    /*--Активация табов в карточке--*/
    $(".prod-card-page .nav-tabs li a").eq(0).click();
    /*--конец Активация табов в карточке--*/

    $(".list-cities label").click(function () {
        $(this).parent().find('input[type="checkbox"]').click();
    });

    $(".categoty-page .one-item-check").click(function () {
        location.href = $(this).attr("href");
    });

    $(".dropdown-menu a").click(function () {
        var href = $(this).attr('href');
        window.location.href = href;
    });

    $(".show-all-sub").click(function () {
        var list = $(this).siblings(".list-item");
        var variant = $(this).attr("data-variant");
        var textCont = $(this).find(".btn-text");

        if (list.hasClass('show')) {
            list.removeClass('show');
            $(this).attr("data-variant", textCont.text());
            $(this).addClass('show-class');
            textCont.text(variant);
        } else {
            list.addClass('show');
            $(this).attr("data-variant", textCont.text());
            $(this).removeClass('show-class');
            textCont.text(variant);
        }
    });

    (function () {

        var selItemIn = $(".list-item > .one-item-check.selected");

        selItemIn.each(function (i, item) {
            var parent = $(item).closest(".list-item");
            parent.prepend($(item));
        });

    })();

    slickInit();
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $("#panel2 .row").slick('unslick');
        $('#comp-slider').slick('unslick');
        slickInit();
    });

    $('.std-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        prevArrow: '<a href=javascript:void(0) class="slick-prev fa fa-angle-left"></a>',
        nextArrow: '<a href=javascript:void(0) class="slick-next fa fa-angle-right"></a>',
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 540,
                arrows: false,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    /*--Галерея Карточка товара--*/
    $(document).ready(function () {
        $("a.fancyimage").fancybox();
    });
    /*--конец Галерея Карточка товара --*/

    /*--модалка варианты отделки*/
    $(document).on('click', '.composition .show-modal', function(e) {
        e.preventDefault();
        var img = $(this).clone();
        $('#decoration-modal .image-container').html("").append(img);
        $('#decoration-modal').modal();
    });
    /*--конец модалка варианты отделки*/

    /*--больше фабрик модалка--*/
    $(document).on('click', '.alphabet-tab a', function () {
        $(this).siblings().removeClass("active");
        $(this).addClass("active");

        var actTab = $(this).text();
        var actShow = $("[data-show=" + actTab + "]").show();
        actShow.siblings().hide();
        actShow.css({
            "display": "flex"
        });
    });
    /*--конец Больше фабрик модалка--*/

    $(".img-zoom").click(function () {
        $("#prod-slider .item.active .fancyimage").click();
    });

    if ($(".carousel-indicators li").length == 1) {  //Скрываем стрелки если только одна картинка в слайдере
        $(".nav-contr").hide();
    }

    // $("#novelties-slider .item img").each(function (i, item) {
    //     var src = $(item).attr("src");
    //     $(item).css({"opacity": "0"});
    //     $(item).parent().css({"background-image": "url(" + src + ")"});
    // });

    if ($(".text-col").text().trim() == "") {
        $(".text-col").closest(".text-description").remove();
    }

    $("[data-toggle='tooltip']").tooltip({html: true});

    $(document).on('click', '.link-composition', function() {
        if ($('#comp-slider').length > 0) {
            setTimeout(function() {
                $('#comp-slider').slick('slickNext');
            }, 100);
        }
    });
});
(function () {
    var loaderTemplate =
        '<div class="loader" style="display: none;">' +
        '<div id="floatingCirclesG">' +
        '<div class="f_circleG" id="frotateG_01"></div>' +
        '<div class="f_circleG" id="frotateG_02"></div>' +
        '<div class="f_circleG" id="frotateG_03"></div>' +
        '<div class="f_circleG" id="frotateG_04"></div>' +
        '<div class="f_circleG" id="frotateG_05"></div>' +
        '<div class="f_circleG" id="frotateG_06"></div>' +
        '<div class="f_circleG" id="frotateG_07"></div>' +
        '<div class="f_circleG" id="frotateG_08"></div>' +
        '</div>' +
        '</div>';

    if ($("#checkout-form").length) {

        var btn = $("#checkout-form button[type=submit]");

        $('body').append(loaderTemplate);

        $("#checkout-form").on("submit", function (e) {
            btn.addClass("disabled");
            $(".loader").show();
        });
        document.getElementById("checkout-form").addEventListener("DOMSubtreeModified", function () {
            $(".loader").hide();
            btn.removeClass("disabled");
        });
    }
})();

$(document).ready(function () {
    $('.js-has-list').hover(function () {
        $(this).find('.list-level-wrap').fadeIn(100);
    }, function () {
        $(this).find('.list-level-wrap').fadeOut(80);
    });

    $('.js-select-lang').on('click', function () {
        if ($(this).hasClass('opened')) {
            $(this).parent().find('.lang-drop-down').fadeOut(80);
            $(this).parent().removeClass('opened');
        } else {
            $(this).parent().find('.lang-drop-down').fadeIn(100);
            $(this).parent().addClass('opened');
        }
    });

    $(document).mouseup(function (e) {
        var container = $(".lang-selector");
        if (container.has(e.target).length === 0) {
            $('.lang-drop-down').fadeOut(100);
            $('.lang-selector').removeClass('opened');
        }
    });
});
/*--------------------------------------------------------*/
$(document).ready(function () {
    /*--Главная--*/
    $('[data-styler]').styler();

    $('.js-read-more').on('click', function () {
        var variant = $(this).attr('data-variant');
        $(this).attr('data-variant', $(this).text());
        $(this).text(variant);
        $(this).closest('.post-content').toggleClass('opened');
    });

    $('.js-menu-btn').on('click', function () {
        $('.js-mobile-menu').fadeIn(120);
    });

    $('.js-close-mobile-menu').on('click', function () {
        $('.js-mobile-menu').fadeOut(120);
    });

    $('.js-toggle-list').on('click', function () {
        $(this).toggleClass('opened');
        $(this).parent().find('.js-list-container').slideToggle();
    });

    $('.js-select-city').on('click', function () {
        if ($(this).hasClass('opened')) {
            $(this).parent().find('.city-list-cont').fadeOut(80);
            $(this).removeClass('opened');
        } else {
            $(this).parent().find('.city-list-cont').fadeIn(100);
            $(this).addClass('opened');
        }
    });

    $(document).mouseup(function (e) {
        var container = $(".select-city");
        if (container.has(e.target).length === 0) {
            container.find('.city-list-cont').fadeOut(80);
            $('.js-select-city').removeClass('opened');
        }
    });

    // $('[data-dominant-color]').each(function (i, item) {
    //     var imgSrc = $(item).find('img').attr('src');
    //     $(item).find('.background').css({
    //         'background-image': "url( " + imgSrc + " )"
    //     });
    //     var img = $(item).find('img').get(0);
    // });

    $('.js-filter-btn').on('click', function () {
        $('.js-filter-modal').slideToggle(200);
    });

    function checkMenuDisplay() {
        var winWidth = $(document).width();
        if (winWidth > 992) {
            $('.js-filter-modal').show();
        }
    }

    $(window).on('resize', checkMenuDisplay);


    $('#prod-slider .carousel-inner').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '#prod-slider .carousel-indicators',
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: true,
                    prevArrow: "<a class='arrow prev'><i class='fa fa-angle-left'></i></a>",
                    nextArrow: "<a class='arrow next'><i class='fa fa-angle-right'></i></a>"
                }
            },
        ]

    });
    $('#prod-slider .carousel-indicators').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '#prod-slider .carousel-inner',
        focusOnSelect: true,
        arrows: true,
        prevArrow: "<a class='arrow prev'><i class='fa fa-angle-left'></i></a>",
        nextArrow: "<a class='arrow next'><i class='fa fa-angle-right'></i></a>",
        dots: false,
        variableWidth: true
    });

    $('#cartcustomerform-user_agreement').styler();
    $('input[type="checkbox"]').styler();

    /*--Фиксированный хедер--*/
    if ($('.js-fixed-header').length) {
        $(window).on('scroll', function () {
            var headerHeight = $('.js-fixed-header').outerHeight();
            if ($(window).scrollTop() > headerHeight) {
                $('body').addClass('fixed-header');
                $('.js-main').css({
                    'padding-top': headerHeight + 'px'
                });
            } else {
                $('body').removeClass('fixed-header');
                $('.js-main').css({
                    'padding-top': 0 + 'px'
                });
            }
        });
    }

    $(window).resize(function () {
        $(window).scroll();
    });

    $(window).scroll();
    /*--конец Фиксированый хедер--*/

    $('.home-main .categories-sect .one-cat').on('click', function () {
        $(this).toggleClass('opened');
    });

    // for open/close mobile search
    if ($('.mobile-header').length > 0) {
        $('.mobile-header').find('.search-btn').on('click', function () {
            $('.mobsearch-box').slideToggle();
        });
    }

    // Инициализация главного верхнего слайдера на домашней странице
    (function () {
        setTimeout(function () {
            if ($('.home-top-slider').length) {
                $('.home-top-slider').slick({
                    autoplay: true,
                    dots: true,
                    arrows: true,
                    fade: true,
                    cssEase: 'linear',
                    autoplaySpeed: 3000
                });
            }
        }, 400);
    })();

    // Инициализация слайдера фото партнеров на странице партнеров
    (function () {
        setTimeout(function () {
            if ($('.contact-partner-slider').length > 0) {
                $('.contact-partner-slider').slick({
                    autoplay: true,
                    dots: false,
                    arrows: true,
                    fade: true,
                    cssEase: 'linear',
                    autoplaySpeed: 3000
                });
            }
        }, 400);
    })();

    // Инициализация слайдера на странице фабрики
    (function () {
        setTimeout(function () {
            if ($('.fact-slider').length) {
                $('.fact-slider').slick({
                    autoplay: true,
                    dots: true,
                    arrows: false,
                    fade: true,
                    cssEase: 'linear',
                    autoplaySpeed: 3000
                });
            }
        }, 400);
    })();

    (function () {
        setTimeout(function () {
            $('.selectpicker').selectpicker();
        }, 1000);
    })();

    // Функция для валидации ввода в поля фильтров на главной странице
    // отлавливаем ввод данных в полях фильтра
    $(document).on('input', '.filter-bot .filter-price input[type="text"]', function (ev) {
        // если значение поля не пустое и если введенный символ не являеться числом
        if (isNaN(ev.originalEvent.data) && ev.target.value != "") {
            // и если значение поля не являеться числом
            if (!isNaN(parseFloat(ev.target.value))) {
                // и если это число больше 0
                if (parseFloat(ev.target.value) > 0) {
                    ev.target.value = parseFloat(ev.target.value);
                }
                // иначе присваиваем полю 0
                else {
                    ev.target.value = 0;
                }
            }
            // иначе очищаем поле
            else {
                ev.target.value = "";
            }
        }
    });

    $(document).on('click', '.click-by-factory-file', function () {
        $.post(baseUrl + 'catalog/factory/click-by-file/', {
            _csrf: $('#token').val(),
            id: $(this).data('id'),
        });
    });

    // Инициализация виджета - Intl-input doc - https://github.com/jackocnr/intl-tel-input.git
    // если данное поле существует на странице
    if ($('.intlinput-field').length > 0) {

        // получаем язык сайта у пользователя
        var siteLang = $('html').attr('lang');

        // функционал переводов ошибок на италлянский язык
        var errorMap = [];
        // если язык сайта италянский
        if (siteLang == 'it') {
            // Массив ошибок для поля номер телефона для италянского языка
            errorMap = ["Numero non valido", "Codice paese non valido", "Troppo corto", "Troppo lungo", "Numero non valido"];
        }
        else {
            // Массив ошибок для поля номер телефона в международном формате
            errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
        }

        // поле - телефон из нашей формы
        var intlInputEl = document.querySelector(".intlinput-field");
        // div, обертка поля - телефон из нашей формы
        var formGroupBox = $('.intlinput-field').closest('.form-group');
        // див help-block для показа сообщений об ошибке в поле телефон
        var errorMsg = formGroupBox.children('.help-block')[0];

        // инициализируем плагин международных телефонных номеров
        var iti = {};
        // если по условию нужны только Италия и Россия
        if ($(intlInputEl).attr('data-conly') == 'yes') {
            iti = window.intlTelInput(intlInputEl, {
                onlyCountries: ["it", "ru"],
                initialCountry: 'it',
                utilsScript: "/js/utils.js",
                formatOnDisplay: true
            });
        }
        // иначе инициализируем со всемя странами
        else {
            iti = window.intlTelInput(intlInputEl, {
                initialCountry: 'it',
                utilsScript: "/js/utils.js",
                formatOnDisplay: true
            });
        }

        // создаем функцию - сброса
        var reset = function() {

            intlInputEl.classList.remove("error");
            errorMsg.innerHTML = "";
            if (iti.isValidNumber()) {
                errorMsg.classList.add("hide");
                formGroupBox[0].classList.remove("has-error");
                formGroupBox[0].classList.add("has-success");
            }
            else {
                errorMsg.classList.remove("hide");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                formGroupBox[0].classList.remove("has-success");
                formGroupBox[0].classList.add("has-error");
                intlInputEl.setAttribute('aria-invalid', true);
            }
          };
          
          // on blur: validate
          intlInputEl.addEventListener('blur', function() {
            reset();
            if (intlInputEl.value.trim()) {
              if (!iti.isValidNumber()) {
                  setTimeout(function() {
                    intlInputEl.classList.add("error");
                    var errorCode = iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                    formGroupBox[0].classList.remove("has-success");
                    formGroupBox[0].classList.add("has-error");
                    intlInputEl.setAttribute('aria-invalid', true);
                  }, 500);
              }
            }
          });
          
          // on keyup / change flag: reset
          intlInputEl.addEventListener('change', reset);
          intlInputEl.addEventListener('keyup', reset);

        //   Валидация номера телефона при отправке формы
        $('#checkout-form').on('beforeSubmit', function(ev) {
            // если номер телефона не валидный
            if (!iti.isValidNumber()) {
                setTimeout(function() {
                    intlInputEl.setAttribute('aria-invalid', true);
                    var errorCode = iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                    formGroupBox[0].classList.remove("has-success");
                    formGroupBox[0].classList.add("has-error");
                },300);
                return false;
            }
            else {
                if ($(this).find('.intlinput-field').val() != iti.getNumber()) {
                    $(this).find('.intlinput-field').val(iti.getNumber());
                }
                var countryData = iti.getSelectedCountryData();
                $(this).find('#cartcustomerform-country_code').val(countryData.iso2);
            }
        });
    }

});
