<?php
namespace thread\modules\sys\modules\images\helpers;

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

/**
 * Class Manipulation
 *
 * @package thread\modules\sys\modules\images\helpers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Manipulation
{
    /**
     * @var null|string
     */
    protected $file = null;
    /**
     * @var string
     */
    protected $filename = '';
    /**
     * @var string
     */
    protected $dirname = '';
    /**
     * @var string
     */
    protected $destination = '';
    /**
     * @var int
     */
    protected $quality = 100;
    /**
     * @var bool
     */
    protected $rewrite = true;
    /**
     * @var string
     */
    protected $destinationFileName = '';

    /**
     * Manipulation constructor.
     * @param string $from
     * @param string $destination
     * @param boollean|true $rewrite
     */
    public function __construct(string $from, string $destination = '', boollean $rewrite = true)
    {
        if (is_file($from)) {
            $this->file = FileHelper::normalizePath($from);
            $this->filename = basename($this->file);
            $this->dirname = dirname($this->file);

            $this->destinationFileName = $this->filename;

            $this->setDestination($destination);

            $this->rewrite = $rewrite;

        } else {
            throw new Exception('file does\'nt exist');
        }
    }

    /**
     * @param string $name
     * @param boollean|true $extra
     */
    public function setNewName(string $name, boollean $extra = true)
    {
        $this->destinationFileName = ($extra) ? $this->filename . $name : $name;
        return $this;
    }

    /**
     * @param string $destination
     * @return $this
     */
    public function setDestination(string $destination)
    {
        if (is_dir($destination)) {
            $this->destination = FileHelper::normalizePath($destination);
        } else {
            $this->destination = Yii::getAlias('@temp');
        }
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setQuality(int $value)
    {
        $this->quality = ($value > 0 && $value < 100) ? $value : 100;
        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $destination
     */
    public function crop(int $width, int $height)
    {
        $name = $this->destination . DIRECTORY_SEPARATOR . $this->destinationFileName;

        $image = Yii::$app->image->load($this->file);
        $image->resize($width, $height, 0x05)->crop($width, $height)->save($name, ['quality' => $this->quality]);
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $destination
     */
    public function resize(int $width, int $height)
    {
        $name = $this->destination . DIRECTORY_SEPARATOR . $this->destinationFileName;

        $image = Yii::$app->image->load($this->file);
        $image->resize($width, $height, 0x05)->save($name, ['quality' => $this->quality]);
    }
}