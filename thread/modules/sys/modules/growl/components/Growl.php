<?php

namespace thread\modules\sys\modules\growl\components;

use Yii;
use yii\base\Component;
//
use thread\modules\user\models\User;
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
    /**
     * @param $message
     * @param $user_id
     * @param string $type
     * @param string $url
     */
    public function send($message, $user_id, $type = 'notice', $url = '')
    {
        $model = new GrowlModel();
        $model['scenario'] = 'send';
        //
        $model['type'] = $type;
        $model['message'] = $message;
        $model['url'] = $url;
        $model['user_id'] = $user_id;
        $model->save();
    }

    /**
     * @param $group_id
     * @param $message
     * @param string $type
     * @param string $url
     * @return mixed|null
     */
    public function sendToUsersByGroupId($group_id, $message, $type = 'notice', $url = '')
    {
        $users = User::getUserIdByGroupId($group_id);

        return (!empty($users)) ? GrowlModel::sendByUserIds($users, $message, $type, $url) : null;
    }

    /**
     * @param $role
     * @param $message
     * @param string $type
     * @param string $url
     * @return mixed|null
     */
    public function sendToUsersByRole($role, $message, $type = 'notice', $url = '')
    {
        $users = User::getUserIdByRole($role);

        return (!empty($users)) ? GrowlModel::sendByUserIds($users, $message, $type, $url) : null;
    }
}