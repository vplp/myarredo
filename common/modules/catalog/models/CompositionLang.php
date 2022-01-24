<?php

namespace common\modules\catalog\models;

use yii\helpers\ArrayHelper;

/**
 * Class CompositionLang
 *
 * @package common\modules\catalog\models
 */
class CompositionLang extends ProductLang
{
    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'backend' => ['title', 'description']
        ]);
    }
}
