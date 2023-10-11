<?php

namespace thread\modules\sys\modules\images\helpers;

/**
$config = [
    'basePath' => [
        'absolute' => '',
        'relative' => 'thumb',
    ],
    'thumbs' => [
        [
            'name' => '100x100',
            'size' => [
                'width' => 100,
                'height' => 100,
            ],
            'basePath' => [
                'absolute' => '',
                'relative' => 'thumb',
            ],
        ],
        [
            'name' => '100x100',
            'size' => [
                'width' => 100,
                'height' => 100,
            ],
        ],
    ]
];
*/

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

class Thumbs
{
    /**
     * @var null|string
     */
    protected $file = null;
    /**
     * @var string
     */
    protected $dirname = '';

    /**
     * @var array
     */
    protected $config;
    /**
     * Thumbs constructor.
     * @param string $image
     * @param array $config
     */
    public function __construct(string $image, array $config)
    {
        if (is_file($image)) {
            $this->file = FileHelper::normalizePath($image);
            $this->dirname = dirname($this->file);

            $this->config = $config;
        } else {
            throw new Exception('file does\'nt exist');
        }
    }

    /**
     * @param array $config
     * @return string
     */
    public function getPath(array $config){
        $path = '';
        if(isset($config['absolute']) && is_dir($config['absolute'])){
            $path = FileHelper::normalizePath($config['absolute']);
        }elseif(isset($config['relative']) && is_dir($config['relative'])){
            $path = FileHelper::normalizePath($config['relative']);
        }else{
            $path = $this->dirname;
        }
        return $path;
    }

    /**
     *
     */
    public function exec(){
        foreach($this->config['thumbs'] as $thumb){
            $image = new Manipulation($this->file);
            $image->setNewName($thumb['name'])->setDestination(
                $this->getPath((isset($thumb['basePath']))?
                    $thumb['basePath']:
                    $this->getPath((isset($thumb['basePath']))
                        ?$thumb['basePath']:''
                    )
                )
            )->crop($thumb['size']['width'], $thumb['size']['height']);
        }
    }
}