<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170718_150158_update_catalog_factory_table
 */
class m170718_150158_update_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%factory}}';

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
        $this->renameColumn($this->table, 'order', 'position');
        $this->renameColumn($this->table, 'picpath', 'image_link');

        $this->dropColumn($this->table, 'default_title');

        $this->renameTable('factory', 'catalog_factory');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_factory', 'factory');

        $this->addColumn($this->table, 'default_title', $this->string(255)->defaultValue(null)->after('alias'));

        $this->renameColumn($this->table, 'published', 'enabled');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
        $this->renameColumn($this->table, 'position', 'order');
        $this->renameColumn($this->table, 'image_link', 'picpath');
    }
}
