<?php

return [
    'gii' => 'gii',
    '<_m:debug>/<_c:\w+>/<_a:\w+>/' => '<_m>/<_c>/<_a>',
    [
        'pattern' => 'robots',
        'route' => 'seo/robots/index',
        'suffix' => '.txt'
    ],

    // Module [[Articles]]
    'articles' => 'articles/list/index',
    'articles/<alias:[\w\-]+>' => 'articles/article/index',

    // Module [[Home]]
    '' => 'home/home/index',
    'contacts' => 'page/contacts/index',
    'partners-map' => 'page/contacts/list-partners',

    // Module [[Users]]
    'logistician/registration' => 'user/register/logistician',
    'partner/registration' => 'user/register/partner',
    'factory/registration' => 'user/register/factory',
    'user/register' => 'user/register/user',
    'user/confirmation/<token:[\w\-]+>' => 'user/register/confirmation',
    'user/login' => 'user/login/index',
    'user/logout' => 'user/logout/index',
    'user/profile' => 'user/profile/index',
    'user/profile/update' => 'user/profile/update',
    'user/password/request' => 'user/password/request-reset',
    'user/password/change' => 'user/password/change',
    'user/password/reset' => 'user/password/reset',
    'user/profile/fileupload' => 'user/profile/fileupload',
    'user/profile/filedelete' => 'user/profile/filedelete',
    'user/login/validation' => 'user/login/validation',

    // Module [[Catalog]]
    'search' => 'catalog/elastic-search/search',
    'search/index' => 'catalog/elastic-search/index',

    'catalog/<filter:[\=\;\-\w\d]+>' => 'catalog/category/list',
    'catalog/category/ajax-get-types' => 'catalog/category/ajax-get-types',
    'catalog/category/ajax-get-category' => 'catalog/category/ajax-get-category',
    'catalog/category/ajax-get-novelty' => 'catalog/category/ajax-get-novelty',
    'catalog/category/ajax-get-filter' => 'catalog/category/ajax-get-filter',

    'sale/<filter:[\=\;\-\/\w\d]+>' => 'catalog/sale/list',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>' => 'catalog/template-factory/factory',
    'factory/<alias:[\w\-]+>' => 'catalog/factory/view',
    'product/ajax-get-compositions' => 'catalog/product/ajax-get-compositions',
    'product/<alias:[\w\-]+>' => 'catalog/product/view',
    'sale-product/<alias:[\w\-]+>' => 'catalog/sale/view',
    'catalog' => 'catalog/category/list',
    'factories/<letter:[\w\-]>' => 'catalog/factory/list',
    'factories' => 'catalog/factory/list',
    'sale' => 'catalog/sale/list',
    'catalog/sale/ajax-get-phone' => 'catalog/sale/ajax-get-phone',

    'product-stats' => 'catalog/product-stats/list',
    'product-stats/<id:[\d\-]+>' => 'catalog/product-stats/view',

    'sale-stats' => 'catalog/sale-stats/list',
    'sale-stats/<id:[\d\-]+>' => 'catalog/sale-stats/view',

    'sale-italy-stats' => 'catalog/sale-italy-stats/list',
    'sale-italy-stats/<id:[\d\-]+>' => 'catalog/sale-italy-stats/view',

    'factory-stats' => 'catalog/factory-stats/list',
    'factory-stats/<alias:[\w\-]+>' => 'catalog/factory-stats/view',

    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/contacts' => 'catalog/template-factory/contacts',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/catalog/<filter:[\=\;\-\w\d]+>' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/catalog' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/sale' => 'catalog/template-factory/sale',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/product/<product:[\w\-]+>' => 'catalog/template-factory/product',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/sale-product/<product:[\w\-]+>' => 'catalog/template-factory/sale-product',

    // Factory product
    'factory-collections' => 'catalog/factory-collections/list',
    'factory-collections/create' => 'catalog/factory-collections/create',
    'factory-collections/update/<id:[\d\-]+>' => 'catalog/factory-collections/update',

    // Factory product
    'factory-product' => 'catalog/factory-product/list',
    'factory-product/create' => 'catalog/factory-product/create',
    'catalog/factory-product/ajax-get-category' => 'catalog/factory-product/ajax-get-category',
    'factory-product/update/<id:[\d\-]+>/<step:(photo|check|promotion)>' => 'catalog/factory-product/update',
    'factory-product/update/<id:[\d\-]+>' => 'catalog/factory-product/update',
    'factory-product/intrash/<id:[\d\-]+>' => 'catalog/factory-product/intrash',
    'catalog/factory-product/fileupload' => 'catalog/factory-product/fileupload',
    'catalog/factory-product/filedelete' => 'catalog/factory-product/filedelete',
    'catalog/factory-product/promotion' => 'catalog/factory-product/promotion',

    // Italian product
    'sale-italy/<filter:[\=\;\-\/\w\d]+>' => 'catalog/sale-italy/list',
    'sale-italy' => 'catalog/sale-italy/list',
    'sale-italy-product/<alias:[\w\-]+>' => 'catalog/sale-italy/view',
    //
    'italian-product' => 'catalog/italian-product/list',
    'italian-product/completed' => 'catalog/italian-product/completed',
    'italian-product/paid-create' => 'catalog/italian-product/paid-create',
    'italian-product/free-create' => 'catalog/italian-product/free-create',
    'italian-product/interest-payment/<id:[\d\-]+>' => 'catalog/italian-product/interest-payment',
    'italian-product/payment' => 'catalog/italian-product/payment',
    'italian-product/update/<id:[\d\-]+>/<step:(photo|check|payment|promotion)>' => 'catalog/italian-product/update',
    'italian-product/update/<id:[\d\-]+>' => 'catalog/italian-product/update',
    'italian-product/is-sold/<id:[\d\-]+>' => 'catalog/italian-product/is-sold',
    'italian-product/on-moderation/<id:[\d\-]+>' => 'catalog/italian-product/on-moderation',
    'italian-product/intrash/<id:[\d\-]+>' => 'catalog/italian-product/intrash',
    'italian-product/change-tariff/<id:[\d\-]+>' => 'catalog/italian-product/change-tariff',

    'catalog/italian-product/fileupload' => 'catalog/italian-product/fileupload',
    'catalog/italian-product/filedelete' => 'catalog/italian-product/filedelete',
    'catalog/italian-product/one-file-upload' => 'catalog/italian-product/one-file-upload',
    'catalog/italian-product/one-file-delete' => 'catalog/italian-product/one-file-delete',

    // Factory promotion
    'factory-promotion' => 'catalog/factory-promotion/list',
    'factory-promotion/create' => 'catalog/factory-promotion/create',
    'factory-promotion/create-payment/<id:[\d\-]+>' => 'catalog/factory-promotion/create-payment',
    'factory-promotion/notify' => 'catalog/factory-promotion/notify',
    'factory-promotion/update/<id:[\d\-]+>' => 'catalog/factory-promotion/update',
    'factory-promotion/intrash/<id:[\d\-]+>' => 'catalog/factory-promotion/intrash',

    // Partner sale
    'partner/sale' => 'catalog/partner-sale/list',
    'partner/sale/create' => 'catalog/partner-sale/create',
    'partner/sale/update/<id:[\d\-]+>/<step:(photo|check|promotion)>' => 'catalog/partner-sale/update',
    'partner/sale/update/<id:[\d\-]+>' => 'catalog/partner-sale/update',
    'partner/sale/intrash/<id:[\d\-]+>' => 'catalog/partner-sale/intrash',
    'catalog/partner-sale/fileupload' => 'catalog/partner-sale/fileupload',
    'catalog/partner-sale/filedelete' => 'catalog/partner-sale/filedelete',

    // Module [[Payment]]
    'payment/invoice' => 'payment/payment/invoice',
    'payment/result' => 'payment/payment/result',
    'payment/success' => 'payment/payment/success',
    'payment/fail' => 'payment/payment/fail',
    'partner-payment/list' => 'payment/partner-payment/list',

    // Module [[News]]
    'news/<alias:[\w\-]+>' => 'news/list/index',
    'news' => 'news/list/index',
    'news/article/<alias:[\w\-]+>' => 'news/article/index',
    'news/article-for-partners/<id:[\d\-]+>' => 'news/article-for-partners/index',

    // Module [[Rules]]
    'rules' => 'rules/rules/list',
    'rules/<id:[\d\-]+>' => 'rules/rules/view',

    // Module [[Feedback]]
    'page/contact' => 'feedback/feedback/index',
    'page/contact/send' => 'feedback/form/send',

    // Module [[Page]]
    '<alias:[\w\-]+>' => 'page/page/view',
    'find/<condition:[\w\-]+>' => 'page/find/index',

    // Module [[Forms]]
    'forms/feedback' => 'forms/forms/feedback',

    // Module [[SEO]]
    'page/sitemap' => 'seo/sitemap-html/index',

    //'sitemap/pathcache' => 'seo/pathcache/pathcache/index',
    //'sitemap/fill' => 'seo/sitemap/fill/index',
    //'sitemap/create' => 'seo/sitemap/create/index',

    // Module [[Shop]]
    'shop/widget' => 'shop/widget/index',
    'shop/widget/request-price' => 'shop/widget/request-price',
    'orders/notepad' => 'shop/cart/notepad',
    'shop/order/list' => 'shop/order/list',
    'shop/order/view/<id:[\d\-]+>' => 'shop/order/view',
    'shop/order/link/<token:[\w\-]+>' => 'shop/order/link',
    'shop/cart/add-to-cart' => 'shop/cart/add-to-cart',
    'shop/cart/delete-from-cart' => 'shop/cart/delete-from-cart',
    'shop/cart/delete-from-cart-popup' => 'shop/cart/delete-from-cart-popup',

    'shop/factory/orders' => 'shop/factory-order/list',
    'shop/factory/orders-italy' => 'shop/factory-order/list-italy',
    'admin/orders' => 'shop/admin-order/list',
    'admin/orders-italy' => 'shop/admin-order/list-italy',
    'partner/orders' => 'shop/partner-order/list',
    'partner/orders-italy' => 'shop/partner-order/list-italy',
    'partner/delivery-italian-orders' => 'shop/partner-order/delivery-italian-orders',
    'partner/orders/pjax-save' => 'shop/partner-order/pjax-save',

    // Module [[Location]]
    'location/location/get-cities' => 'location/location/get-cities',
    'location/currency/change' => 'location/currency/change',

    // Module [[Banner]]
    'banner/factory-banner/list' => 'banner/factory-banner/list',
    'banner/factory-banner/create' => 'banner/factory-banner/create',
    'banner/factory-banner/intrash/<id:[\d\-]+>' => 'banner/factory-banner/intrash',
    'banner/factory-banner/update/<id:[\d\-]+>' => 'banner/factory-banner/update',
    'banner/factory-banner/fileupload' => 'banner/factory-banner/fileupload',
    'banner/factory-banner/filedelete' => 'banner/factory-banner/filedelete',

    'seo/metrics/ajax-get-metrics' => 'seo/metrics/ajax-get-metrics'
];
