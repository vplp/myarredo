<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\Url;

/**
 * Class Factory
 *
 * @package frontend\modules\catalog\models
 */
class FactoryPromotion extends \common\modules\catalog\models\FactoryPromotion
{
    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (Yii::$app->user->identity->group->role == 'factory') {
            $this->user_id = Yii::$app->user->identity->id;
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()
            ->andWhere([self::tableName() . '.factory_id' => Yii::$app->user->identity->profile->factory_id])
            ->enabled();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * Search
     *
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\FactoryPromotion())->search($params);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['/catalog/factory-promotion/update', 'alias' => $this->id]);
    }
}