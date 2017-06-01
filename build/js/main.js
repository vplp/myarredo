$(document).ready(function(){
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
        nextArrow: '<a href=javascript:void(0) class="slick-next fa fa-angle-right"></a>'
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

});
