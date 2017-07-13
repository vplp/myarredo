<?php
namespace thread\actions\fileapi;

use \Closure;
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
 * @package thread\app\components\fileapi
 */
class UploadAction extends Action
{

    public $model = null;

    /**
     * @var string Path to directory where files will be uploaded
     */
    public $path;

    /**
     * @var
     */
    public $fileNameSave;

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
    private $_path = '';
    private $_fileNameSave = '';

    /**
     * @throws InvalidCallException
     */
    public function init()
    {
        if ($this->path instanceof Closure) {
            $path = $this->path;
            $this->_path = $path($this);
        } elseif (!empty($this->path) && is_dir($this->path)) {
            $this->_path = $this->path;
        } else {
            //default path
            $this->_path = Yii::getAlias('@temp');
        }

        $this->path = FileHelper::normalizePath(Yii::getAlias($this->_path)) . DIRECTORY_SEPARATOR;
        if (!FileHelper::createDirectory($this->_path)) {
            throw new InvalidCallException("Directory specified in 'path' attribute doesn't exist or cannot be created.");
        }
        //set validator model type
        if ($this->uploadOnlyImage !== true) {
            $this->_validator = 'file';
        }
        //
        if ($this->fileNameSave instanceof Closure) {
            $fileNameSave = $this->fileNameSave;
            $this->_fileNameSave = $fileNameSave($this);
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
                    $model->file->name = uniqid() . ((empty($model->file->extension)) ? '' : '.' . $model->file->extension);
                } elseif (!empty($this->_fileNameSave)) {
                    $model->file->name = $this->_fileNameSave . ((empty($model->file->extension)) ? '' : '.' . $model->file->extension);
                }
                if ($model->file->saveAs($this->_path . DIRECTORY_SEPARATOR . $model->file->name)) {
                    $result = [
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
