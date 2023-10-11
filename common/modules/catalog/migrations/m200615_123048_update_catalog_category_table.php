<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200615_123048_update_catalog_category_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_group}}';

    /**
    *
    */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'image_link_com',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link3')
        );

        $this->addColumn(
            $this->table,
            'image_link2_com',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link_com')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_link2_com');
        $this->dropColumn($this->table, 'image_link_com');
    }
}
