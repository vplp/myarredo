<?php
return [
    'gii' => 'gii',

    // Module [[Home]]
    '' => 'home/home/index',

    // Module [[Users]]
    'register' => 'user/register',
    'login' => 'user/login',
    'logout' => 'user/logout',
    'change-password' => 'user/profile/password-change',
    'profile' => 'user/profile/index',
    'request-password-reset' => 'user/profile/request-password-reset',
    'reset-password' => 'user/profile/reset-password',

    // Module [[News]]
    'news/<alias:[\w\-]+>' => 'news/list/index',
    'news' => 'news/list/index',
    'news/article/<alias:[\w\-]+>' => 'news/article/index',

    // Module [[Page]]
    '<alias:[\w\-]+>' => 'page/page/view',
    'find/<condition:[\w\-]+>' => 'page/find/index',

    // Module [[Forms]]
    'forms/feedbackform/captcha'=>'forms/feedbackform/captcha',
    'forms/feedbackform/add' => 'forms/feedbackform/add',

    // Module [[SEO]]
    'sitemap/filling' => 'seo/sitemap/filling',
    'sitemap/mapcreate' => 'seo/sitemap/mapcreate',

    // Module [[Shop]]
    'shop/widget' => 'shop/widget/index',
    'shop/cart/index' => 'shop/cart/index',
    'shop/cart/send-order' => 'shop/cart/send-order',
    'shop/order/list' => 'shop/order/list',
    'shop/order/view/<id:[\d\-]+>' => 'shop/order/view',
    'shop/order/link/<token:[\w\-]+>' => 'shop/order/link',
    'shop/cart/add-to-cart' => 'shop/cart/add-to-cart',

];
