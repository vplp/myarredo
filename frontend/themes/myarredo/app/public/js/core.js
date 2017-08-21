/*--Инициализация карты--*/
function mapInit(){
    if($('#map').length){
        ymaps.ready(function(){
            $('#map').empty();
            var map = new ymaps.Map("map", {
                center: [55.73367, 37.587874],
                zoom: 11,
                scroll: false
            });
            map.behaviors.disable('scrollZoom');
        });
    }
};
/*--конец инициализации карты--*/
$(window).load(function(){
    mapInit();
});
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
        mapInit();

        $('.filters .one-filter').removeClass('open');
    }

    function descInit() {
        console.log("desctp");
        mapInit();

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

    /*

    $('.multi-item3-carousel .item').each(function(){
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
            console.log(next);
        }


        next.next().children(':first-child').clone().appendTo($(this));
        if (next.next().length>0) {
            next.next().next().children(':first-child').clone().appendTo($(this));
        } else {
            $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
        }
    });
    */

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
                console.log(parent);
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
    $(".basket-item-info").each(function(i,item){
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
    $(".manager-history-list .item").click(function(){
       $(this).toggleClass("open");
       $(this).find(".hidden-order-info").slideToggle();
    });
    /*--конец открыть/зыкрыть заказ (кабинет фабрики)--*/

    /*--поиск по списку (кабинет фабрики)--*/
    $(".drop-down-find .find").on("input", function(){
        var In = $(this).val();
        var dropDown = $(this).closest('.drop-down-find').find('li a');
            dropDown.each(function(i, item){
                if($(item).text().indexOf(In) !== 0){
                    $(item).hide();
                } else {
                    $(item).show();
                }
            });
    });
    $(".drop-down-find li a").click(function(){
        var parent = $(this).closest(".arr-drop");
        var text = $(this).text();
        parent.find(".dropdown-toggle").text(text);
    });
    /*--конец поиск по списку (кабинет фабрики)--*/

});
