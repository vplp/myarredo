<?php

namespace common\modules\sys\modules\configs\models;

use yii\helpers\ArrayHelper;

/**
 * Class Params
 *
 * @package common\modules\sys\modules\configs\models
 */
class Params extends \thread\modules\sys\modules\configs\models\Params
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['value', 'string'],
        ]);
    }
}
