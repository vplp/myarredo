<?php

namespace common\actions\upload;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\Response;

/**
 * Class DeleteAction
 *
 * @package common\actions\upload
 */
class DeleteAction extends Action
{
    /**
     * @var string Path to directory where files has been uploaded
     */
    public $path;

    /**
     * @var string
     */
    public $paramName = 'key';

    /**
     * @var array
     */
    public $thumb = [];

    /**
     * @var boolean
     */
    public $useHashPath = false;

    /**
     * @inheritdoc
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
        $result = ['success' => 0];

        if (($file = Yii::$app->getRequest()->post($this->paramName))) {
            $filename = FileHelper::normalizePath($this->path . '/' . $file);

            if (!is_file($filename)) {
                $filename = FileHelper::normalizePath($this->path . '/' . basename($file));
            }

            if ($this->useHashPath) {
                /*
                $hash = preg_replace(
                    "%^(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})%ius",
                    "$1/$2/$3/$4/$5/$6/$7",
                    md5($file)
                );
                $hashFile = $hash . '/' . $file;
                */
                $hashFile = str_replace('uploads/images', '', $file);

                $filename = FileHelper::normalizePath($this->path . '/' . $hashFile);
            }

            $result['$filename'] = $filename;

            if (is_file($filename) && unlink($filename)) {
                $q=print_r(\Yii::$app->getUser()->id, 1);
                file_put_contents('/var/www/www-root/data/www/myarredo.ru/DeleteAction-log.txt', date('Y-m-d H:i:s').' DeleteAction1 file='.$filename. ' user='.$q."\n", FILE_APPEND);
                $result['success'] = 1;
            } else {
                $result['error'] = 'Can not delete file';
            }

            //delete thumb
            if (!empty($this->thumb)) {
                foreach ($this->thumb as $thumb) {
                    $filename = FileHelper::normalizePath($this->path . '/' . $thumb . $file);
                    if (is_file($filename)) {
                        $q=print_r(\Yii::$app->getUser()->id, 1);
                        file_put_contents('/var/www/www-root/data/www/myarredo.ru/DeleteAction-log.txt', date('Y-m-d H:i:s').' DeleteAction2 file='.$filename. ' user='.$q."\n", FILE_APPEND);
                        unlink($filename);
                    }
                }
            }

        } else {
            $result['error'] = 'File don\'t exist';
        }

        if (\Yii::$app->getRequest()->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return $result;
    }
}
