<?php

namespace backend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Product as CommonProductModel;

/**
 * Class Product
 *
 * @package backend\modules\catalog\models
 */
class Product extends CommonProductModel implements BaseBackendModel
{
    public $parent_id = 0;

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->alias = $this->types->lang->title
            . ' ' . $this->factory->lang->title
            . ' ' . $this->collection->lang->title
            . (($this->article) ? ' ' . $this->article : '');

        if ($this->id) {
            $this->alias = $this->id . ' ' . $this->alias;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // delete relation ProductRelSpecification
        ProductRelSpecification::deleteAll(['catalog_item_id' => $this->id]);

        // save relation ProductRelSpecification
        if (Yii::$app->request->getBodyParam('SpecificationValue')) {
            foreach (Yii::$app->request->getBodyParam('SpecificationValue') as $specification_id => $val) {
                if ($val) {
                    $model = new ProductRelSpecification();
                    $model->setScenario('backend');
                    $model->catalog_item_id = $this->id;
                    $model->specification_id = $specification_id;
                    $model->val = $val;
                    $model->save();
                }
            }
        }

        //Update Product Count In to Group
        Category::updateEnabledProductCounts();

        parent::afterSave($insert, $changedAttributes);
    }

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
