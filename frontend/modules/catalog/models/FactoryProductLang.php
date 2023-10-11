<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\catalog\models\ProductLang as CommonProductLang;

/**
 * Class FactoryProductLang
 *
 * @package frontend\modules\catalog\models
 */
class FactoryProductLang extends CommonProductLang
{
    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(CommonProductLang::scenarios(), [
            'setImages' => [],
        ]);
    }
}
