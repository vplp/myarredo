<?php

namespace frontend\modules\catalog\models;

use yii\helpers\ArrayHelper;
//
use common\modules\catalog\models\ProductLang as CommonProductLang;

/**
 * Class FactoryProductLang
 *
 * @package frontend\modules\catalog\models
 */
class FactoryProductLang extends ProductLang
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(CommonProductLang::behaviors(), []);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(CommonProductLang::rules(), [
            'frontend' => ['title', 'description', 'content', 'comment'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(CommonProductLang::attributeLabels(), []);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(CommonProductLang::rules(), []);
    }
}
