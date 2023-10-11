<?php

namespace console\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\sys\models\Language;
use common\modules\user\models\{
    User, Group, Profile, ProfileLang
};

/**
 * Class UserController
 *
 * @package console\controllers
 */
class UserController extends Controller
{
    /**
     * Reset mark
     */
    public function actionResetProfileMark()
    {
        $this->stdout("ResetMark: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Profile::tableName(), ['mark' => '0'], "`mark`='1'")
            ->execute();

        $this->stdout("ResetMark: finish. \n", Console::FG_GREEN);
    }

    /**
     * Translate
     */
    public function actionPartnerTranslate()
    {
        $this->stdout("Translate: start. \n", Console::FG_GREEN);

        $groups = Group::getIdsByRole('partner');

        $models = User::findBase()
            ->andFilterWhere([
                Profile::tableName() . '.mark' => '0',
            ])
            ->group_ids($groups)
            ->limit(50)
            ->orderBy(User::tableName() . '.id DESC')
            ->all();

        // languages
        $modelLanguage = new Language();
        $languages = $modelLanguage->getLanguages();

        foreach ($models as $model) {
            /** @var PDO $transaction */
            /** @var $model User */

            $saveLang = [];

            $this->stdout("ID = " . $model->id . " \n", Console::FG_GREEN);

            // Translate with language_editing
            if (isset($model->profile->language_editing) && $model->profile->language_editing != '') {
                Yii::$app->language = $model->profile->language_editing;
                $currentLanguage = Yii::$app->language;

                $this->stdout("language editing " . $model->profile->language_editing . " \n", Console::FG_GREEN);

                /** @var $modelProfileLang ProfileLang */
                $modelProfileLang = ProfileLang::find()
                    ->where([
                        'rid' => $model->profile->id,
                    ])
                    ->one();

                if ($modelProfileLang != null) {
                    foreach ($languages as $language2) {
                        if ($language2['local'] != $currentLanguage) {
                            Yii::$app->language = $language2['local'];

                            /** @var $modelProfileLang2 ProfileLang */
                            $modelProfileLang2 = ProfileLang::find()
                                ->where([
                                    'rid' => $model->profile->id,
                                    'lang' => Yii::$app->language,
                                ])
                                ->one();

                            if ($modelProfileLang2 == null) {
                                $modelProfileLang2 = new ProfileLang();

                                $modelProfileLang2->rid = $model->profile->id;
                                $modelProfileLang2->lang = Yii::$app->language;

                                $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                $targetLanguageCode = substr($language2['local'], 0, 2);

                                $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                $address = (string)Yii::$app->yandexTranslation->getTranslate(
                                    $modelProfileLang->address,
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                $name_company = (string)Yii::$app->yandexTranslation->getTranslate(
                                    strip_tags($modelProfileLang->name_company),
                                    $sourceLanguageCode,
                                    $targetLanguageCode
                                );

                                if ($address != '' && $name_company != '') {
                                    $transaction = $modelProfileLang2::getDb()->beginTransaction();
                                    try {
                                        $modelProfileLang2->address = $address;
                                        $modelProfileLang2->name_company = $name_company;

                                        $modelProfileLang2->setScenario('backend');

                                        if ($saveLang[] = intval($modelProfileLang2->save())) {
                                            $transaction->commit();
                                            $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
                                        } else {
                                            foreach ($modelProfileLang2->errors as $attribute => $errors) {
                                                $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
                                            }
                                        }
                                    } catch (Exception $e) {
                                        $transaction->rollBack();
                                        throw new Exception($e);
                                    }
                                }
                            } else {
                                $saveLang[] = 1;
                            }
                        }
                    }
                }
            } else {
                foreach ($languages as $language) {
                    Yii::$app->language = $language['local'];
                    $currentLanguage = Yii::$app->language;

                    /** @var $modelProfileLang ProfileLang */
                    $modelProfileLang = ProfileLang::find()
                        ->where([
                            'rid' => $model->profile->id,
                        ])
                        ->one();

                    if ($modelProfileLang != null) {
                        foreach ($languages as $language2) {
                            if ($language2['local'] != $currentLanguage) {
                                Yii::$app->language = $language2['local'];

                                /** @var $modelProfileLang2 ProfileLang */
                                $modelProfileLang2 = ProfileLang::find()
                                    ->where([
                                        'rid' => $model->profile->id,
                                        'lang' => Yii::$app->language,
                                    ])
                                    ->one();

                                if ($modelProfileLang2 == null) {
                                    $modelProfileLang2 = new ProfileLang();

                                    $modelProfileLang2->rid = $model->profile->id;
                                    $modelProfileLang2->lang = Yii::$app->language;

                                    $sourceLanguageCode = substr($currentLanguage, 0, 2);
                                    $targetLanguageCode = substr($language2['local'], 0, 2);

                                    $this->stdout("targetLanguageCode " . $targetLanguageCode . " \n", Console::FG_GREEN);

                                    $address = (string)Yii::$app->yandexTranslation->getTranslate(
                                        $modelProfileLang->address,
                                        $sourceLanguageCode,
                                        $targetLanguageCode
                                    );

                                    $name_company = (string)Yii::$app->yandexTranslation->getTranslate(
                                        strip_tags($modelProfileLang->name_company),
                                        $sourceLanguageCode,
                                        $targetLanguageCode
                                    );

                                    if ($address != '' && $name_company != '') {
                                        $transaction = $modelProfileLang2::getDb()->beginTransaction();
                                        try {
                                            $modelProfileLang2->address = $address;
                                            $modelProfileLang2->name_company = $name_company;

                                            $modelProfileLang2->setScenario('backend');

                                            if ($saveLang[] = intval($modelProfileLang2->save())) {
                                                $transaction->commit();
                                                $this->stdout("save " . $targetLanguageCode . " \n", Console::FG_GREEN);
                                            } else {
                                                foreach ($modelProfileLang2->errors as $attribute => $errors) {
                                                    $this->stdout($attribute . ": " . implode('; ', $errors) . " \n", Console::FG_RED);
                                                }
                                            }
                                        } catch (Exception $e) {
                                            $transaction->rollBack();
                                            throw new Exception($e);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $model->profile->setScenario('mark');
            $model->profile->mark = '1';

            if ($model->profile->save() && !in_array(0, array_values($saveLang))) {
                $this->stdout("translate ID = " . $model->id . " \n", Console::FG_GREEN);
            }

            $this->stdout("-------------------------------" . " \n", Console::FG_GREEN);
        }

        $this->stdout("Translate: finish. \n", Console::FG_GREEN);
    }
}
