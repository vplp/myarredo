<?php

use yii\db\Migration;
use common\modules\catalog\Catalog;

/**
 * Class m171006_071853_create_field_to_category
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m171006_071853_create_field_to_category extends Migration
{

    /**
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

    public function safeUp()
    {
        $this->addColumn($this->table, 'product_count', $this->integer(1)->unsigned()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        echo "m171006_071853_create_field_to_category cannot be reverted.\n";

        return false;
    }
}
