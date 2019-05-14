<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

/**
 * Handles the creation of table `{{%user_profile_lang}}`.
 */
class m190514_093428_create_user_profile_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%user_profile}}';

    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%user_profile_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = UserModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableLang,
            [
                'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
                'lang' => $this->string(5)->notNull()->comment('Language'),
                'address' => $this->string(255)->defaultValue(null),
                'name_company' => $this->string(255)->defaultValue(null),
            ]
        );

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-user_profile_lang-rid-user_profile-id',
            $this->tableLang,
            'rid',
            $this->table,
            'id',
            'CASCADE',
            'CASCADE'
        );

        /**
         * Update table
         */
        $models = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($models as $model) {
            // UPDATE

            Yii::$app->db->createCommand()
                ->insert(
                    $this->tableLang,
                    [
                        'rid' => $model['id'],
                        'lang' => 'ru-RU',
                        'address' => $model['address'],
                        'name_company' => $model['name_company'],
                    ]
                )
                ->execute();
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_profile_lang-rid-user_profile-id', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);
        $this->dropTable($this->tableLang);
    }
}
