<?php

namespace backend\modules\sys\modules\mailcarrier\models;

use yii\helpers\ArrayHelper;

/**
 * Class GroupLang
 *
 * @package backend\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailBoxLang extends \thread\modules\sys\modules\mailcarrier\models\MailBoxLang
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
