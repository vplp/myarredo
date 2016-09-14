<?php

namespace thread\app\web;

use yii\base\ErrorException;
use thread\app\web\interfaces\InjectionLanguage as iInjectionLanguage;

/**
 * Class UrlManager
 *
 * @package thread\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
final class UrlManager extends \yii\web\UrlManager
{
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
     *
     * @param array $params
     * @return string
     */
    public function createUrl($params)
    {
        return call_user_func([$this->InjectionLanguageClass, 'addLangToUrl'], parent::createUrl($params));
    }

    /**
     *
     * @return string
     */
    public function getBaseUrl()
    {
        $this->setBaseUrl(call_user_func([$this->InjectionLanguageClass, 'getBaseUrl']));
        return parent::getBaseUrl();
    }

}
