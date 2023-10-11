<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170726_131922_update_catalog_samples_table
 */
class m170726_131922_update_catalog_samples_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_samples}}';

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
        $this->dropColumn($this->table, 'default_title');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->table, 'default_title', $this->string(255)->defaultValue(null)->after('factory_id'));
    }
}
