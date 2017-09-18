<?php
return [
    'gii' => 'gii',

    // Module [[Home]]
    '' => 'home/home/index',

    // Module [[Users]]
    'partner/registration' => 'user/partner/register',
    'user/register' => 'user/register/index',
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

    //'catalog/<alias:[\w\-]+>' => 'catalog/category/list',
//    'catalog/<category:[a-z_]+>' => 'catalog/category/list',
//    'catalog/<category:[a-z_]+>--<type:[a-z_]+>' => 'catalog/category/list',
//    'catalog/<category:[a-z_]+>--<type:[a-z_]+>--<style:[a-z_]+>' => 'catalog/category/list',
//    'catalog/<category:[a-z_]+>--<type:[a-z_]+>--<style:[a-z_]+>--<factory:[a-z_]+>' => 'catalog/category/list',

    'catalog/<filter:[\;\-\/\w\d]+>' => 'catalog/category/list',
    'factory/<letter:[\w\-]>' => 'catalog/factory/list',
    'factory/<alias:[\w\-]+>' => 'catalog/factory/view',
    'product/<alias:[\w\-]+>' => 'catalog/product/view',
    'sale-product/<alias:[\w\-]+>' => 'catalog/sale/view',
    'catalog' => 'catalog/category/list',
    'factories' => 'catalog/factory/list',
    'sale' => 'catalog/sale/list',
    'partner/sale' => 'catalog/sale/partner-list',
    'partner/sale/create' => 'catalog/sale/create',
    'partner/sale/update/<id:[\d\-]+>' => 'catalog/sale/create',

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
    'shop/cart/index' => 'shop/cart/index',
    'shop/cart/send-order' => 'shop/cart/send-order',
    'shop/order/list' => 'shop/order/list',
    'shop/order/view/<id:[\d\-]+>' => 'shop/order/view',
    'shop/order/link/<token:[\w\-]+>' => 'shop/order/link',
    'shop/cart/add-to-cart' => 'shop/cart/add-to-cart',

    'location/location/get-cities' => 'location/location/get-cities'
];
