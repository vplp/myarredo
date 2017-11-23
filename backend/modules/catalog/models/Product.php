<?php

namespace backend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use thread\app\base\models\ActiveRecord;
use thread\app\model\interfaces\BaseBackendModel;
use common\helpers\Inflector;
use common\modules\catalog\models\Product as CommonProductModel;

/**
 * Class Product
 *
 * @package backend\modules\catalog\models
 */
class Product extends CommonProductModel implements BaseBackendModel
{
    public $parent_id = 0;

//    /**
//     * @return array
//     */
//    public function behaviors()
//    {
//        return ArrayHelper::merge(parent::behaviors(), [
//            [
//                'class' => AttributeBehavior::className(),
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
//                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
//                ],
//                'value' => function ($event) {
//                    return Inflector::slug($this->alias, '_');
//                },
//            ],
//        ]);
//    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Product())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Product())->trash($params);
    }

    public function afterDelete()
    {
        //Update Product Count In to Group
        Category::updateEnabledProductCounts();

        parent::afterDelete();
    }
}
