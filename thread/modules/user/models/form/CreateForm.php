<?php

namespace thread\modules\user\models\form;
use yii\helpers\ArrayHelper;

/**
 * Class CreateForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CreateForm extends CommonForm
{
    public $published = 0;
    public $isNewRecord = true;


    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['password', 'password_confirmation', 'group_id', 'email'], 'required']
        ];

        if ($this->_username_attribute === 'email') {
            $rules[] = [['email'], 'required', 'on' => ['userCreate']];
        } elseif ($this->_username_attribute === 'username') {
            $rules[] = ['username', 'required', 'on' => ['userCreate']];
        }
        return ArrayHelper::merge($rules, parent::rules());
    }


    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'userCreate' => ['username', 'email', 'password', 'password_confirmation', 'group_id', 'published'],
        ];
    }


}
