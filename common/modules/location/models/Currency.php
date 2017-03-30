<?php
namespace common\modules\location\models;

use yii\helpers\ArrayHelper;

/**
 * Class Currency
 *
 * @package common\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Currency extends \thread\modules\location\models\Currency
{
    /**
     * @return array
     */
    public static function getMapCode2Title()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'code2', 'lang.title');
    }
}
