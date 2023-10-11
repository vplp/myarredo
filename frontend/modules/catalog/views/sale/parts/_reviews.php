<?php
use yii\helpers\Html;

if (!empty($reviews)){?>
	<div class="col-lg-12">
		<div class="reviews-line"></div>
		<div class="reviews-title">
			<h2><?= Yii::t('app', 'Отзывы о салоне')?> <?= $model['user']['profile']->getNameCompany(); ?></h2>
			<?= Html::a(Yii::t('app', 'Смотреть все отзывы салона').' '.$model['user']['profile']->getNameCompany(), '/reviews/'.$model['user']['id'], [
	                    'class' => 'reviews-show-all'
	                ]); ?>
		</div>
		<div class="reviews-items reviews-items-slider">
			<?php foreach ($reviews as $review) {?>
				<div class="reviews-item">
					<div class="reviews-item-date"><?=Yii::$app->formatter->asDatetime(date('Y-m-d',$review->created_at), 'php:d F Y')?></div>
					<div class="reviews-item-text"><?=$review->question_3?></div>
					<div class="reviews-item-name"><?= $review->user->profile->last_name ?> <?= $review->user->profile->first_name ?></div>
				</div>
			<?php } ?>
		</div>
		<div class="reviews-title-bottom">
			<?= Html::a(Yii::t('app', 'Смотреть все отзывы салона').' '.$model['user']['profile']->getNameCompany(), '/reviews/'.$model['user']['id'], [
	                    'class' => 'reviews-show-all'
	                ]); ?>
		</div>
		<div class="reviews-line"></div>
	</div>
	<style type="text/css">
		.reviews-line{
			border-bottom: 1px dashed #B4B3A9;
		}
		.reviews-line:last-child{
			margin: 30px auto;
		}
		.reviews-title{
			display: flex;
		    justify-content: space-between;
		    align-items: center;
		    margin: 30px auto;
		}
		.reviews-title h2{
			font-size: 30px;
		    font-weight: 400;
		    line-height: normal;
		    text-transform: none;
		}
		.reviews-show-all{
			color: var(--link, #448339);
		    font-size: 16px;
		    line-height: normal;
		    text-decoration-line: underline;
		}
		.reviews-title-bottom{
			display: none;
		}
		.reviews-items{
			display: flex;
		    justify-content: space-between;
		}
		.reviews-item{
			display: flex;
		    flex-direction: column;
		    gap: 10px;
		    width: 30%;
		    padding: 0 15px;
		}
		.reviews-item-date,
		.reviews-item-name{
			color: var(--light-grey, #B4B3A9);
    		line-height: normal;
		}
		.reviews-item-text{
			color: var(--text, #535351);
		    font-size: 16px;
		    line-height: normal;
		}
		@media (max-width:768px){
			.reviews-items{
				display: block;
			}
			.reviews-item{
			    width: 46%;
			}
			.reviews-items .slick-dots{
				display: flex;
			    justify-content: center;
			    gap: 3px;
			    list-style-type: none;
			    margin-top: 20px;
			    padding: 0;
			}
			.reviews-items .slick-dots li {
			    width: 6px;
			    height: 6px;
			    border-radius: 50%;
			    background: #d9d9d9;
			}
			.reviews-items .slick-dots li.slick-active {
				background: var(--link, #448339);
			}
			.reviews-items .slick-dots button{
				visibility: hidden;
			}
			.reviews-title .reviews-show-all{
				display: none;
			}
			.reviews-title-bottom{
				display: block;
				margin-top: 20px;
			}
		}
		@media (max-width:540px){
			.reviews-item{
			    width: 100%;
			}
		}
	</style>
<?php } ?>
