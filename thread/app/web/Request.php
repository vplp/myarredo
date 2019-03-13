<?php

namespace thread\app\web;

use yii\base\ErrorException;
//
use thread\app\web\interfaces\InjectionLanguage as iInjectionLanguage;

/**
 * Class Request
 *
 * @package thread\app\web
 */
final class Request extends \yii\web\Request
{
    /**
     * @var
     */
    private $_requestUri;
    /**
     * @var
     */
    public $InjectionLanguageClass = InjectionLanguage::class;

    /**
     * @var array
     */
    public $bases = [];

    /**
     * @throws ErrorException
     */
    public function init()
    {
        if (!((new $this->InjectionLanguageClass) instanceof iInjectionLanguage)) {
            throw new ErrorException($this->InjectionLanguageClass . ' must be implemented ' . iInjectionLanguage::class);
        }
        call_user_func([$this->InjectionLanguageClass, 'setBases'], $this->bases);
        parent::init();
    }

    /**
     * @return bool|mixed|string
     * @throws \yii\base\InvalidConfigException
     */
    protected function resolveRequestUri()
    {
        if ($this->_requestUri === null) {
            $this->_requestUri = call_user_func(
                [$this->InjectionLanguageClass, 'processLangInUrl'],
                parent::resolveRequestUri()
            );
        }
        return $this->_requestUri;
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function getOriginalUrl()
    {
        return $this->getOriginalRequestUri();
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function getOriginalRequestUri()
    {
        return call_user_func([$this->InjectionLanguageClass, 'addLangToUrl'], $this->resolveRequestUri());
    }
}
