<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use frontend\modules\catalog\models\Collection as CommonCollection;

/**
 * Class FactoryCollection
 *
 * @package frontend\modules\catalog\models
 */
class FactoryCollection extends CommonCollection
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(CommonCollection::behaviors(), []);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(CommonCollection::rules(), []);
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->user_id = Yii::$app->user->identity->id;
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(CommonCollection::scenarios(), [
            'frontend' => ['factory_id', 'user_id', 'title', 'first_letter', 'published', 'deleted'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(CommonCollection::attributeLabels(), []);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->andWhere([self::tableName() . '.factory_id' => Yii::$app->user->identity->profile->factory_id])
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\FactoryCollection())->search($params);
    }
}
