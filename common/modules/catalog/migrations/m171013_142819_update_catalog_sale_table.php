<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m171004_142819_update_catalog_product_table
 */
class m171013_142819_update_catalog_sale_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item}}';

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
            'image_link',
            $this
                ->string(255)
                ->defaultValue(null)
                ->comment('Image link')
                ->after('gallery_id')
        );

        $this->addColumn(
            $this->table,
            'gallery_image',
            $this
                ->string(1024)
                ->defaultValue(null)
                ->comment('Gallery image')
                ->after('image_link')
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_link');
        $this->dropColumn($this->table, 'gallery_image');
    }
}
