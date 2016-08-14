<?php

namespace thread\modules\user\models\form;

/**
 * Class ChangePasswordForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ChangePassword extends CommonForm
{
    
    const FLASH_KEY = 'ChangePassword';
    
    /**
     * @var bool
     */
    public $isNewRecord = false;
}
