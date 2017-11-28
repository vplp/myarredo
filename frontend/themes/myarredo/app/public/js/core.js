
$(document).ready(function(){
    var state = {
        _device: "",
        _mobInit: function(){
            mobInit();
        },
        _descInit: function() {
            descInit();
        }
    };

    (function( $ ) {
        $.fn.getDevice = function(braikPoint) {
            Object.defineProperty(state, "device", {

                get: function() {
                    return this._device;
                },

                set: function(value) {
                    this._device = value;
                    if(value == "desctop"){
                        state._descInit();

                    } else if (value == "mobile"){
                        state._mobInit();
                    }
                }
            });

            $(this).on("resize load", function(){
                if($(this).width() < braikPoint && state.device != "mobile"){
                    state.device = "mobile";
                } else if ($(this).width() > braikPoint && state.device != "desctop") {
                    state.device = "desctop";
                }
            });
        };
    })(jQuery);

    $(window).getDevice(768);

    console.log(state.device);


    function mobInit(){
        console.log('mobile');
        $('.filters .one-filter').removeClass('open');
    }

    function descInit() {
        console.log("desctp");
        $('.filters .one-filter').addClass('open');
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
            $('#max-price').val( $('#max-price').val() + 1 )
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



    $('#comp-slider, .std-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        prevArrow: '<a href=javascript:void(0) class="slick-prev fa fa-angle-left"></a>',
        nextArrow: '<a href=javascript:void(0) class="slick-next fa fa-angle-right"></a>',responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
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
       $(this).closest(".item").toggleClass("open");
       $(this).closest(".item").find(".hidden-order-info").slideToggle();
    });
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
               textCont.text(variant);
           } else {
               list.addClass('show');
               $(this).attr("data-variant",textCont.text());
               textCont.text(variant);
           }
    });

    (function(){

        var selItemIn = $(".list-item > .one-item-check.selected");

        selItemIn.each(function(i,item){
            var parent = $(item).closest(".list-item");
            parent.prepend($(item));
        })

    })();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $(".fa-angle-right.slick-arrow").click();
        $(".fa-angle-left.slick-arrow").click();
    });

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


});
