<?php

namespace frontend\modules\user\widgets\menu;

use Yii;
use yii\base\Widget;

/**
 * Class PartnerInfo
 *
 * @package frontend\modules\user\widgets\menu
 */
class UserMenu extends Widget
{
    /**
     * @var string
     */
    public $view = 'user_menu';

    /**
     * @var array
     */
    public $menuItems = [];

    /**
     * @throws \Throwable
     */
    public function init()
    {
        parent::init();

        if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['logistician'])) {
            $this->menuItems = [
                [
                    'label' => Yii::t('app', 'Orders italy'),
                    'url' => ['/shop/partner-order/list-italy']
                ],
                [
                    'label' => Yii::t('app', 'Оплатить заявки на доставку'),
                    'url' => ['/shop/partner-order/delivery-italian-orders']
                ],
            ];
        } elseif (!Yii::$app->getUser()->isGuest &&
            in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->country_id &&
            Yii::$app->user->identity->profile->country_id == 4
        ) {
            $this->menuItems = [
                [
                    'label' => Yii::t('app', 'Furniture in Italy'),
                    'url' => ['/catalog/italian-product/list']
                ],
                [
                    'label' => Yii::t('app', 'Рекламные кампании'),
                    'url' => ['/catalog/italian-promotion/list']
                ],
                [
                    'label' => Yii::t('app', 'Orders'),
                    'url' => ['/shop/partner-order/list']
                ],
                [
                    'label' => Yii::t('app', 'Orders italy'),
                    'url' => ['/shop/partner-order/list-italy']
                ],
                [
                    'label' => Yii::t('app', 'General rules'),
                    'url' => ['/rules/rules/list']
                ],
                [
                    'label' => Yii::t('app', 'Платежная информация'),
                    'url' => ['/payment/partner-payment/list']
                ],
            ];
        } elseif (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['partner'])) {
            $this->menuItems = [
                [
                    'label' => Yii::t('app', 'Sale'),
                    'url' => ['/catalog/partner-sale/list']
                ],
                [
                    'label' => Yii::t('market', 'Market order'),
                    'url' => ['/shop/market/market-order-partner/list']
                ],
                [
                    'label' => Yii::t('app', 'Orders'),
                    'url' => ['/shop/partner-order/list']
                ],
                [
                    'label' => Yii::t('app', 'Orders italy'),
                    'url' => ['/shop/partner-order/list-italy']
                ],
                [
                    'label' => Yii::t('app', 'Размещение кода'),
                    'url' => ['/page/page/view', 'alias' => 'razmeshchenie-koda']
                ],
                [
                    'label' => Yii::t('app', 'Инструкция партнерам'),
                    'url' => ['/page/page/view', 'alias' => 'instructions']
                ],
                [
                    'label' => Yii::t('app', 'Тарифы'),
                    'url' => ['/payment/partner-payment/tariffs']
                ],
            ];
        } elseif (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $this->menuItems = [
                [
                    'label' => Yii::t('market', 'Market order'),
                    'url' => ['/shop/market/market-order-admin/list']
                ],
                [
                    'label' => Yii::t('app', 'Orders'),
                    'url' => ['/shop/admin-order/list']
                ],
                [
                    'label' => Yii::t('app', 'Orders italy'),
                    'url' => ['/shop/admin-order/list-italy']
                ],
                [
                    'label' => Yii::t('app', 'Answers statistics'),
                    'url' => ['/shop/order-answer-stats/list']
                ],
                [
                    'label' => Yii::t('app', 'Product statistics'),
                    'url' => ['/catalog/product-stats/list']
                ],
                [
                    'label' => Yii::t('app', 'Sale statistics'),
                    'url' => ['/catalog/sale-stats/list']
                ],
                [
                    'label' => Yii::t('app', 'Sale in Italy statistics'),
                    'url' => ['/catalog/sale-italy-stats/list']
                ],
                [
                    'label' => Yii::t('app', 'Factory statistics'),
                    'url' => ['/catalog/factory-stats/list']
                ]
            ];
        } elseif (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['settlementCenter'])) {
            $this->menuItems = [
                [
                    'label' => Yii::t('app', 'Orders'),
                    'url' => ['/shop/admin-order/list']
                ],
                [
                    'label' => Yii::t('market', 'Market order'),
                    'url' => ['/shop/market/market-order-admin/list']
                ],
            ];
        } elseif (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->menuItems = [
                [
                    'label' => isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 4
                        ? Yii::t('app', 'Furniture in Italy')
                        : Yii::t('app', 'Наличие на складе'),
                    'url' => ['/catalog/italian-product/list']
                ],
                [
                    'label' => Yii::t('app', 'Занести Гредзо'),
                    'url' => ['/catalog/italian-product-grezzo/list']
                ],
                [
                    'label' => Yii::t('app', 'My goods'),
                    'url' => ['/catalog/factory-product/list']
                ],
                [
                    'label' => Yii::t('app', 'Collections'),
                    'url' => ['/catalog/factory-collections/list']
                ],
                [
                    'label' => Yii::t('app', 'Каталоги'),
                    'url' => ['/catalog/factory-catalogs-files/list']
                ],
                [
                    'label' => Yii::t('app', 'Прайс листы'),
                    'url' => ['/catalog/factory-prices-files/list']
                ],
                [
                    'label' => Yii::t('app', 'Рекламные кампании'),
                    'url' => ['/catalog/factory-promotion/list'],
                    'visible' => false
                ],
                [
                    'label' => Yii::t('app', 'Orders'),
                    'url' => ['/shop/factory-order/list']
                ],
                [
                    'label' => isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 4
                        ? Yii::t('app', 'Orders italy')
                        : Yii::t('app', 'Заявки на наличие на складе'),
                    'url' => ['/shop/factory-order/list-italy']
                ],
                [
                    'label' => Yii::t('app', 'Product statistics'),
                    'url' => ['/catalog/product-stats/list']
                ],
                [
                    'label' => isset(Yii::$app->user->identity->profile->factory) && Yii::$app->user->identity->profile->factory->producing_country_id == 4
                        ? Yii::t('app', 'Sale in Italy statistics')
                        : Yii::t('app', 'Статистка на наличие на складе'),
                    'url' => ['/catalog/sale-italy-stats/list']
                ],
                [
                    'label' => Yii::t('app', 'Factory statistics'),
                    'url' => [
                        '/catalog/factory-stats/view',
                        'alias' => Yii::$app->user->identity->profile->factory
                            ? Yii::$app->user->identity->profile->factory->alias
                            : ''
                    ],
                    'visible' => Yii::$app->user->identity->profile->factory ? true : false
                ],
                [
                    'label' => Yii::t('app', 'General rules'),
                    'url' => ['/rules/rules/list']
                ],
                [
                    'label' => Yii::t('app', 'Платежная информация'),
                    'url' => ['/payment/partner-payment/list'],
                    'visible' => false
                ],
            ];
        } else {
            $this->menuItems = [
                [
                    'label' => Yii::t('app', 'Orders'),
                    'url' => ['/shop/order/list']
                ]
            ];
        }

        $this->menuItems[] = [
            'options' => ['role' => 'separator', 'class' => 'divider']
        ];

        $this->menuItems[] = [
            'label' => Yii::t('app', 'Profile'),
            'url' => ['/user/profile/index']
        ];

        $this->menuItems[] = [
            'label' => Yii::t('app', 'Sign Up'),
            'url' => ['/user/logout/index']
        ];
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->render($this->view, ['menuItems' => $this->menuItems]);
        }
    }
}
