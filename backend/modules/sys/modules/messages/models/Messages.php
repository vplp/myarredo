<?php
namespace backend\modules\sys\modules\messages\models;

use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Messages
 *
 * @package backend\modules\sys\modules\messages\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Messages extends \common\modules\sys\modules\messages\models\Messages implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Messages())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Messages())->trash($params);
    }
}
