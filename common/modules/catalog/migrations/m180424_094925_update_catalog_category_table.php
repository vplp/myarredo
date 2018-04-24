<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180424_094925_update_catalog_category_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_group}}';

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
            'image_link2',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link')
        );

        $this->addColumn(
            $this->table,
            'image_link3',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link2')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_link2');
        $this->dropColumn($this->table, 'image_link3');
    }
}
