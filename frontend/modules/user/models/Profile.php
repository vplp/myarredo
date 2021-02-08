<?php

namespace frontend\modules\user\models;

/**
 * Class Profile
 *
 * @package frontend\modules\user\models
 */
class Profile extends \common\modules\user\models\Profile
{
    /**
     * @return string
     */
    public function getNameCompany()
    {
        return (isset($this->lang->name_company))
            ? $this->lang->name_company
            : "{{-}}";
    }
}
