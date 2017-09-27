/**
 * Кнопка запросить цену
 */
$('.request-price').on('click', function () {
    var product_id = $(this).data('id'),
        count = 1;

    $.post('/shop/cart/add-to-cart',
        {
            _csrf: $('#token').val(),
            id: product_id,
            count: count,
            flag: 'request-price'
        }
    ).done(function (data) {
        if (data == true) {

            refresh_full_cart();

            $.post(
                '/shop/widget/request-price',
                {
                    _csrf: $('#token').val(),
                    view: 'full'
                }
            ).done(function (data) {
                if (data.success) {
                    $('#myModal').html(data.view);
                    $('#myModal').modal();
                }
            });
        }
    });

    return false;
});

/**
 * отложить в блокнот на странице товара
 */
$('.add-to-notepad-product').on('click', function () {
    var product_id = $(this).data('id');
    add_to_cart(product_id, 1);
});

/**
 * кнопка отложить в блокнот
 */
$('.add-to-notepad').on('click', function () {
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
            $('#myModal').html(data.view);
            $('.prod-card-page').find('.add-to-notepad').html('В блокноте')
            $('#myModal').modal();
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
            $('.basket-items').html(data.view);
        }
    });
}

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}