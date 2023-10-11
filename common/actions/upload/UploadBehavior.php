<?php

namespace common\actions\upload;

use Yii;
use yii\base\{
    Behavior, InvalidParamException
};
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use yii\imagine\Image;
use Imagine\Image\{
    Box, Point
};

/**
 * Class UploadBehavior
 *
 * @package common\actions\upload
 */
class UploadBehavior extends Behavior
{

    /**
     * @event Event that will be call after successful file upload
     */
    const EVENT_AFTER_UPLOAD = 'afterUpload';

    /**
     * Are available 3 indexes:
     * - `path` Path where the file will be moved.
     * - `tempPath` Temporary path from where file will be moved.
     * - `url` Path URL where file will be saved.
     *
     * @var array Attributes array
     */
    public $attributes = [];

    /**
     * @var boolean If `true` current attribute file will be deleted
     */
    public $unlinkOnSave = true;

    /**
     * @var boolean If `true` current attribute file will be deleted after model deletion
     */
    public $unlinkOnDelete = true;

    /**
     * @var array Publish path cache array
     */
    protected static $_cachePublishPath = [];

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);
        if (!is_array($this->attributes) || empty($this->attributes)) {
            throw new InvalidParamException('Invalid or empty attributes array.');
        } else {
            foreach ($this->attributes as $attribute => $config) {
                if (!isset($config['path']) || empty($config['path'])) {
                    throw new InvalidParamException('Path must be set for all attributes.');
                }
                if (!isset($config['tempPath']) || empty($config['tempPath'])) {
                    throw new InvalidParamException('Temporary path must be set for all attributes.');
                }
                if (!isset($config['url']) || empty($config['url'])) {
                    $config['url'] = $this->publish($config['path']);
                }
                $this->attributes[$attribute]['path'] = FileHelper::normalizePath(Yii::getAlias($config['path'])) . DIRECTORY_SEPARATOR;
                $this->attributes[$attribute]['tempPath'] = FileHelper::normalizePath(Yii::getAlias($config['tempPath'])) . DIRECTORY_SEPARATOR;
                $this->attributes[$attribute]['url'] = rtrim($config['url'], '/') . '/';

                $validator = Validator::createValidator('string', $this->owner, $attribute);
                $this->owner->validators[] = $validator;
                unset($validator);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }

    /**
     * Function will be called before inserting the new record.
     */
    public function beforeInsert()
    {
        foreach ($this->attributes as $attribute => $config) {
            if ($this->owner->$attribute) {
                $files = explode(',', $this->owner->$attribute);
                foreach ($files as $file) {
                    $this->saveFile($attribute, $file);
                }
            }
        }

        $this->fileExsistInAttributes();
    }

    /**
     *
     */
    public function fileExsistInAttributes()
    {
        foreach ($this->attributes as $attribute => $config) {
            $base = $this->path($attribute);
            $files = explode(',', $this->owner->$attribute);
            $data = [];
            foreach ($files as $file) {
                if (is_file($base . '/' . $file)) {
                    $data[] = $file;
                }
            }
            $this->owner->{$attribute} = implode(',', $data);
        }
    }

    public function beforeDelete()
    {
        if ($this->unlinkOnDelete) {
            foreach ($this->attributes as $attribute => $config) {
                if ($this->owner->$attribute) {
                    $files = explode(',', $this->owner->$attribute);
                    foreach ($files as $file) {
                        $this->deleteFile($this->file($attribute, $file));
                    }
                }
            }
        }
    }

    /**
     * Save model attribute file.
     *
     * @param $attribute
     * @param $filename
     * @throws \yii\base\Exception
     */
    protected function saveFile($attribute, $filename)
    {
        $tempFile = $this->tempFile($attribute, $filename);
        $file = $this->file($attribute, $filename);

        if (is_file($tempFile) && FileHelper::createDirectory($this->path($attribute))) {
            if (rename($tempFile, $file)) {
                $this->triggerEventAfterUpload();
            } else {
                unset($this->owner->$attribute);
            }
        }
    }

    /**
     * Delete specified file.
     *
     * @param string $file File path
     *
     * @return bool `true` if file was successfully deleted
     */
    protected function deleteFile($file)
    {
        if (is_file($file)) {
            $q=print_r(\Yii::$app->getUser()->id, 1);
            file_put_contents('/var/www/www-root/data/www/myarredo.ru/DeleteAction-log.txt', date('Y-m-d H:i:s').' UploadBehavior file='.$fil. ' user='.$q."\n", FILE_APPEND);
            return unlink($file);
        }

        return false;
    }

    /**
     * @param $attribute
     * @param $filename
     * @return string
     */
    public function oldFile($attribute, $filename)
    {
        return $this->path($attribute) . $filename;
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function path($attribute)
    {
        return $this->attributes[$attribute]['path'];
    }

    /**
     * @param $attribute
     * @param $filename
     * @return string
     */
    public function tempFile($attribute, $filename)
    {
        return $this->tempPath($attribute) . $filename;
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function tempPath($attribute)
    {
        return $this->attributes[$attribute]['tempPath'];
    }

    /**
     * @param $attribute
     * @param $filename
     * @return string
     */
    public function file($attribute, $filename)
    {
        return $this->path($attribute) . $filename;
    }

    /**
     * Publish given path.
     *
     * @param string $path Path
     *
     * @return string Published url (/assets/images/image1.png)
     */
    public function publish($path)
    {
        if (!isset(static::$_cachePublishPath[$path])) {
            static::$_cachePublishPath[$path] = Yii::$app->assetManager->publish($path)[1];
        }
        return static::$_cachePublishPath[$path];
    }

    /**
     * Trigger [[EVENT_AFTER_UPLOAD]] event.
     */
    protected function triggerEventAfterUpload()
    {
        $this->owner->trigger(self::EVENT_AFTER_UPLOAD);
    }

    /**
     * Remove attribute and its file.
     *
     * @param string $attribute Attribute name
     *
     * @return bool Whenever the attribute and its file was removed
     */
    public function removeAttribute($attribute)
    {
        if (isset($this->attributes[$attribute])) {
            if ($this->deleteFile($this->file($attribute))) {
                return $this->owner->updateAttributes([$attribute => null]);
            }
        }
        return false;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return null|string Full attribute URL
     */
    public function urlAttribute($attribute)
    {
        if (isset($this->attributes[$attribute]) && $this->owner->$attribute) {
            return $this->attributes[$attribute]['url'] . $this->owner->$attribute;
        }
        return null;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Attribute mime-type
     */
    public function getMimeType($attribute)
    {
        return FileHelper::getMimeType($this->file($attribute));
    }

    /**
     * @param string $filename Attribute name
     *
     * @return boolean Whether file exist or not
     */
    public function fileExists($filename)
    {
        return file_exists($this->file($filename));
    }

    /**
     * Are available 3 indexes:
     * - `path` Path where the file will be moved.
     * - `tempPath` Temporary path from where file will be moved.
     * - `url` Path URL where file will be saved.
     * - `width`
     * - `height`
     * - `crop`
     * - `thumbnails` - array of thumbnails as prefix => options. Options:
     *          $width - thumbnail width
     *          $height - thumbnail height
     * @var array Attributes array
     */
    public function beforeUpdate()
    {

        foreach ($this->attributes as $attribute => $config) {
            if ($this->owner->isAttributeChanged($attribute)) {
                $files = explode(',', $this->owner->$attribute);

                foreach ($files as $file) {
                    if ($file !== '') {
                        $this->saveFile($attribute, $file);

                        // Create Resize
                        if ($this->issetResize($config)) {
                            $image = $this->processImage($this->attributes[$attribute]['url'] . $file, $config);
                            $image->save($this->attributes[$attribute]['path'] . $file, ['quality' => 100]);
                        }

                        // Create Thumb
                        if ($this->issetThumbnails($config)) {
                            $this->attributes[$attribute]['thumbnails'] = $config['thumbnails'];
                            $thumbnails = $this->attributes[$attribute]['thumbnails'];

                            foreach ($thumbnails as $name => $options) {
                                $this->ensureAttribute($name, $options);
                                $tmbFileName = $name . $file;
                                $image = $this->processImage($this->attributes[$attribute]['url'] . $file, $options);
                                $image->save($this->attributes[$attribute]['path'] . $tmbFileName, ['quality' => 100]);
                            }
                        }
                    }
                }

                $old_files = explode(',', $this->owner->getOldAttribute($attribute));
                $old_files = array_diff($old_files, $files);
                foreach ($old_files as $o_file) {
                    $this->deleteFile($this->oldFile($attribute, $o_file));

                    if ($this->issetThumbnails($config)) {
                        $this->attributes[$attribute]['thumbnails'] = $config['thumbnails'];
                        $thumbnails = $this->attributes[$attribute]['thumbnails'];

                        foreach ($thumbnails as $name => $options) {
                            $this->deleteFile($this->oldFile($attribute, $name . $o_file));
                        }
                    }
                }
            }
        }

        $this->fileExsistInAttributes();
    }

    /**
     * @param array $config name of attribute
     * @return bool isset thumbnails or not
     */
    private function issetThumbnails($config)
    {
        return isset($config['thumbnails']) && is_array($config['thumbnails']);
    }

    /**
     * @param array $config name of attribute
     * @return bool isset width, height or not
     */
    private function issetResize($config)
    {
        return isset($config['width']) || isset($config['height']);
    }

    /**
     * @param $attr
     * @param $options
     */
    public static function ensureAttribute(&$attr, &$options)
    {
        if (!is_array($options)) {
            $attr = $options;
            $options = [];
        }
    }

    /**
     * @param string $original path to original image
     * @param array $options with width and height
     * @return \Imagine\Image\ImageInterface
     */
    private function processImage($original, $options)
    {
        list($imageWidth, $imageHeight) = getimagesize($original);
        $image = Image::getImagine()->open($original);

        if (isset($options['width']) && !isset($options['height'])) {
            $width = $options['width'];
            $height = $options['width'] * $imageHeight / $imageWidth;
            $image->resize(new Box($width, $height));
        } elseif (!isset($options['width']) && isset($options['height'])) {
            $width = $options['height'] * $imageWidth / $imageHeight;
            $height = $options['height'];
            $image->resize(new Box($width, $height));
        } elseif (isset($options['width']) && isset($options['height'])) {
            $width = $options['width'];
            $height = $options['height'];
            if ($width / $height > $imageWidth / $imageHeight) {
                $resizeHeight = $width * $imageHeight / $imageWidth;
                $image->resize(new Box($width, $resizeHeight))
                    ->crop(new Point(0, ($resizeHeight - $height) / 2), new Box($width, $height));
            } else {
                $resizeWidth = $height * $imageWidth / $imageHeight;
                $image->resize(new Box($resizeWidth, $height))
                    ->crop(new Point(($resizeWidth - $width) / 2, 0), new Box($width, $height));
            }
        }

        return $image;
    }
}
