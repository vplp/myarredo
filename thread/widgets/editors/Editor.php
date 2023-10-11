<?php

namespace thread\widgets\editors;

use Yii;
use yii\widgets\InputWidget;

/**
 * Class Editor
 *
 * @package admin\extensions\editors
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
final class Editor extends InputWidget
{

    /**
     * Вибір редактору
     * @var string tinymce
     */
    public $editor;

    /**
     * Налаштування редактору
     */
    public $settings = [];

    /**
     * Вибір налаштувань
     * @var string
     */
    public $thema;

    /**
     * Редактор за замовчуванням
     * @var string
     */
    private $_defaultEditor = 'Tinymce';

    /**
     * Перелік дозволених редакторів
     *
     * @var arrray
     */
    private $_editors = [
        'Tinymce' => \thread\widgets\editors\tinymce\Tinymce::class,
        'Textarea' => \thread\widgets\editors\textarea\Textarea::class,
    ];

    /**
     *
     * @var string
     */
    public $language = '';

    public function init()
    {

        if (empty($this->language))
            $this->language = Yii::$app->language;

        if (!in_array($this->editor, $this->_editors))
            $this->editor = $this->_defaultEditor;
    }

    public function run()
    {
        $e = $this->_editors[$this->editor];
        return $e::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'thema' => $this->thema,
            'language' => $this->language,
            'settings' => $this->settings,
        ]);
    }

}
