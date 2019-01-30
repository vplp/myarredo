<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190123_145911_update_catalog_factory_table extends Migration
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

    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'video',
            $this
                ->string(1024)
                ->defaultValue(null)
                ->after('image_link')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'video');
    }
}
