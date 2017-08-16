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
     * @return bool
     */
    public function beforeValidate()
    {
        $this->alias = $this->types->lang->title
            . ' ' . $this->factory->lang->title
            . ' ' . $this->collection->lang->title
            . (($this->article) ? ' ' . $this->article : '');

        return parent::beforeValidate();
    }

    /**
     * @param $text
     * @param string $replacement
     * @return mixed|string
     */
    public static function slugify($text, $replacement = '-')
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', $replacement, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $replacement);

        // remove duplicate -
        $text = preg_replace('~-+~', $replacement, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return '';
        }

        return $text;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
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
}
