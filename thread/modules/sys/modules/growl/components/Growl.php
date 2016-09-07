<?php

namespace thread\modules\sys\modules\growl\components;

use Yii;
use yii\base\Component;
//
use thread\modules\sys\modules\growl\Growl as GrowlModule;
use thread\modules\sys\modules\growl\models\Growl as GrowlModel;

/**
 * Class Growl
 *
 * @package thread\modules\sys\growl\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Growl extends Component
{
    public function send($message, $user_id, $type = 'notice', $priority = 0)
    {
        $model = new GrowlModel();
        $model['scenario'] = 'send';
        //
        $model['type'] = $type;
        $model['priority'] = $priority;
        $model['message'] = $message;
        $model['user_id'] = $user_id;
        $model->save();
    }
}