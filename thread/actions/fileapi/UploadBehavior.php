<?php

namespace thread\actions\fileapi;

use Yii;
use yii\base\{
    Behavior, InvalidParamException
};
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use Imagine\Image\{
    Point
};


/**
 * Class UploadBehavior
 *
 * @package thread\app\components\fileapi
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
                if (isset($config['path']) && !empty($config['path'])) {
                    $this->attributes[$attribute]['path'] = $config['path'];
                } elseif (isset($config['getBaseUploadPathOwner']) && !empty($config['getBaseUploadPathOwner'])) {
                    $this->attributes[$attribute]['getBaseUploadPathOwner'] = $config['getBaseUploadPathOwner'];
                } else {
                    throw new InvalidParamException('Path must be set for all attributes.');
                }
                //
                if (!isset($config['tempPath']) || empty($config['tempPath'])) {
                    $config['tempPath'] = Yii::getAlias('@temp');
                }
                //
                if (isset($config['getBaseUploadUrlOwner']) && !empty($config['getBaseUploadUrlOwner'])) {
                    $config['url'] = $this->owner->{$config['getBaseUploadUrlOwner']}() . DIRECTORY_SEPARATOR;
                } elseif (!isset($config['url']) || empty($config['url'])) {
                    $config['url'] = $this->publish($config['path']);
                }

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
     * @param string $attribute Attribute name
     * @param bool $insert `true` on insert record
     */
    protected function saveFile($attribute, $filename, $insert = true)
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
            file_put_contents('/var/www/www-root/data/www/myarredo.ru/DeleteAction-log.txt', date('Y-m-d H:i:s').' ThreadUploadBehavior file='.$filename. ' user='.$q."\n", FILE_APPEND);
            return unlink($file);
        }

        return false;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Old file path
     */
    public function oldFile($attribute, $filename)
    {
        return $this->path($attribute) . $filename;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Path to file
     */
    public function path($attribute)
    {

        if (isset($this->attributes[$attribute]['path']) && !empty($this->attributes[$attribute]['path'])) {
            return FileHelper::normalizePath($this->attributes[$attribute]['path']) . DIRECTORY_SEPARATOR;
        } elseif (isset($this->attributes[$attribute]['getBaseUploadPathOwner']) && !empty($this->attributes[$attribute]['getBaseUploadPathOwner'])) {
            return FileHelper::normalizePath($this->owner->{$this->attributes[$attribute]['getBaseUploadPathOwner']}()) . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Temporary file path
     */
    public function tempFile($attribute, $filename)
    {
        return $this->tempPath($attribute) . $filename;
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string Path to temporary file
     */
    public function tempPath($attribute)
    {
        return $this->attributes[$attribute]['tempPath'];
    }

    /**
     * @param string $attribute Attribute name
     *
     * @return string File path
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
     * @param string $attribute Attribute name
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
                    }
                }

                $old_files = explode(',', $this->owner->getOldAttribute($attribute));
                $old_files = array_diff($old_files, $files);
                foreach ($old_files as $o_file) {
                    $this->deleteFile($this->oldFile($attribute, $o_file));
                }
            }
        }

        $this->fileExsistInAttributes();
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
}

