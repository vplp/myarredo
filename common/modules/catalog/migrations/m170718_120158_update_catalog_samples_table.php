<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170718_120158_update_catalog_samples_table
 */
class m170718_120158_update_catalog_samples_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%samples}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->renameColumn($this->table, 'enabled', 'published');
        $this->renameColumn($this->table, 'created', 'created_at');
        $this->renameColumn($this->table, 'updated', 'updated_at');
        $this->renameColumn($this->table, 'picpath', 'image_link');

        $this->renameTable('samples', 'catalog_samples');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_samples', 'samples');

        $this->renameColumn($this->table, 'published', 'enabled');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
        $this->renameColumn($this->table, 'image_link', 'picpath');
    }
}
