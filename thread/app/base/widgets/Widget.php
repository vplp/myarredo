<?php
namespace thread\app\base\widgets;

/**
 * Class Widget
 *
 * @package thread\app\base
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
abstract class Widget extends \yii\base\Widget
{
    /**
     * @var string
     */
    public $view = 'Widget';

    /**
     * @var string
     */
    public $name = 'widget';

    /**
     * @var string
     */
    public $translationsBasePath = '@thread/app/messages';
}
