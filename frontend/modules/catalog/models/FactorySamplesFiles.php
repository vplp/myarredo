<?php

namespace frontend\modules\catalog\models;

use common\modules\catalog\models\FactorySamplesFiles as CommonFactorySamplesFiles;
use Throwable;
use Yii;
use yii\helpers\ArrayHelper;
use \yii\data\ActiveDataProvider;

class FactorySamplesFiles extends CommonFactorySamplesFiles
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), []);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), []);
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'frontend' => [
                'factory_id',
                'title',
                'file_link',
                'file_type',
                'file_size'
            ],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), []);
    }

    /**
     * @param bool $insert
     * 
     * @return bool
     * 
     * @throws Throwable
     */
    public function beforeSave($insert): bool
    {
        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $this->factory_id = Yii::$app->user->identity->profile->factory_id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params): ActiveDataProvider
    {
        return (new search\FactorySamplesFiles())->search($params);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }
}