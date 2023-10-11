<?php

namespace backend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\user\models\User;
use backend\modules\location\models\Country;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Factory as CommonFactoryModel;
use common\actions\upload\UploadBehavior;

/**
 * Class Factory
 *
 * @package backend\modules\catalog\models
 */
class Factory extends CommonFactoryModel implements BaseBackendModel
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'image_link' => [
                        'path' => Yii::$app->getModule('catalog')->getFactoryUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getFactoryUploadPath(),
                    ]
                ]
            ],
        ]);
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'id', 'title');
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownListProducingCountry()
    {
        $query = self::find()
            ->indexBy('producing_country_id')
            ->select('producing_country_id, count(producing_country_id) as count')
            ->groupBy('producing_country_id')
            ->andWhere('producing_country_id > 0')
            ->asArray()
            ->all();

        $ids = [];

        foreach ($query as $item) {
            $ids[] = $item['producing_country_id'];
        }

        if ($ids) {
            return ArrayHelper::map(
                Country::findBase()->andWhere(['IN', Country::tableName() . '.id', $ids])->all(),
                'id',
                'lang.title'
            );
        } else {
            return [];
        }
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownListEditor()
    {
        $query = self::find()
            ->indexBy('editor_id')
            ->select('editor_id, count(editor_id) as count')
            ->groupBy('editor_id')
            ->andWhere('editor_id > 0')
            ->asArray()
            ->all();

        $ids = [];

        foreach ($query as $item) {
            $ids[] = $item['editor_id'];
        }

        if ($ids) {
            return ArrayHelper::map(
                User::findBase()->andWhere(['IN', User::tableName() . '.id', $ids])->all(),
                'id',
                'profile.fullName'
            );
        } else {
            return [];
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return self::findBase()->byID($id)->one();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Factory())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function searchTranslation($params)
    {
        return (new search\Factory())->searchTranslation($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Factory())->trash($params);
    }
}
