<?php
namespace backend\modules\user\models;

use thread\actions\fileapi\UploadBehavior;

/**
 * Class Profile
 *
 * @package backend\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Profile extends \common\modules\user\models\Profile
{
    /**
     * @return mixed
     */
    public function behaviors()
    {
        $module = Yii::$app->getModule('user');
        $path = $module->getAvatarUploadPath($this->user_id);
        $url = $module->getAvatarUploadUrl($this->user_id);

        return ArrayHelper::merge(parent::behaviors(), [
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'image_link' => [
                        'path' => $path,
                        'url' => Yii::$app->getRequest()->BaseUrl . $url
                    ]
                ]
            ],
        ]);
    }
}
