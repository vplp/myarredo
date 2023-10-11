<?php
use frontend\themes\myarredo\assets\AppAsset;
$bundle = AppAsset::register($this);
$this->title = $this->context->title;
?>
<main>
	<div class="container-wrap">
		<div class="container large-container reviews-container">
			<h1><?=$this->title?></h1>
			<?php if (!empty($reviews)){?>
				<div class="col-lg-12">
					<div class="reviews-items">
						<?php foreach ($reviews as $review) {?>
							<div class="reviews-item">
								<div class="reviews-item-date"><?=Yii::$app->formatter->asDatetime(date('Y-m-d',$review->created_at), 'php:d F Y')?></div>
								<div class="reviews-item-text"><?=$review->question_3?></div>
								<div class="reviews-item-name"><?= $review->user->profile->last_name ?> <?= $review->user->profile->first_name ?></div>
							</div>
						<?php } ?>
					</div>
				</div>
				<style type="text/css">
					.reviews-container{
						margin: 40px auto 60px;
					}
					.reviews-line{
						border-bottom: 1px dashed #B4B3A9;
					}
					.reviews-line:last-child{
						margin: 30px auto;
					}
					.reviews-container h1{
					    margin: 0 0 30px;
					    text-align: center;
					}
					.reviews-show-all{
						color: var(--link, #448339);
					    font-size: 16px;
					    line-height: normal;
					    text-decoration-line: underline;
					}
					.reviews-items{
						display: flex;
					    justify-content: space-between;
					    gap: 30px;
					    flex-wrap: wrap;
					}
					.reviews-item{
						display: flex;
					    flex-direction: column;
					    gap: 10px;
					    width: 30%;
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
						.reviews-item{
						    width: 46%;
						}
					}
					@media (max-width:540px){
						.reviews-container h1{
							font-size: 21px;
						}
						.reviews-item{
						    width: 100%;
						}
					}
				</style>
			<?php } ?>
		</div>
	</div>
</main>