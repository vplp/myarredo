<?php

namespace backend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;
//
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
     * @return bool
     */
    public function beforeValidate()
    {
        $title = (Yii::$app->request->post('FactoryLang'))['title'];

        $this->first_letter = mb_strtoupper(mb_substr(trim($title), 0, 1, 'UTF-8'), 'UTF-8');
        $this->alias = $title;

        return parent::beforeValidate();
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
    public function trash($params)
    {
        return (new search\Factory())->trash($params);
    }
}
