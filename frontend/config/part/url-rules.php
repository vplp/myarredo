<?php
return [
    // Module [[Home]]
    '' => 'home/home/index',
    'contacts' => 'page/contacts/index',
    'partners-map' => 'page/contacts/list-partners',

    // Module [[Users]]
    'partner/registration' => 'user/register/partner',
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
    'catalog/<filter:[\;\-\w\d]+>' => 'catalog/category/list',
    'sale/<filter:[\;\-\/\w\d]+>' => 'catalog/sale/list',

    'factory/<alias:(nieri)>' => 'catalog/template-factory/factory',

    'factory/<alias:[\w\-]+>' => 'catalog/factory/view',
    'product/<alias:[\w\-]+>' => 'catalog/product/view',
    'sale-product/<alias:[\w\-]+>' => 'catalog/sale/view',
    'catalog' => 'catalog/category/list',
    'factories/<letter:[\w\-]>' => 'catalog/factory/list',
    'factories' => 'catalog/factory/list',
    'sale' => 'catalog/sale/list',

    'factory/<alias:(nieri)>/contacts' => 'catalog/template-factory/contacts',
    'factory/<alias:(nieri)>/catalog/<filter:[\;\-\w\d]+>' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri)>/catalog' => 'catalog/template-factory/catalog',
    'factory/<alias:(nieri)>/product/<product:[\w\-]+>' => 'catalog/template-factory/product',

    'partner/sale' => 'catalog/partner-sale/list',
    'partner/sale/create' => 'catalog/partner-sale/create',
    'partner/sale/update/<id:[\d\-]+>' => 'catalog/partner-sale/update',
    'catalog/partner-sale/fileupload' => 'catalog/partner-sale/fileupload',
    'catalog/partner-sale/filedelete' => 'catalog/partner-sale/filedelete',
    'partner/mailing-by-cities' => 'catalog/partner-sale/mailing-by-cities',

    'razmeshchenie_koda' => 'catalog/partner-sale/code',
    'instruktsiya_partneram' => 'catalog/partner-sale/instructions',

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
    'partner/orders' => 'shop/partner-order/list',
    'shop/factory-order/list' => 'shop/factory-order/list',
    'admin/orders' => 'shop/admin-order/list',
    //'partner/orders/view/<id:[\d\-]+>' => 'shop/partner-order/view',

    // Module [[Location]]
    'location/location/get-cities' => 'location/location/get-cities',

    'banner/factory-banner/list' => 'banner/factory-banner/list',
    'banner/factory-banner/update/<id:[\d\-]+>' => 'banner/factory-banner/update',
    'banner/factory-banner/fileupload' => 'banner/factory-banner/fileupload',
    'banner/factory-banner/filedelete' => 'banner/factory-banner/filedelete',

];
