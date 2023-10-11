<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210104_132242_update_catalog_colors_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_colors}}';

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
            'alias_he',
            $this->string(255)->notNull()->after('alias_de')
        );

        $rows = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($rows as $row) {
            $connection = Yii::$app->db;
            $connection->createCommand()
                ->update(
                    $this->table,
                    [
                        'alias_he' => $row['alias_en']
                    ],
                    'id = ' . $row['id']
                )
                ->execute();
        }

        $this->alterColumn($this->table, 'alias_he', $this->string(255)->unique()->notNull());
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'alias_he');
    }
}
