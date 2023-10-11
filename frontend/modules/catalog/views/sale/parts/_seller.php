<?php

use yii\helpers\Html;
use frontend\modules\catalog\widgets\sale\SaleRequestForm;

?>
<div class="brand-info">
    <div class="white-area">
        <div class="image-container">
            <?= Html::img($bundle->baseUrl . '/img/brand.png') ?>
        </div>

        <div class="brand-info">
            <?php if ($model['user']['profile']['show_contacts_on_sale']) { ?>
                <p class="text-center">
                    <?= Yii::t('app', 'Контакты продавца') ?>
                </p>
                <h4 class="text-center" data-e="<?=$model['user']['id']?>">
                    <?= $model['user']['profile']->getNameCompany(); ?>
                </h4>

                <?php if (!empty($vote)){?>
                <div class="reviews-vote-wrapper">
                    <div class="reviews-vote div-flex mb-5">
                        <div class="vote-number fw600"><?=round($vote,1)?></div>
                        <div class="vote-wrapper">
                            <table>
                                <tbody><tr>
                                    <td><div class="star-active<?=round($vote) >= 1 ? ' star-over' : ''?>"></div></td>                     
                                    <td><div class="star-active<?=round($vote) >= 2 ? ' star-over' : ''?>"></div></td>                     
                                    <td><div class="star-active<?=round($vote) >= 3 ? ' star-over' : ''?>"></div></td>                     
                                    <td><div class="star-active<?=round($vote) >= 4 ? ' star-over' : ''?>"></div></td>                     
                                    <td><div class="star-active<?=round($vote) >= 5 ? ' star-over' : ''?>"></div></td>                     
                                </tr></tbody>
                            </table>
                            <?php /*<style type="text/css">
                                .vote-wrapper table td div {background: url('/uploads/ai.png') -390px -51px no-repeat; width:19px; height:16px; overflow:hidden; }
                                .vote-wrapper table td div.star-over { background-position:-374px -51px;}
                                .div-flex{display: flex;justify-content: center;align-items: center;gap: 7px;}
                                .mb-5 {margin-bottom: 5px}
                                .reliable-partner{color:#9B1327}
                                .fw600{font-weight: 600}
                                .vote-number{font-size: 17px}
                                .reviews-vote-wrapper{margin-bottom:10px}
                            </style>*/?>
                        </div>
                    </div>
                    <div class="partner-date text-center mb-5 fw600"><?=Yii::t('app', 'На сайте с')?> <?=Yii::$app->formatter->asDate($model['user']['created_at'], 'php:F');?> <?=date('Y',$model['user']['created_at'])?></div>
                    <?php if ($model['user']['profile']['reliable_partner']) { ?>
                    <div class="reliable-partner div-flex">
                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_86_284)">
                            <path d="M14.6156 18.4335C14.396 18.4335 14.1705 18.4335 13.9509 18.4335C13.5058 18.4393 13.0954 18.5665 12.737 18.8266C12.4018 19.0694 12.0723 19.3179 11.7312 19.5549C10.9682 20.0925 10.0665 20.0867 9.30349 19.5491C8.99714 19.3295 8.69656 19.1098 8.39598 18.8844C7.9798 18.5722 7.51737 18.422 6.99714 18.4277C6.60985 18.4335 6.22835 18.4335 5.84107 18.4277C4.96823 18.422 4.23413 17.9075 3.93933 17.0867C3.81216 16.7225 3.69656 16.3584 3.58673 15.9884C3.43066 15.4509 3.1243 15.0231 2.6561 14.711C2.36708 14.5144 2.08962 14.3121 1.81216 14.104C1.0376 13.5376 0.760142 12.7052 1.04338 11.7861C1.15899 11.4104 1.28037 11.0347 1.40754 10.659C1.55783 10.2023 1.55783 9.75144 1.40754 9.30057C1.25725 8.84392 1.08962 8.39306 0.985575 7.92485C0.812165 7.12716 1.07228 6.46242 1.69656 5.94797C2.02604 5.68207 2.37864 5.44508 2.71968 5.19653C3.1243 4.90751 3.40754 4.53179 3.55205 4.05202C3.66188 3.69364 3.77748 3.33525 3.89309 2.98265C4.19945 2.06358 4.91621 1.53757 5.88731 1.52022C6.28037 1.51444 6.67922 1.52022 7.07228 1.52601C7.54049 1.53179 7.96245 1.39306 8.33818 1.1156C8.66188 0.878606 8.99136 0.635832 9.32084 0.404618C10.0665 -0.121394 10.9451 -0.127174 11.6966 0.393057C12.026 0.624271 12.3555 0.867046 12.6792 1.10404C13.0607 1.39306 13.4885 1.53179 13.9682 1.52601C14.4596 1.52601 14.9509 1.50288 15.4364 1.55491C16.2573 1.64161 16.8064 2.12138 17.0954 2.88439C17.2341 3.25433 17.344 3.63005 17.4596 4.01155C17.6156 4.52023 17.9046 4.91907 18.344 5.21965C18.6619 5.4393 18.974 5.66473 19.2804 5.89595C19.9914 6.43352 20.263 7.27745 20.0029 8.13294C19.8873 8.52022 19.7601 8.90173 19.633 9.28323C19.4769 9.74566 19.4769 10.2081 19.633 10.6705C19.7601 11.052 19.8873 11.4393 20.0029 11.8208C20.263 12.6936 19.9856 13.5318 19.263 14.0751C18.9625 14.3006 18.6561 14.5202 18.3497 14.7341C17.9046 15.0405 17.6099 15.4566 17.4538 15.9711C17.3497 16.3237 17.2399 16.6705 17.1185 17.0173C16.8122 17.9075 16.0954 18.422 15.1532 18.4335C14.9798 18.4335 14.7948 18.4335 14.6156 18.4335ZM17.4596 9.99421C17.4653 6.17918 14.3555 3.06358 10.5405 3.05202C6.72546 3.04046 3.59829 6.15028 3.58673 9.95953C3.57517 13.7861 6.70234 16.9248 10.5231 16.9248C14.3266 16.9191 17.4538 13.7977 17.4596 9.99421Z" fill="#9B1327"/>
                            <path d="M7.03183 14.2486C7.14165 13.7861 7.25148 13.3006 7.36709 12.815C7.50581 12.2254 7.64454 11.6358 7.79483 11.052C7.84107 10.8728 7.80639 10.7515 7.6561 10.6301C6.86998 9.96532 6.08963 9.28902 5.3035 8.62428C5.15321 8.49712 4.99714 8.34683 5.10697 8.16764C5.18789 8.04625 5.39021 7.94798 5.54628 7.93642C6.58096 7.83816 7.61564 7.76301 8.65032 7.69365C8.84685 7.68209 8.90466 7.56648 8.96824 7.41619C9.35552 6.47399 9.74859 5.53758 10.1417 4.59538C10.2168 4.41619 10.2919 4.18498 10.5232 4.24856C10.6677 4.28324 10.818 4.45665 10.8758 4.60116C11.2804 5.5318 11.6734 6.47399 12.0549 7.42197C12.1359 7.6185 12.2457 7.69365 12.4596 7.70521C13.4943 7.77457 14.5289 7.84972 15.5636 7.94798C15.6908 7.95954 15.8873 8.06937 15.9104 8.17342C15.9393 8.2948 15.8642 8.49712 15.7601 8.5896C14.974 9.28324 14.1763 9.96532 13.3729 10.6416C13.2284 10.763 13.1879 10.8844 13.2341 11.0636C13.4769 12.0405 13.7081 13.0231 13.9393 14C13.9509 14.0578 13.9798 14.1156 13.9682 14.1676C13.9451 14.3006 13.9393 14.4971 13.8584 14.5434C13.7544 14.6069 13.5521 14.5954 13.4422 14.526C12.7659 14.1387 12.107 13.7168 11.4422 13.3179C11.1301 13.133 10.8122 12.815 10.4943 12.815C10.1879 12.815 9.88154 13.1387 9.58096 13.3237C8.91622 13.7283 8.25148 14.1387 7.58096 14.5376C7.29772 14.7052 7.03183 14.578 7.03183 14.2486Z" fill="#9B1327"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_86_284">
                            <rect width="19.2486" height="20" fill="white" transform="translate(0.875732)"/>
                            </clipPath>
                            </defs>
                        </svg>
                        <span class="fw600"><?=Yii::t('app', 'Надежный продавец')?></span>
                    </div>
                    <?php }?>
                </div>
                <?php } ?>
                
                <div class="ico">
                    <?= Html::img($bundle->baseUrl . '/img/phone.svg', ['width' => '36', 'height' => '31']) ?>
                </div>
                <div class="tel-num js-show-num">
                    (XXX) XXX-XX-XX
                </div>

                <?= Html::a(Yii::t('app', 'Узнать номер'), 'javascript:void(0);', [
                    'class' => 'js-show-num-btn'
                ]); ?>

                <div class="ico">
                    <?= Html::img($bundle->baseUrl . '/img/marker-map.png', ['width' => '34', 'height' => '28']) ?>
                </div>
                <div class="text-center adress">
                    <?= $model['user']['profile']['city']['lang']['title']; ?>,<br>
                    <?= !empty($model['user']['profile']['lang']) ? $model['user']['profile']['lang']['address'] : ''; ?>
                </div>

            <?php } else { ?>
                <h4 class="text-center">
                    <?= Yii::t('app', 'Распродажа') ?> My Arredo Family
                </h4>
                <p class="text-center">
                    <?= Yii::t('app', 'Для уточнения цены и наличия') ?>:
                </p>
            <?php } ?>

        </div>
    </div>
</div>
