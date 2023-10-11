<?php

namespace thread\actions\fileapi;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\Response;

/**
 * Class DeleteAction
 *
 * @package thread\app\components\fileapi
 */
class DeleteAction extends Action
{

    /**
     * @var string Path to directory where files has been uploaded
     */
    public $path;

    /**
     *
     * @var string
     */
    public $paramName = 'key';

    /**
     *
     * @var array
     */
    public $thumb = [];

    /**
     *
     */
    public function init()
    {
        //default path
        if ($this->path === null) {
            $this->path = Yii::getAlias('@temp');
        }
        $this->path = FileHelper::normalizePath($this->path) . DIRECTORY_SEPARATOR;
    }

    /**
     * @return array
     */
    public function run()
    {
        $error = 'file don\'t exist';
        if (($file = Yii::$app->getRequest()->post($this->paramName))) {
            $filename = FileHelper::normalizePath($this->path . '/' . $file);
            if (is_file($filename)) {
                $q=print_r(\Yii::$app->getUser()->id, 1);
                file_put_contents('/var/www/www-root/data/www/myarredo.ru/DeleteAction-log.txt', date('Y-m-d H:i:s').' ThreadDeleteAction1 file='.$filename. ' user='.$q."\n", FILE_APPEND);
                $error = (unlink($filename)) ? 'file deleted' : 'can not delete file';
            }
            //delete thumb
            if (!empty($this->thumb)) {
                foreach ($this->thumb as $thumb) {
                    $filename = FileHelper::normalizePath($this->path . '/' . $thumb . $file);
                    if (is_file($filename)) {
                        $q=print_r(\Yii::$app->getUser()->id, 1);
                file_put_contents('/var/www/www-root/data/www/myarredo.ru/DeleteAction-log.txt', date('Y-m-d H:i:s').' ThreadDeleteAction2 file='.$filename. ' user='.$q."\n", FILE_APPEND);
                        unlink($filename);
                    }
                }
            }
        }

        if (\Yii::$app->getRequest()->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }
        $result = ['error' => $error];

        return $result;
    }
}
