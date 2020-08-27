<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200827_090830_update_catalog_product_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%catalog_item}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * @return bool|void
     * @throws \yii\base\NotSupportedException
     */
    public function safeUp()
    {
        if ($this->getDb()->getSchema()->getTableSchema($this->table)->getColumn('user')) {
            $this->dropColumn($this->table, 'user');
        }

        $this->addColumn(
            $this->table,
            'editor_id',
            $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('user_id')
        );

        $this->createIndex('editor_id', $this->table, 'editor_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('editor_id', $this->table);
        $this->dropColumn($this->table, 'editor_id');
    }
}
