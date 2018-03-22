<?php

use yii\db\Migration;
//
use common\modules\seo\Seo;

/**
 * Class m180322_125422_update_seo_direct_link_table
 */
class m180322_125422_update_seo_direct_link_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%seo_direct_link}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Seo::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->dropColumn($this->table, 'h1');
        $this->dropColumn($this->table, 'content');
        $this->dropColumn($this->table, 'keywords');
        $this->dropColumn($this->table, 'description');
        $this->dropColumn($this->table, 'title');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->table, 'title', $this->string(225)->notNull()->after('lang'));
        $this->addColumn($this->table, 'description', $this->string(225)->notNull()->after('title'));
        $this->addColumn($this->table, 'keywords', $this->string(225)->notNull()->after('description'));
        $this->addColumn($this->table, 'h1', $this->string(128)->notNull()->comment('H1')->after('keywords'));
        $this->addColumn($this->table, 'content', $this->text()->defaultValue(null)->after('h1'));
    }
}
