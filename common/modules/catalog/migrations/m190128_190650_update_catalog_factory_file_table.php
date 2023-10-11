<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190128_190650_update_catalog_factory_file_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_file}}';

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
            'image_link',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('file_link')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_link');
    }
}
