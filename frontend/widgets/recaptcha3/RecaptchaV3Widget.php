<?php

namespace frontend\widgets\recaptcha3;

use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
 * Class RecaptchaV3Widget
 *
 * @package frontend\widgets\recaptcha3
 */
class RecaptchaV3Widget extends InputWidget
{
    /**
     * Recaptcha component
     * @var string|array|RecaptchaV3
     */
    public $component = 'recaptchaV3';

    /** @var string */
    public $actionName = 'homepage';

    /** @var RecaptchaV3 */
    private $_component = null;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $component = Instance::ensure($this->component, RecaptchaV3::class);

        if ($component == null) {
            throw new InvalidConfigException('Component is required.');
        }

        $this->_component = $component;
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->_component->registerScript($this->getView());
        $this->field->template = "{input}\n{error}";
        $formId = $this->field->form->id;
        $inputId = Html::getInputId($this->model, $this->attribute);

        return $this->render('recaptcha', [
            'site_key' => $this->_component->site_key,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'actionName' => $this->actionName,
            'formId' => $formId,
            'inputId' => $inputId
        ]);
    }
}
