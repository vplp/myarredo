<?php

$urls = [
    'gii' => 'gii',
    '<_m:debug>/<_c:\w+>/<_a:\w+>/' => '<_m>/<_c>/<_a>',
    [
        'pattern' => 'robots',
        'route' => 'seo/robots/index',
        'suffix' => '.txt'
    ],

    // Module [[Articles]]
    'articles' => 'articles/articles/list',
    'articles/<alias:[\w\-]+>' => 'articles/articles/view',

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

    'furniture/<filter:[\=\;\-\w\d]+>' => 'catalog/countries-furniture/list',
    'furniture' => 'catalog/countries-furniture/list',
    'furniture-product/<alias:[\w\-]+>' => 'catalog/countries-furniture/view',
    'catalog/countries-furniture/ajax-get-filter' => 'catalog/countries-furniture/ajax-get-filter',
    'catalog/countries-furniture/ajax-get-filter-sizes' => 'catalog/countries-furniture/ajax-get-filter-sizes',

    'search' => 'catalog/elastic-search/search',
    'search/index' => 'catalog/elastic-search/index',

    'catalog/<filter:[\=\;\-\w\d]+>' => 'catalog/category/list',
    'catalog' => 'catalog/category/list',
    'catalog/category/ajax-get-types' => 'catalog/category/ajax-get-types',
    'catalog/category/ajax-get-category' => 'catalog/category/ajax-get-category',
    'catalog/category/ajax-get-novelty' => 'catalog/category/ajax-get-novelty',
    'catalog/category/ajax-get-filter' => 'catalog/category/ajax-get-filter',
    'catalog/category/ajax-get-filter-sizes' => 'catalog/category/ajax-get-filter-sizes',
    'catalog/category/ajax-get-filter-on-main' => 'catalog/category/ajax-get-filter-on-main',

    'sale/<filter:[\=\;\-\/\w\d]+>' => 'catalog/sale/list',

    'factory/pdf-viewer' => 'catalog/factory/pdf-viewer',

    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/catalogs-files' => 'catalog/template-factory/catalogs-files',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/prices-files' => 'catalog/template-factory/prices-files',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/contacts' => 'catalog/template-factory/contacts',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/working-conditions' => 'catalog/template-factory/working-conditions',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/catalog/<filter:[\=\;\-\w\d]+>' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/catalog' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/sale' => 'catalog/template-factory/sale',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/product/<product:[\w\-]+>' => 'catalog/template-factory/product',
    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>/sale-product/<product:[\w\-]+>' => 'catalog/template-factory/sale-product',
    'factory/template-factory/ajax-get-filter' => 'catalog/template-factory/ajax-get-filter',
    'factory/template-factory/ajax-get-filter-sizes' => 'catalog/template-factory/ajax-get-filter-sizes',

    'factory/<alias:(nieri|tomassi_cucine|damiano_latini)>' => 'catalog/template-factory/factory',
    'factory/<alias:[\w\-]+>' => 'catalog/factory/view',
    'factory/<alias:[\w\-]+>/<tab:(collections|articles|catalogs|samples|pricelists|grezzo|orders|working-conditions|subdivision)>' => 'catalog/factory/view-tab',

    'catalog/factory/click-on-file' => 'catalog/factory/click-on-file',
    'product/ajax-get-compositions' => 'catalog/product/ajax-get-compositions',
    'product/<alias:[\w\-]+>' => 'catalog/product/view',
    'sale-product/<alias:[\w\-]+>' => 'catalog/sale/view',
    'factories/<letter:[\w\-]>' => 'catalog/factory/list',
    'factories' => 'catalog/factory/list',
    'sale' => 'catalog/sale/list',
    'catalog/sale/ajax-get-filter' => 'catalog/sale/ajax-get-filter',
    'catalog/sale/ajax-get-filter-sizes' => 'catalog/sale/ajax-get-filter-sizes',
    'catalog/sale/ajax-get-phone' => 'catalog/sale/ajax-get-phone',

    'product-stats' => 'catalog/product-stats/list',
    'product-stats/<id:[\d\-]+>' => 'catalog/product-stats/view',

    'sale-stats' => 'catalog/sale-stats/list',
    'sale-stats/<id:[\d\-]+>' => 'catalog/sale-stats/view',

    'sale-italy-stats' => 'catalog/sale-italy-stats/list',
    'sale-italy-stats/<id:[\d\-]+>' => 'catalog/sale-italy-stats/view',

    'factory-stats' => 'catalog/factory-stats/list',
    'factory-stats/<alias:[\w\-]+>' => 'catalog/factory-stats/view',

    // Factory product
    'factory-collections' => 'catalog/factory-collections/list',
    'factory-collections/create' => 'catalog/factory-collections/create',
    'factory-collections/update/<id:[\d\-]+>' => 'catalog/factory-collections/update',

    // Factory catalogs files
    'factory-catalogs-files' => 'catalog/factory-catalogs-files/list',
    'factory-catalogs-files/one-file-upload' => 'catalog/factory-catalogs-files/one-file-upload',
    'factory-catalogs-files/one-file-delete' => 'catalog/factory-catalogs-files/one-file-delete',
    'factory-catalogs-files/create' => 'catalog/factory-catalogs-files/create',
    'factory-catalogs-files/update/<id:[\d\-]+>' => 'catalog/factory-catalogs-files/update',

    // Factory prices files
    'factory-prices-files' => 'catalog/factory-prices-files/list',
    'factory-prices-files/one-file-upload' => 'catalog/factory-prices-files/one-file-upload',
    'factory-prices-files/one-file-delete' => 'catalog/factory-prices-files/one-file-delete',
    'factory-prices-files/create' => 'catalog/factory-prices-files/create',
    'factory-prices-files/update/<id:[\d\-]+>' => 'catalog/factory-prices-files/update',

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
    'catalog/sale-italy/ajax-get-filter' => 'catalog/sale-italy/ajax-get-filter',
    'catalog/sale-italy/ajax-get-filter-sizes' => 'catalog/sale-italy/ajax-get-filter-sizes',

    //
    'italian-product' => 'catalog/italian-product/list',
    'italian-product/completed' => 'catalog/italian-product/completed',
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

    //GREZZO
    'italian-product-grezzo' => 'catalog/italian-product-grezzo/list',
    'italian-product-grezzo/completed' => 'catalog/italian-product-grezzo/completed',
    'italian-product-grezzo/free-create' => 'catalog/italian-product-grezzo/free-create',
    'italian-product-grezzo/interest-payment/<id:[\d\-]+>' => 'catalog/italian-product-grezzo/interest-payment',
    'italian-product-grezzo/payment' => 'catalog/italian-product-grezzo/payment',
    'italian-product-grezzo/update/<id:[\d\-]+>/<step:(photo|check|payment|promotion)>' => 'catalog/italian-product-grezzo/update',
    'italian-product-grezzo/update/<id:[\d\-]+>' => 'catalog/italian-product-grezzo/update',
    'italian-product-grezzo/is-sold/<id:[\d\-]+>' => 'catalog/italian-product-grezzo/is-sold',
    'italian-product-grezzo/on-moderation/<id:[\d\-]+>' => 'catalog/italian-product-grezzo/on-moderation',
    'italian-product-grezzo/intrash/<id:[\d\-]+>' => 'catalog/italian-product-grezzo/intrash',
    'italian-product-grezzo/change-tariff/<id:[\d\-]+>' => 'catalog/italian-product-grezzo/change-tariff',

    'catalog/italian-product-grezzo/fileupload' => 'catalog/italian-product-grezzo/fileupload',
    'catalog/italian-product-grezzo/filedelete' => 'catalog/italian-product-grezzo/filedelete',
    'catalog/italian-product-grezzo/one-file-upload' => 'catalog/italian-product-grezzo/one-file-upload',
    'catalog/italian-product-grezzo/one-file-delete' => 'catalog/italian-product-grezzo/one-file-delete',

    // Factory promotion
    'factory-promotion' => 'catalog/factory-promotion/list',
    'factory-promotion/create' => 'catalog/factory-promotion/create',
    'factory-promotion/create-payment/<id:[\d\-]+>' => 'catalog/factory-promotion/create-payment',
    'factory-promotion/notify' => 'catalog/factory-promotion/notify',
    'factory-promotion/update/<id:[\d\-]+>' => 'catalog/factory-promotion/update',
    'factory-promotion/payment/<id:[\d\-]+>' => 'catalog/factory-promotion/payment',
    'factory-promotion/intrash/<id:[\d\-]+>' => 'catalog/factory-promotion/intrash',

    // Partner promotion
    'italian-promotion' => 'catalog/italian-promotion/list',
    'italian-promotion/create' => 'catalog/italian-promotion/create',
    'italian-promotion/create-payment/<id:[\d\-]+>' => 'catalog/italian-promotion/create-payment',
    'italian-promotion/notify' => 'catalog/italian-promotion/notify',
    'italian-promotion/update/<id:[\d\-]+>' => 'catalog/italian-promotion/update',
    'italian-promotion/intrash/<id:[\d\-]+>' => 'catalog/italian-promotion/intrash',


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
    'partner-payment/tariffs' => 'payment/partner-payment/tariffs',
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
    'forms/feedback-partner' => 'forms/forms/feedback-partner',
    'forms/ajax-get-form-feedback' => '/forms/forms/ajax-get-form-feedback',
    'forms/click-on-become-partner' => 'forms/click-on-become-partner/index',

    // Module [[SEO]]
    'page/sitemap' => 'seo/sitemap-html/index',

    //'sitemap/pathcache' => 'seo/pathcache/pathcache/index',
    //'sitemap/fill' => 'seo/sitemap/fill/index',
    //'sitemap/create' => 'seo/sitemap/create/index',

    // Module [[Shop]]
    'shop/widget' => 'shop/widget/index',
    'shop/widget/ajax-request-price' => 'shop/widget/ajax-request-price',
    'shop/widget/ajax-request-price-popup' => 'shop/widget/ajax-request-price-popup',
    'orders/notepad' => 'shop/cart/notepad',
    'shop/order/create/<product_id:[\d\-]+>' => 'shop/order/create',
    'shop/order/list' => 'shop/order/list',
    'shop/order/view/<id:[\d\-]+>' => 'shop/order/view',
    'shop/order/link/<token:[\w\-]+>' => 'shop/order/link',

    'shop/cart/request-find-product' => 'shop/cart/request-find-product',
    'shop/cart/ajax-get-request-find-product' => 'shop/cart/ajax-get-request-find-product',

    'shop/cart/add-to-cart' => 'shop/cart/add-to-cart',
    'shop/cart/delete-from-cart' => 'shop/cart/delete-from-cart',
    'shop/cart/delete-from-cart-popup' => 'shop/cart/delete-from-cart-popup',
    'shop/order-answer-stats/list' => 'shop/order-answer-stats/list',
    'shop/order-answer-stats/view/<id:[\d\-]+>' => 'shop/order-answer-stats/view',

    'shop/factory/orders' => 'shop/factory-order/list',
    'shop/factory/pjax-save-order-answer' => 'shop/factory-order/pjax-save-order-answer',
    'shop/factory/orders-italy' => 'shop/factory-order/list-italy',

    'admin/order/update/<id:[\d\-]+>' => 'shop/admin-order/update',
    'admin/order/manager/<id:[\d\-]+>' => 'shop/admin-order/manager',

    'admin/order-comment/reminder' => 'shop/order-comment/reminder',
    'admin/order-comment/processed/<id:[\d\-]+>' => 'shop/order-comment/processed',

    'admin/orders' => 'shop/admin-order/list',
    'admin/orders-italy' => 'shop/admin-order/list-italy',
    'admin/orders/pjax-save-order-answer' => 'shop/admin-order/pjax-save-order-answer',

    'partner/orders' => 'shop/partner-order/list',
    'partner/orders-italy' => 'shop/partner-order/list-italy',
    'partner/delivery-italian-orders' => 'shop/partner-order/delivery-italian-orders',
    'partner/orders/pjax-save-order-answer' => 'shop/partner-order/pjax-save-order-answer',

    // market-order
    'shop/market/market-order-admin/list' => 'shop/market/market-order-admin/list',
    'shop/market/market-order-admin/create' => 'shop/market/market-order-admin/create',
    'shop/market/market-order-admin/update/<id:[\d\-]+>' => 'shop/market/market-order-admin/update',

    'shop/market/market-order-partner/list' => 'shop/market/market-order-partner/list',
    'shop/market/market-order-partner/update/<id:[\d\-]+>' => 'shop/market/market-order-partner/update',

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

if (in_array(DOMAIN_TYPE, ['de', 'fr', 'com', 'co.il'])) {
    $urls['contacts'] = 'page/contacts/list-partners';
}

return $urls;
