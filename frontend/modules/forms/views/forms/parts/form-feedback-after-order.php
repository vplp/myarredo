<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\forms\models\FormsFeedbackAfterOrder;

/**
 * @var $model FormsFeedback
 */

?>

                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    //'action' => Url::toRoute(['/forms/form-feedback-after-order/'.$model->order_id.'/'], true),
                    'options' => [
                        'class' => 'form-inter-phone'
                    ]
                ]); ?>
                <div class="row" style="justify-content:center;display:flex;margin-bottom:40px;">
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 right-border">
                        <div class="form-block-in">
                            <?= $form
                                ->field($model, 'question_1')
                                ->radioList( [Yii::t('app', 'Нет')=>Yii::t('app', 'Нет'), Yii::t('app', 'Да') => Yii::t('app', 'Да')] ,['class'=>'radio-block radio-block-yes-no']);
                                //->label() ?>

                            <?= $form->field($model, 'question_2')
                                    ->dropDownList([0 => '--'] + $partners) ?>

                            <div class="result-wrapper" id="result_question_4" style="display:none;">
                            <?= $form
                                ->field($model, 'question_4')
                                ->radioList( [Yii::t('app', 'Встречей')=>Yii::t('app', 'Встречей'), Yii::t('app', 'Отправкой товара доставкой') => Yii::t('app', 'Отправкой товара доставкой'), Yii::t('app', 'Договоренностью о встрече или отправке товара') => Yii::t('app', 'Договоренностью о встрече или отправке товара'), Yii::t('app', 'Общением по телефону или в переписке') => Yii::t('app', 'Общением по телефону или в переписке'), Yii::t('app', 'Не общались с продавцом') => Yii::t('app', 'Не общались с продавцом')] ,['class'=>'radio-block']);
                                //->label() ?>
                            </div>

                            <h2><?=Yii::t('app', 'Оценка и отзыв')?></h2>
                            
                            <div class="vote-wrapper">
                                <div style="display:none;">
                                    <?= $form
                                    ->field($model, 'vote')
                                    ->input('hidden')
                                    ->label('') ?>
                                </div>
                                <table class="form-group">
                                    <tbody><tr>
                                        <td><div id="vote_120120_0" class="star-active" title="1" onmouseover="voteScript.trace_vote(this, true);" onmouseout="voteScript.trace_vote(this, false)" onclick="voteScript.do_vote(this)"></div></td>
                                            <td><div id="vote_120120_1" class="star-active" title="2" onmouseover="voteScript.trace_vote(this, true);" onmouseout="voteScript.trace_vote(this, false)" onclick="voteScript.do_vote(this)"></div></td>
                                            <td><div id="vote_120120_2" class="star-active" title="3" onmouseover="voteScript.trace_vote(this, true);" onmouseout="voteScript.trace_vote(this, false)" onclick="voteScript.do_vote(this)"></div></td>
                                            <td><div id="vote_120120_3" class="star-active" title="4" onmouseover="voteScript.trace_vote(this, true);" onmouseout="voteScript.trace_vote(this, false)" onclick="voteScript.do_vote(this)"></div></td>
                                            <td><div id="vote_120120_4" class="star-active" title="5" onmouseover="voteScript.trace_vote(this, true);" onmouseout="voteScript.trace_vote(this, false)" onclick="voteScript.do_vote(this)"></div></td>                             
                                    </tr></tbody>
                                </table>
                                <script>
                                    if(!window.voteScript) window.voteScript =
                                    {
                                        trace_vote: function(div, flag)
                                        {
                                            var my_div;
                                            var r = div.id.match(/^vote_(\d+)_(\d+)$/);
                                            for(var i = r[2]; i >= 0; i--)
                                            {
                                                my_div = document.getElementById('vote_'+r[1]+'_'+i);
                                                if(my_div)
                                                {
                                                    if(flag)
                                                    {
                                                        if(!my_div.saved_class)
                                                            my_div.saved_className = my_div.className;
                                                        if(my_div.className!='star-active star-over')
                                                            my_div.className = 'star-active star-over';
                                                    }
                                                    else
                                                    {
                                                        if(my_div.saved_className && my_div.className != my_div.saved_className)
                                                            my_div.className = my_div.saved_className;
                                                    }
                                                }
                                            }
                                            i = r[2]+1;
                                            while(my_div = document.getElementById('vote_'+r[1]+'_'+i))
                                            {
                                                if(my_div.saved_className && my_div.className != my_div.saved_className)
                                                    my_div.className = my_div.saved_className;
                                                i++;
                                            }
                                        },

                                        do_vote: function(div)
                                        {
                                            var r = div.id.match(/^vote_(\d+)_(\d+)$/);
                                            var vote_id = r[1];
                                            var vote_value = +r[2] + 1;
                                            var my_div;
                                            for(var i = 4; i >= 0; i--)
                                            {
                                                my_div = document.getElementById('vote_'+r[1]+'_'+i);
                                                if(!my_div.saved_class)
                                                            my_div.saved_className = my_div.className;
                                                if (i<=r[2]){
                                                    my_div.className = 'star-active star-voted';
                                                } else {
                                                    my_div.className = 'star-active';
                                                }
                                            }
                                            i = r[2]+1;
                                            while(my_div = document.getElementById('vote_'+r[1]+'_'+i))
                                            {
                                                if(my_div.saved_className && my_div.className != my_div.saved_className)
                                                    my_div.className = my_div.saved_className;
                                                i++;
                                            }
                                            input = document.getElementById('formsfeedbackafterorder-vote');
                                            input.value = vote_value;
                                        }
                                    }
                                    document.getElementsByName('FormsFeedbackAfterOrder[question_1]')[1].addEventListener('click', () => {
                                           document.getElementById('result_question_4').style.display = 'block';
                                    });
                                    document.getElementsByName('FormsFeedbackAfterOrder[question_1]')[2].addEventListener('click', () => {
                                           document.getElementById('result_question_4').style.display = 'none'; 
                                           document.querySelector('[name="FormsFeedbackAfterOrder[question_4]"]:checked').checked = false;
                                    });
                                    </script>
                                    <style type="text/css">
                                        .vote-wrapper table td div { cursor: pointer; background: url('/uploads/ai.png') -390px -51px no-repeat; width:19px; height:16px; overflow:hidden; }
                                        .vote-wrapper table td div.star-voted { background: url('/uploads/ai.png') -375px -51px no-repeat;}
                                        .vote-wrapper table td div.star-empty { background-position:-393px -51px; }
                                        .vote-wrapper table td div.star-over { background-position:-374px -51px;}
                                        .radio-block label{
                                            display: block;
                                        }
                                    </style>
                            </div>    

                            <?= $form
                                ->field($model, 'question_3')
                                ->textarea()
                                //->label() ?>

                            <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success big', 'style'=>'margin:0 auto;display:block;']) ?>
                        </div>
                    </div>

                <?php ActiveForm::end();?>

