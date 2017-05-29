<?php

namespace frontend\modules\seo\modules\pathcache\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\base\{
    InvalidParamException, Exception
};
use yii\log\Logger;
use yii\web\NotFoundHttpException;
//
use thread\modules\seo\interfaces\SeoFrontModel;
//
use frontend\modules\seo\modules\pathcache\models\Pathcache;

/**
 * Class PathcacheController
 *
 * @package frontend\modules\seo\modules\pathcache\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class PathcacheController extends \frontend\components\BaseController
{
    public $title = "Pathcache";
    public $defaultAction = 'index';

    /**
     * @var array
     */
    protected $pathsOfModules = [
        '@frontend/modules'
    ];
    /**
     * @var array
     */
    protected $modelslist = [

    ];
    /**
     * @var array
     */
    protected $seoModelList = [

    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @param $secretKey
     * @throws NotFoundHttpException
     */
    public function actionIndex($secretKey)
    {

        if ($secretKey !== $this->module->secretKey) {
            throw new NotFoundHttpException;
        }

        $this->initPathsOfModules();
        echo "Add models to cache<br>";

        foreach ($this->modelslist as $path) {

            $className = basename($path, '.php');
            preg_match('/namespace ([a-zA-Z\\\]*)/', file_get_contents($path), $f);
            if (!empty($f) && isset($f[1])) {
                $class = $f[1] . '\\' . $className;
                $class = new $class;
                if ($class instanceof SeoFrontModel) {
                    $this->seoModelList[] = $f[1] . '\\' . $className;
                    $this->addModelsToMapBase($class);
                }
            }
        }
        echo "Complete<br>";
    }

    /**
     * @param SeoFrontModel $seoModelClass
     */
    public function addModelsToMapBase(SeoFrontModel $seoModelClass)
    {
        $classname = get_class($seoModelClass);
        $find = Pathcache::getByClassName($classname);

        if ($find === null) {
            try {
                $seo = new Pathcache([
                    'scenario' => 'backend',
                    'model_key' => Pathcache::getModelKey($seoModelClass),
                    'classname' => $classname,
                    'published' => Pathcache::STATUS_KEY_ON
                ]);
                $seo->save();
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_WARNING);
            }
        }
    }

    /**
     *
     */
    protected function initPathsOfModules()
    {
        if (!empty($this->pathsOfModules)) {
            foreach ($this->pathsOfModules as $module) {
                $list = $this->getFileList(Yii::getAlias($module));
                if (!empty($list)) {
                    foreach ($list as $item) {
                        if (is_dir($item . DIRECTORY_SEPARATOR . 'models')) {
                            $this->initModelIntoModule($item . DIRECTORY_SEPARATOR . 'models');
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $path
     */
    protected function initModelIntoModule($path)
    {
        $list = $this->getFileList(Yii::getAlias($path), false);
        if (!empty($list)) {
            foreach ($list as $item) {
                $this->modelslist[] = $item;
            }
        }
    }

    /**
     * @param $baseDir
     * @param bool $is_dir
     * @return array
     */
    protected function getFileList($baseDir, $is_dir = true)
    {
        $list = [];
        $handle = opendir($baseDir);
        if ($handle === false) {
            throw new InvalidParamException("Unable to open directory: $baseDir");
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $baseDir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path) && $is_dir) {
                $list[] = $path;
            } elseif (is_file($path) && !$is_dir) {
                $list[] = $path;
            }
        }
        closedir($handle);

        return $list;
    }
}