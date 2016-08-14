<?php

namespace thread\app\web;

use yii\base\ErrorException;
use thread\app\web\interfaces\InjectionLanguage as iInjectionLanguage;

/**
 * Class Request
 *
 * @package thread\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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
     * @throws ErrorException
     */
    public function init()
    {

        if (!((new $this->InjectionLanguageClass) instanceof iInjectionLanguage)) {
            throw new ErrorException($this->InjectionLanguageClass . ' must be implemented ' . iInjectionLanguage::class);
        }

        parent::init();
    }

    /**
     *
     * @return string
     */
    protected function resolveRequestUri()
    {
        if ($this->_requestUri === null) {
            $this->_requestUri = call_user_func([$this->InjectionLanguageClass, 'processLangInUrl'],
                parent::resolveRequestUri());
        }
        return $this->_requestUri;
    }

    /**
     *
     * @return string
     */
    public function getOriginalUrl()
    {
        return $this->getOriginalRequestUri();
    }

    /**
     *
     * @return string
     */
    public function getOriginalRequestUri()
    {
        return call_user_func([$this->InjectionLanguageClass, 'addLangToUrl'], $this->resolveRequestUri());
    }

}
