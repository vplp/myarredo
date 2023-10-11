<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190821_080449_update_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory}}';

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
        $this->addColumn(
            $this->table,
            'user_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('id')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'user_id');
    }
}
