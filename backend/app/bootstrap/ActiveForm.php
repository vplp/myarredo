<?php

namespace backend\app\bootstrap;

/**
 * Class ActiveForm
 *
 * @package backend\app\bootstrap
 */
class ActiveForm extends \thread\app\bootstrap\ActiveForm
{
    public $fieldClass = ActiveField::class;
}