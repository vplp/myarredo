<?php

namespace frontend\widgets\recaptcha3;

use Yii;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\validators\Validator;

/**
 * Class RecaptchaV3Validator
 *
 * @package frontend\widgets\recaptcha3
 */
class RecaptchaV3Validator extends Validator
{
    /**
     * @var bool
     */
    public $skipOnEmpty = false;

    /**
     * Recaptcha component
     * @var string|array|RecaptchaV3
     */
    public $component = 'recaptchaV3';

    /**
     * the minimum score for this request (0.0 - 1.0)
     * @var null|int
     */
    public $acceptance_score = null;

    /**
     * @var RecaptchaV3
     */
    private $_component = null;

    /** @var boolean */
    protected $isValid = false;

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

        if ($this->message === null) {
            $this->message = Yii::t('yii', 'The verification code is incorrect.');
        }
    }

    /**
     * @param mixed $value
     * @return array|null
     */
    protected function validateValue($value)
    {
        if (!$this->isValid) {
            $response = $this->_component->getResponse($value);
            if (!isset($response['success'])) {
                throw new Exception('Invalid recaptcha verify response.');
            }

            $this->isValid = ($response['success'] && $response['score'] > 0) === true;
        }

        return $this->isValid ? null : [$this->message, []];

//        if (!$value) {
//            return [$this->message, []];
//        }
//
//        $result = $this->_component->validateValue($value);
//
//        if ($result === false) {
//            return [$this->message, []];
//        }
//
//        if (!empty($result) && $result['success'] && $result['score'] > 0) {
//            return null;
//        }
//        ///* !!! */ echo  '<pre style="color:red;">'; print_r($result); echo '</pre>'; /* !!! */ die;
////        if ($this->acceptance_score !== null && $this->acceptance_score > $result) {
////            return [$this->message, []];
////        }
//
//        return [$this->message, []];
    }
}
