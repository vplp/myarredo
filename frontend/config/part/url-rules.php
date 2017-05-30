<?php
return [
    'gii' => 'gii',

    // Module [[Home]]
    '' => 'home/home/index',

    // Module [[Users]]
    'register' => 'user/register/index',
    'login' => 'user/login/index',
    'logout' => 'user/login/index',
    'change-password' => 'user/profile/password-change',
    'profile' => 'user/profile/index',
    'update' => 'user/profile/update',
    'request-password-reset' => 'user/profile/request-password-reset',
    'reset-password' => 'user/profile/reset-password',
    'user/profile/fileupload' => 'user/profile/fileupload',

    // Module [[News]]
    'news/<alias:[\w\-]+>' => 'news/list/index',
    'news' => 'news/list/index',
    'news/article/<alias:[\w\-]+>' => 'news/article/index',

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

];
