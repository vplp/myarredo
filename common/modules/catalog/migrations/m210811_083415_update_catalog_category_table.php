<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210811_083415_update_catalog_category_table extends Migration
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
        $this->dropColumn($this->table, 'image_link_home');

        $this->addColumn(
            $this->table,
            'image_link_de',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link3')
        );

        $this->addColumn(
            $this->table,
            'image_link2_de',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link_de')
        );

        $this->addColumn(
            $this->table,
            'image_link_fr',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link3')
        );

        $this->addColumn(
            $this->table,
            'image_link2_fr',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link_fr')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_link2_fr');
        $this->dropColumn($this->table, 'image_link_fr');

        $this->dropColumn($this->table, 'image_link2_de');
        $this->dropColumn($this->table, 'image_link_de');
    }
}
