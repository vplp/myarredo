<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

echo $form->field($model, 'factory_discount');
echo $form->field($model, 'factory_discount_with_exposure');
echo $form->field($model, 'factory_discount_on_exposure');

//echo $form->text_line_lang($modelLang, 'wc_provider');

echo $form->text_line_lang($modelLang, 'wc_expiration_date');
echo $form->text_line_lang($modelLang, 'wc_terms_of_payment');

echo $form->text_line_lang($modelLang, 'wc_phone_supplier');
echo $form->text_line_lang($modelLang, 'wc_email_supplier');
echo $form->text_line_lang($modelLang, 'wc_contact_person_supplier');

echo $form->text_line_lang($modelLang, 'wc_phone_factory');
echo $form->text_line_lang($modelLang, 'wc_email_factory');
echo $form->text_line_lang($modelLang, 'wc_contact_person_factory');

//echo $form->text_line_lang($modelLang, 'wc_prepayment');
//echo $form->text_line_lang($modelLang, 'wc_balance');

//echo $form->text_line_lang($modelLang, 'wc_additional_terms')->textarea(['style' => 'height:200px;']);
