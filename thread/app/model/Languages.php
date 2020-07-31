<?php

namespace thread\app\model;

use yii\base\{
    ErrorException, Component, BootstrapInterface
};
use thread\app\model\interfaces\{
    LanguageModel as iLanguageModel,
    Languages as iLanguages
};

/**
 * class Languages
 *
 * @package thread\app\model
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Languages extends Component implements iLanguages, BootstrapInterface
{
    /**
     * @var null
     */
    public $languageModel = null;
    /**
     * @var null
     */
    protected $lang = null;
    /**
     * @var array
     */

    protected $defaultLang = [
        'by_default' => true,
        'alias' => 'en',
        'local' => 'en-EN',
        'label' => 'EN',
    ];
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @throws ErrorException
     */
    public function init()
    {
        $this->lang = new $this->languageModel;

        if (!($this->lang instanceof iLanguageModel)) {
            throw new ErrorException($this->languageModel . ' must be implemented ' . iLanguageModel::class);
        }

        $this->items = $this->getAll();

        foreach ($this->items as $item) {
            if ($item['by_default']) {
                $this->defaultLang = $item;
                break;
            }
        }

        parent::init();
    }

    /**
     * @param \yii\base\Application $app
     * @throws ErrorException
     */
    public function bootstrap($app)
    {
        $this->init();

        $app->language = $this->defaultLang['local'];
    }

    /**
     * @return mixed
     */
    public function getAll(): array
    {
        return $this->lang->getLanguages();
    }

    /**
     * @param string $lang
     * @return boolean
     */
    public function isExistsByAlias(string $lang)
    {
        $r = false;
        foreach ($this->items as $item) {
            if ($item['alias'] == $lang) {
                $r = true;
                break;
            }
        }
        return $r;
    }

    /**
     * @return string
     */
    public function getDefault(): array
    {
        return $this->defaultLang;
    }

    /**
     * @param string $lang
     * @return mixed
     */
    public function getLangByAlias(string $lang): array
    {
        $r = null;
        foreach ($this->items as $item) {
            if ($item['alias'] == $lang) {
                $r = $item;
                break;
            }
        }
        return $r;
    }

    /**
     * @param string $lang
     * @return mixed
     */
    public function getLangByLocal(string $lang): array
    {
        $r = null;
        foreach ($this->items as $item) {
            if ($item['local'] == $lang) {
                $r = $item;
                break;
            }
        }
        return $r;
    }

    /**
     * @return array
     */
    public function getCurrent(): array
    {
        $curr_lang = [];
        foreach ($this->items as $item) {
            if ($item['local'] == Yii::$app->language) {
                $curr_lang = $item;
                break;
            }
        }
        return $curr_lang;
    }
}
