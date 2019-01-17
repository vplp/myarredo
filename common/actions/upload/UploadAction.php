<?php

namespace common\actions\upload;

use Yii;
use yii\base\{
    Action, DynamicModel, InvalidCallException
};

use yii\web\{
    BadRequestHttpException, Response, UploadedFile
};
use yii\helpers\FileHelper;

/**
 * Class UploadAction
 *
 * @package common\actions\upload
 */
class UploadAction extends Action
{
    /**
     * @var string Path to directory where files will be uploaded
     */
    public $path;

    /**
     * The name form data send in get request ($_GET['input_file_name'])
     * @var boolean
     */
    public $getParamName = 'input_file_name';

    /**
     * @var string The parameter name for the file form data (the request argument name).
     */
    public $paramName = 'file';

    /**
     * @var boolean If `true` unique filename will be generated automatically
     */
    public $unique = true;

    /**
     * @var boolean
     */
    public $uploadOnlyImage = true;

    /**
     * @var array Model validator options
     */
    public $validatorOptions = [];

    /**
     * @var string Model validator name
     */
    private $_validator = 'image';

    /**
     * @var boolean
     */
    public $useHashPath = false;

    /**
     * @throws \yii\base\Exception
     */
    public function init()
    {
        // default path
        if ($this->path === null) {
            $this->path = Yii::getAlias('@temp');
        }

        $this->path = FileHelper::normalizePath(Yii::getAlias($this->path)) . DIRECTORY_SEPARATOR;

        if (!FileHelper::createDirectory($this->path)) {
            throw new InvalidCallException("Directory specified in 'path' attribute doesn't exist or cannot be created.");
        }

        // set validator model type
        if ($this->uploadOnlyImage !== true) {
            $this->_validator = 'file';
        }
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function run()
    {
        if (Yii::$app->request->isPost) {
            if (!empty($this->getParamName) && Yii::$app->getRequest()->get($this->getParamName)) {
                $this->paramName = Yii::$app->getRequest()->get($this->getParamName);
            }

            $file = UploadedFile::getInstanceByName($this->paramName);
            $model = new DynamicModel(compact('file'));

            $model->addRule('file', $this->_validator, $this->validatorOptions);

            if ($model->validate()) {
                if ($this->unique === true) {
                    $model->file->name = uniqid() .
                        (empty($model->file->extension)
                            ? ''
                            : '.' . $model->file->extension);
                }

                if ($this->useHashPath) {
                    $hash = preg_replace(
                        "%^(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})(.{4})%ius",
                        "$1/$2/$3/$4/$5/$6/$7",
                        md5($model->file->name)
                    );

                    $model->file->name = $hash . '/' . $model->file->name;

                    $dir = $this->path . '/' . $hash;
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }
                }

                if ($model->file->saveAs($this->path . $model->file->name)) {
                    $result = [
                        'key' => $model->file->name,
                        'caption' => $model->file->name,
                        'name' => $model->file->name
                    ];

                } else {
                    $result = ['error' => 'Can\'t upload file'];
                }

            } else {
                $result = ['error' => $model->getErrors()];
            }

            if (\Yii::$app->getRequest()->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
            }

            return $result;

        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }
}
