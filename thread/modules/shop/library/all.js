/**
 * Created by Alla Kuzmenko on 27.10.2016.
 *
 *  DEVELOPER FILE JS
 */

$('.card-buy').on('click', function () {
    var product_id = $(this).data('id');
    add_to_popup(product_id);
    /*
     показать попап
     */
   

});

/*добавление в попап корзину*/
function add_to_popup(id, count) {
    count = count || 1;
    $.post('/shop/cart/add-to-cart',
        {
            _csrf: $('#token').val(),
            id: id,
            count: count
        }
    ).done(function (data) {
        if (data == true) {
            //doing something
            refresh_popup_cart();
        }
    });
}
/*добавление в корзину*/
function add_to_cart(id, count) {
    count = count || 1;
    $.post('/shop/cart/add-to-cart',
        {
            _csrf: $('#token').val(),
            id: id,
            count: count
        }
    ).done(function (data) {
        if (data == true) {
            //doing something
            refresh_full_cart();
        }
    });
}

/*удаление елемента из попапа корзины*/
function delete_from_popup(id, count) {
    count = count || 0;
    $.post('/shop/cart/delete-from-cart',
        {
            _csrf: $('#token').val(),
            product_id: id,
            count: count
        }
    ).done(function (data) {
        if (data) {
            refresh_popup_cart();
        }
    });
}
/*удаление елемента из корзины*/
function delete_from_cart(id, count) {
    count = count || 0;
    $.post('/shop/cart/delete-from-cart',
        {
            _csrf: $('#token').val(),
            product_id: id,
            count: count
        }
    ).done(function (data) {
        if (data) {
            refresh_full_cart();
        }
    });
}
/*изменение количества елемента в корзины*/
function change_count_cart_item(id, value, count) {
    //console.log(id + ' ' + value + ' ' + count);
    if (isNumeric(value)) {
        var f_count = (count - value);
        if (f_count != 0 && f_count > 0) {
            delete_from_cart(id, f_count);
            //console.log('count > value -- delete ' + f_count);
        }
        else if (f_count != 0 && f_count < 0) {
            add_to_cart(id, -f_count);
            //console.log('count < value -- add ' + f_count);
        }
    }

}

/*изменение количества елемента в попапе корзины*/
function change_count_cart_popup_item(id, value, count) {
    // console.log(id + ' ' + value + ' ' + count);
    var value = +value;
    if (isNumeric(value)) {
        var f_count = (count - value);
        if (f_count != 0 && f_count > 0) {
            delete_from_popup(id, f_count);
            //console.log('count > value -- delete ' + f_count);
        }
        else if (f_count != 0 && f_count < 0) {
            add_to_popup(id, -f_count);
            //console.log('count < value -- add ' + f_count);
        }
    }
}


function refresh_popup_cart() {
    $.post('/shop/widget',
        {
            _csrf: $('#token').val(),
            view: 'full_popup'
        }
    ).done(function (data) {
        if (data.success) {
            //doing something
            $('.short_cart').html(data.views.short);
            $('.header-mobile_r').html(data.views.short_mobile);
            $('#basket-popup').html(data.view);
            // console.log(data.views);
        }
    });
}

function refresh_full_cart() {
    $.post('/shop/widget',
        {
            _csrf: $('#token').val(),
            view: 'full'
        }
    ).done(function (data) {
        if (data.success) {
            $('.short_cart').html(data.views.short);
            $('.header-mobile_r').html(data.views.short_mobile);
            $('.basket_tabs_cnt').html(data.view);
            //console.log(data.view);
        }
    });
}

function close_popup_cart() {
    $('#basket-popup')
        .animate({opacity: 0}, 200,
            function () {
                $(this).css('visibility', 'hidden');
                $('#overlay').fadeOut(400);
            }
        );
}

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
