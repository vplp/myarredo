<?php

namespace thread\modules\sys\modules\messages\helpers;

use Yii;
use yii\base\{
    Component, InvalidParamException
};
use yii\helpers\{
    ArrayHelper, FileHelper
};
//
use thread\modules\sys\modules\messages\models\MessagesFile;

/**
 * Class FileList
 *
 * @package thread\modules\sys\modules\messages\helpers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class FileList extends Component
{
    public $pathes = [];
    public $lang = '';
    protected $module = null;
    protected $rootPath = '';

    /**
     *
     */
    public function init()
    {
        $this->module = Yii::$app->getModule('sys/messages');
        $this->lang = $this->module->defaultLang;
        $rootPath = Yii::getAlias('@root');
        $this->rootPath = $rootPath;
//
        if (!empty($this->module->pathes)) {
            $this->pathesToFile($this->module->pathes);
        }
        if (!empty($this->module->pathesToModules)) {
            $this->pathesToModules($this->module->pathesToModules);
        }
//
        foreach ($this->pathes as $k => $item) {
            $this->pathes[$k] = str_replace('\\', '/', str_replace($rootPath, '', $item));
        }
    }

    /**
     *
     */
    public function fillToBase()
    {
        if (!empty($this->pathes)) {
            foreach ($this->pathes as $item) {
                $this->addToBase($item);
            }
        }
    }

    /**
     * @param $filename
     */
    protected function addToBase($filename)
    {
        $mf = MessagesFile::findByFilePath($filename);
        if ($mf == null) {
            $mf = new MessagesFile([
                'messagefilepath' => $filename
            ]);

            $mf->save(false);
        }
    }

    /**
     * @param $lang
     * @return string
     * @throws \InvalidParamException
     */
    public function getLanguageKey($lang)
    {
        if (empty($lang)) {
            throw new InvalidParamException("Language is not set");
        }

        return mb_substr($lang, 0, 2);
    }

    /**
     * @param array $pathes
     */
    public function pathesToFile(array $pathes)
    {
        $lang = $this->getLanguageKey($this->lang);

        foreach ($pathes as $path) {
            $p = Yii::getAlias($path) . DIRECTORY_SEPARATOR . 'messages' . DIRECTORY_SEPARATOR . $lang;

            if (is_dir($p)) {
                $this->pathes = ArrayHelper::merge($this->pathes, FileHelper::findFiles($p));
            }

        }
    }

    /**
     * @param array $pathes
     * @throws InvalidParamException
     */
    public function pathesToModules(array $pathes)
    {
        foreach ($pathes as $path) {
            $p = Yii::getAlias($path);

            $list = $this->getDirs($p);

            if (!empty($list)) {
                $this->pathesToFile($list);
            }
        }
    }

    /**
     * @param $baseDir
     * @return array
     * @throws InvalidParamException
     */
    public function getDirs($baseDir)
    {
        $list = [];
        $handle = opendir($baseDir);
        if ($handle === false) {
            throw new InvalidParamException("Unable to open directory: $dir");
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $baseDir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $list[] = $path;
            }
        }
        closedir($handle);

        return $list;
    }
}