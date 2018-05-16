<?php

return [
    [
        'pattern' => 'robots',
        'route' => 'seo/robots/index',
        'suffix' => '.txt'
    ],

    // Module [[Home]]
    '' => 'home/home/index',
    'contacts' => 'page/contacts/index',
    'partners-map' => 'page/contacts/list-partners',

    // Module [[Users]]
    'partner/registration' => 'user/register/partner',
    'factory/registration' => 'user/register/factory',
    'user/register' => 'user/register/user',
    'user/login' => 'user/login/index',
    'user/logout' => 'user/logout/index',
    'user/profile' => 'user/profile/index',
    'user/profile/update' => 'user/profile/update',
    'user/password/request' => 'user/password/request-reset',
    'user/password/change' => 'user/password/change',
    'user/password/reset' => 'user/password/reset',
    'user/profile/fileupload' => 'user/profile/fileupload',
    'user/login/validation' => 'user/login/validation',

    // Module [[Catalog]]
    'catalog/elastic/search' => 'catalog/elastic/search',
    'catalog/elastic/index' => 'catalog/elastic/index',

    'catalog/<filter:[\=\;\-\w\d]+>' => 'catalog/category/list',
    'catalog/category/ajax-get-types' => 'catalog/category/ajax-get-types',
    'catalog/category/ajax-get-category' => 'catalog/category/ajax-get-category',
    'sale/<filter:[\=\;\-\/\w\d]+>' => 'catalog/sale/list',
    'factory/<alias:(nieri|tomassi_cucine)>' => 'catalog/template-factory/factory',
    'factory/<alias:[\w\-]+>' => 'catalog/factory/view',
    'product/<alias:[\w\-]+>' => 'catalog/product/view',
    'sale-product/<alias:[\w\-]+>' => 'catalog/sale/view',
    'catalog' => 'catalog/category/list',
    'factories/<letter:[\w\-]>' => 'catalog/factory/list',
    'factories' => 'catalog/factory/list',
    'sale' => 'catalog/sale/list',
    'catalog/sale/ajax-get-phone' => 'catalog/sale/ajax-get-phone',

    'product-stats' => 'catalog/product-stats/list',
    'product-stats/<id:[\d\-]+>' => 'catalog/product-stats/view',

    'factory-stats' => 'catalog/factory-stats/list',
    'factory-stats/<alias:[\w\-]+>' => 'catalog/factory-stats/view',

    'factory/<alias:(nieri|tomassi_cucine)>/contacts' => 'catalog/template-factory/contacts',
    'factory/<alias:(nieri|tomassi_cucine)>/catalog/<filter:[\=\;\-\w\d]+>' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri|tomassi_cucine)>/catalog' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri|tomassi_cucine)>/sale' => 'catalog/template-factory/sale',
    'factory/<alias:(nieri|tomassi_cucine)>/product/<product:[\w\-]+>' => 'catalog/template-factory/product',
    'factory/<alias:(nieri|tomassi_cucine)>/sale-product/<product:[\w\-]+>' => 'catalog/template-factory/sale-product',

    'partner/sale' => 'catalog/partner-sale/list',
    'partner/sale/create' => 'catalog/partner-sale/create',
    'partner/sale/update/<id:[\d\-]+>' => 'catalog/partner-sale/update',
    'partner/sale/intrash/<id:[\d\-]+>' => 'catalog/partner-sale/intrash',
    'catalog/partner-sale/fileupload' => 'catalog/partner-sale/fileupload',
    'catalog/partner-sale/filedelete' => 'catalog/partner-sale/filedelete',

    // Module [[News]]
    'news/<alias:[\w\-]+>' => 'news/list/index',
    'news' => 'news/list/index',
    'news/article/<alias:[\w\-]+>' => 'news/article/index',

    // Module [[Feedback]]
    'page/contact' => 'feedback/feedback/index',
    'page/contact/send' => 'feedback/form/send',

    // Module [[Page]]
    '<alias:[\w\-]+>' => 'page/page/view',
    'find/<condition:[\w\-]+>' => 'page/find/index',

    // Module [[Forms]]
    'forms/feedbackform/captcha' => 'forms/feedbackform/captcha',
    'forms/feedbackform/add' => 'forms/feedbackform/add',

    // Module [[SEO]]
    'page/sitemap' => 'seo/sitemaphtml/index',
    //
    'sitemap/pathcache' => 'seo/pathcache/pathcache/index',
    'sitemap/fill' => 'seo/sitemap/fill/index',
    'sitemap/create' => 'seo/sitemap/create/index',

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
    'shop/factory-order/list' => 'shop/factory-order/list',
    'admin/orders' => 'shop/admin-order/list',
    'partner/orders' => 'shop/partner-order/list',
    'partner/orders/pjax-save' => 'shop/partner-order/pjax-save',
    'partner/orders/send-answer' => 'shop/partner-order/send-answer',

    // Module [[Location]]
    'location/location/get-cities' => 'location/location/get-cities',

    // Module [[Banner]]
    'banner/factory-banner/list' => 'banner/factory-banner/list',
    'banner/factory-banner/create' => 'banner/factory-banner/create',
    'banner/factory-banner/intrash/<id:[\d\-]+>' => 'banner/factory-banner/intrash',
    'banner/factory-banner/update/<id:[\d\-]+>' => 'banner/factory-banner/update',
    'banner/factory-banner/fileupload' => 'banner/factory-banner/fileupload',
    'banner/factory-banner/filedelete' => 'banner/factory-banner/filedelete',
];
