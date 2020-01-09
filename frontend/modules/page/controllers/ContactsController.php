<?php

namespace frontend\modules\page\controllers;

use Yii;
use frontend\modules\user\models\User;
use frontend\components\BaseController;

/**
 * Class ContactsController
 *
 * @package frontend\modules\page\controllers
 */
class ContactsController extends BaseController
{
    public $title;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $partners = User::getPartners(Yii::$app->city->getCityId());

        $this->title = Yii::t('app', 'Партнеры сети MYARREDO в') . ' ' .
            Yii::$app->city->getCityTitleWhere();

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('app', 'Сеть салонов мебели «myARREDO» предлагает элитную мебель только итальянского производства. Контакты в') . ' ' .
                Yii::$app->city->getCityTitleWhere(),
        ]);

        return $this->render('contacts', [
            'partners' => $partners,
        ]);
    }

    /**
     * @return string
     */
    public function actionListPartners()
    {
        $this->title = Yii::t('app', 'Все офисы продаж');

        return $this->render('list_partners');
    }
}
