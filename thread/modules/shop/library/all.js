/**
 * Кнопка купить в корзине
 */
// $('.card-buy-special').on('click', function () {
//     var product_id = $(this).data('id');
//
//     $.post('/shop/cart/add-to-cart',
//         {
//             _csrf: $('#token').val(),
//             id: product_id,
//             count: 1
//         }
//     ).done(function (data) {
//         if (data == true) {
//             document.location.reload(true);
//         }
//     });
// });

/**
 * Кнопка купить
 */
// $('.card-buy-quantity').on('click', function () {
//     var product_id = $(this).data('id');
//     var quantity = $(this).data('quantity');
//
//     if (Array.isArray(product_id) && Array.isArray(quantity)) {
//         for (var i = 0; i < product_id.length; i++) {
//             add_to_popup(product_id[i], quantity[i]);
//         }
//     }
//
//     $('#overlay').fadeIn(
//         400,
//         function () {
//             $('#basket-popup')
//                 .css('visibility', 'visible')
//                 .animate({opacity: 1}, 200);
//         }
//     );
// });

/**
 * Кнопка купить
 */
$('.add-to-bask').on('click', function () {
    var product_id = $(this).data('id');
    add_to_popup(product_id);
});

/**
 * добавление в попап корзину
 */
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
            refresh_popup_cart();
        }
    });
}

/**
 * добавление в корзину
 */
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
            refresh_full_cart();
        }
    });
}

/**
 * удаление елемента из попапа корзины
 */
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

/**
 * удаление елемента из корзины
 */
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

/**
 * изменение количества елемента в корзины
 */
function change_count_cart_item(id, value, count) {

    if (isNumeric(value)) {
        var f_count = (count - value);

        if (f_count != 0 && f_count > 0) {
            delete_from_cart(id, f_count);
        }
        else if (f_count != 0 && f_count < 0) {
            add_to_cart(id, -f_count);
        }
    }
}

/**
 * изменение количества елемента в попапе корзины
 */
function change_count_cart_popup_item(id, value, count) {
    var value = +value;
    if (isNumeric(value)) {
        var f_count = (count - value);
        if (f_count != 0 && f_count > 0) {
            delete_from_popup(id, f_count);
        }
        else if (f_count != 0 && f_count < 0) {
            add_to_popup(id, -f_count);
        }
    }
}

/**
 * Refresh popup
 */
function refresh_popup_cart() {
    $.post(
        '/shop/widget',
        {
            _csrf: $('#token').val(),
            view: 'full_popup'
        }
    ).done(function (data) {
        if (data.success) {
            $('#short_cart').html(data.views.short);
            $('#popup').html(data.view);
            reloadPopup(data.view);
        }
    });
}

/**
 * Refresh
 */
function refresh_full_cart() {
    $.post(
        '/shop/widget',
        {
            _csrf: $('#token').val(),
            view: 'full'
        }
    ).done(function (data) {
        if (data.success) {
            $('#short_cart').html(data.views.short);
            $('.basket_tabs_cnt_cart').html(data.view);
            $('input[data-styler]').styler();
            $(window).resize();
        }
    });
}

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}