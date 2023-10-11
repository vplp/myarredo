<?php

namespace backend\modules\files\models;

use yii\helpers\ArrayHelper;
/**
 * Class Files
 *
 * @package backend\modules\files\models
 */
class FilesLang extends \common\modules\files\models\FilesLang
{
    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'title' => ['title'],
        ]);
    }
}