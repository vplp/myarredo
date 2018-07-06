$(document).ready(function(){
    var state = {
        _device: "",
        _mobInit: function(){
            runMobile();
        },
        _tabletInit: function() {
            runTablet();
        },
        _descInit: function() {
            runDesctop();
        },
        _preWindowWidth: $(window).width(),
        _windowIncreases: function() {
            if(state._preWindowWidth > $(window).width()){
                state._preWindowWidth = $(window).width();
                return false;
            } else if (state._preWindowWidth < $(window).width()){
                state._preWindowWidth = $(window).width();
                return true;
            }
        }
    };

    (function( $ ) {
        $.fn.getDevice = function(braikPointMob,braikPointTablet) {
            Object.defineProperty(state, "device", {

                get: function() {
                    return this._device;
                },

                set: function(value) {
                    this._device = value;
                    if(value == "desctop"){
                        state._descInit();

                    } else if (value == "tablet"){
                        state._tabletInit();
                    } else if (value == "mobile"){
                        state._mobInit();
                    }
                }
            });

            $(this).on("resize load", function(){
                if($(this).width() < braikPointMob && state.device != "mobile"){
                    state.device = "mobile";
                } else if($(this).width() > braikPointMob && $(this).width() < braikPointTablet && state.device != "tablet") {
                    state.device = "tablet";
                }
                else if ($(this).width() > braikPointTablet && state.device != "desctop") {
                    state.device = "desctop";
                }
            });
        };
    })(jQuery);

    $(window).getDevice(540,768);

    console.log(state.device);

    function runMobile(){
        console.log('mobile');
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

    function runTablet(){
        console.log('tablet');
        //$('.filters .one-filter').removeClass('open');
        if($('.js-numbers').hasClass('slick-slider')){
            $('.js-numbers').slick('unslick');
        }
        if($('.best-price .right-part').hasClass('slick-slider')){
            $('.best-price .right-part').slick('unslick');
        }
    }

    function runDesctop() {
        console.log("desctp");
        $('.filters .one-filter').addClass('open');
        if($('.js-numbers').hasClass('slick-slider')){
            $('.js-numbers').slick('unslick');
        }
        if($('.best-price .right-part').hasClass('slick-slider')){
            $('.best-price .right-part').slick('unslick');
        }
    }
    /*--Конец определения девайса--*/

   /*--Открыть/закрыть города--*/
    (function(){
        $('#select-city,#close-top').click(function(){
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
    $('.multi-item-carousel .item').each(function(){
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
            console.log(next);
        }

        next.children(':first-child').clone().appendTo($(this));
        next.next().children(':first-child').clone().appendTo($(this));
        if (next.next().length>0) {
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
    (function(){
        $('.location-buts > a').click(function(){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            if($(this).attr('data-style')=='large'){
                $(this).closest('.cont-area').addClass('large-tiles');
            } else {
                $(this).closest('.cont-area').removeClass('large-tiles');
            }
        });
    })();
    /*--конец Изменение вида в каталоге--*/

    /*--Ползунок каталог--*/
    (function(){
        var slider = document.getElementById('price-slider');
        if($('#min-price').val() == $('#max-price').val()) {
            $('#max-price').val( $('#max-price').val() + 1 );
        }
        if(slider != null){
            noUiSlider.create(slider, {
                start: [$('#min-price').val(),$('#max-price').val()],
                connect: true,
                animate: true,
                animationDuration: 300,
                range: {
                    'min': Number($('#min-price').val()),
                    'max': Number($('#max-price').val())
                },
                format: wNumb({
                    decimals: 0
                })

            });

            slider.noUiSlider.on('update',function(){
                var arrResult = slider.noUiSlider.get();
                $('#min-price').val(arrResult[0]);
                $('#max-price').val(arrResult[1]);
            });

            $('#min-price').change(function(){
                slider.noUiSlider.set([$(this).val(),$('#max-price').val()]);
            });

            $('#max-price').change(function(){
                slider.noUiSlider.set([$('#min-price').val(),$(this).val()]);
            });
        }




    })();
    /*--конец ползунок--*/

    /*--Открыть\закрыть категорию в каталоге--*/
    (function () {
        $('.filt-but').click(function(){
            var parent = $(this).parent('.one-filter');
                if(parent.hasClass('open')){
                    parent.removeClass('open');
                    parent.find('.list-item').slideUp();
                } else {
                    parent.addClass('open');
                    parent.find('.list-item').slideDown();
                }
                //parent.find('.list-item').slideToggle();
        });
    })();
    /*--конец Открыть\закрыть категорию в каталоге--*/

    $('.factory-page .view-all').click(function(){
       $(this).parent('.all-list').find('.post-list').slideToggle();
    });

    /*--Блокнот--*/
    $(".notebook-page .basket-item-info").each(function(i,item){
        if(i > 2){
            $(item).hide();
        }
    });
    $(".notebook-page .show-all").click(function(){
        $(".basket-item-info").show();
        $(this).remove();
    });

    $(".notebook-page .read-more").mouseenter(function(){
       var item = $(this).closest('.basket-item-info');
       item.addClass("read-more");
    });

    $(".basket-item-info").mouseleave(function () {
        $(this).removeClass("read-more");
    });

    /*--конец Блокнот--*/

    /*--открыть/закрыть заказ (кабинет фабрики)--*/
    $(".manager-history-list .orders-title-block").click(function(){
        var item = $(this).closest(".item");
        item.toggleClass("open");
        item.siblings().removeClass("open");
        item.siblings().find(".hidden-order-info").slideUp();
        item.find(".hidden-order-info").slideToggle();
        if(typeof item.attr("data-hash") !== "undefined") {
           var hash = item.attr("data-hash");
           window.location.hash = hash;
        }
    });

    window.onload = function(){
        if( window.location !== "" ){
            var hash = window.location.hash.replace("#","");
            var el = $('[data-hash="' + String(hash) + '"]');
            if(el.length){
                var top = el.offset().top;
                $("html,body").animate({"scrollTop":top},100);
                el.click();
            }
        }
    };

    if(window.location.hash !== ""){
        var itemHash = window.location.hash.replace("#","");
        $("[data-hash='" + itemHash + "']").find(".orders-title-block").click();
    }
    /*--конец открыть/зыкрыть заказ (кабинет фабрики)--*/

    /*--поиск по списку (кабинет фабрики)--*/
    $(".drop-down-find .find").on("input", function(){
        var In = $(this).val();
        var dropDown = $(this).closest('.drop-down-find').find('li a');
            dropDown.each(function(i, item){
                if($(item).text().indexOf(In) !== 0){
                    $(item).parent().hide();
                } else {
                    $(item).parent().show();
                }
            });
    });
    $(".drop-down-find li a").click(function(){
        var parent = $(this).closest(".arr-drop");
        var text = $(this).text();
        parent.find(".dropdown-toggle").text(text);
    });
    $(".arr-drop .dropdown-toggle").click(function(){
       var parent = $(this).closest(".arr-drop");
       parent.find(".find").val("");
       parent.find(".drop-down-find li").show();
    });
    /*--конец поиск по списку (кабинет фабрики)--*/

    /*--Активация табов в карточке--*/
    $(".prod-card-page .nav-tabs li a").eq(0).click();
    /*--конец Активация табов в карточке--*/

    $(".list-cities label").click(function(){
       $(this).parent().find('input[type="checkbox"]').click();
    });

    $(".categoty-page .one-item-check").click(function(){
       location.href = $(this).attr("href");
    });

    $(".dropdown-menu a").click(function(){
       var href = $(this).attr('href');
       window.location.href = href;
    });

    $(".show-all-sub").click(function(){
        var list = $(this).siblings(".list-item");
        var variant = $(this).attr("data-variant");
        var textCont = $(this).find(".btn-text");

           if(list.hasClass('show')){
               list.removeClass('show');
               $(this).attr("data-variant",textCont.text());
               $(this).addClass('show-class');
               textCont.text(variant);
           } else {
               list.addClass('show');
               $(this).attr("data-variant",textCont.text());
               $(this).removeClass('show-class');
               textCont.text(variant);
           }
    });

    (function(){

        var selItemIn = $(".list-item > .one-item-check.selected");

        selItemIn.each(function(i,item){
            var parent = $(item).closest(".list-item");
            parent.prepend($(item));
        });

    })();

    function slickInit(){
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
        $('#comp-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            prevArrow: '<a href=javascript:void(0) class="slick-prev fa fa-angle-left"></a>',
            nextArrow: '<a href=javascript:void(0) class="slick-next fa fa-angle-right"></a>',responsive: [
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

    }
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
    $(document).ready(function() {
        $("a.fancyimage").fancybox();
    });
    /*--конец Галерея Карточка товара --*/

    /*--модалка варианты отделки*/
    $(".composition .show-modal").click(function(e){
        e.preventDefault();
        var img = $(this).clone();
        $('#decoration-modal .image-container').html("").append(img);
        $('#decoration-modal').modal();
    });
    /*--конец модалка варианты отделки*/

    /*--больше фабрик модалка--*/
    $(".alphabet-tab a").click(function(){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");

        var actTab = $(this).text();
        var actShow = $("[data-show=" + actTab + "]").show();
        actShow.siblings().hide();
        actShow.css({
            "display":"flex"
        });
    });
    $(".alphabet-tab a").eq(0).trigger( "click" ); //показываем первый элемент по умолчанию
    /*--конец Больше фабрик модалка--*/

    $(".img-zoom").click(function(){
       $("#prod-slider .item.active .fancyimage").click();
    });

    if($(".carousel-indicators li").length == 1){  //Скрываем стрелки если только одна картинка в слайдере
        $(".nav-contr").hide();
    }

    $("#novelties-slider .item img").each(function(i,item){
        var src = $(item).attr("src");
        $(item).css({"opacity":"0"});
        $(item).parent().css({"background-image": "url(" + src + ")"});
    });

    if( $(".text-col").text().trim() == "" ){
        $(".text-col").closest(".text-description").remove();
    }

});
(function(){
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

    if( $("#checkout-form").length ){

        var btn = $("#checkout-form button[type=submit]");

        $('body').append(loaderTemplate);

        $("#checkout-form").on("submit",function(e){
            btn.addClass("disabled");
            $(".loader").show();
        });
        document.getElementById("checkout-form").addEventListener("DOMSubtreeModified", function(){
            $(".loader").hide();
            btn.removeClass("disabled");
        });
    }
})();

$(document).ready(function(){
    $('.js-has-list').hover(function(){
        $(this).find('.list-level-wrap').fadeIn(100);
    }, function(){
        $(this).find('.list-level-wrap').fadeOut(80);
    });

    $('.js-select-lang').on('click', function(){
        if($(this).hasClass('opened')){
            $(this).parent().find('.lang-drop-down').fadeOut(80);
            $(this).parent().removeClass('opened');
        } else {
            $(this).parent().find('.lang-drop-down').fadeIn(100);
            $(this).parent().addClass('opened');
        }
    });

    $(document).mouseup(function (e) {
        var container = $(".lang-selector");
        if (container.has(e.target).length === 0){
            $('.lang-drop-down').fadeOut(100);
            $('.lang-selector').removeClass('opened');
        }
    });
});
/*--------------------------------------------------------*/
$(document).ready(function(){
    /*--Главная--*/
    $('[data-styler]').styler();

    $('.js-read-more').on('click', function(){
        var variant = $(this).attr('data-variant');
        $(this).attr('data-variant', $(this).text());
        $(this).text(variant);
        $(this).closest('.post-content').toggleClass('opened');
    });

    $('.js-menu-btn').on('click', function(){
        $('.js-mobile-menu').fadeIn(120);
    });

    $('.js-close-mobile-menu').on('click', function(){
        $('.js-mobile-menu').fadeOut(120);
    });

    $('.js-toggle-list').on('click', function(){
        $(this).toggleClass('opened');
        $(this).parent().find('.js-list-container').slideToggle();
    });

    $('.js-select-city').on('click', function(){
        if($(this).hasClass('opened')){
            $(this).parent().find('.city-list-cont').fadeOut(80);
            $(this).removeClass('opened');
        } else {
            $(this).parent().find('.city-list-cont').fadeIn(100);
            $(this).addClass('opened');
        }
    });

    $(document).mouseup(function (e) {
        var container = $(".select-city");
        if (container.has(e.target).length === 0){
            container.find('.city-list-cont').fadeOut(80);
            $('.js-select-city').removeClass('opened');
        }
    });

    $('[data-dominant-color]').each(function(i,item){
       var imgSrc = $(item).find('img').attr('src');
       $(item).find('.background').css({
           'background-image': "url( " + imgSrc + " )"
       });
       var img = $(item).find('img').get(0);
    });

    $('.js-filter-btn').on('click', function(){
       $('.js-filter-modal').slideToggle(200);
    });


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
    if($('.js-fixed-header').length){
        $(window).on('scroll', function () {
            var headerHeight = $('.js-fixed-header').outerHeight();
            if($(window).scrollTop() > headerHeight){
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

    $('.home-main .categories-sect .one-cat').on('click', function(){
        $(this).toggleClass('opened');
    });

});
