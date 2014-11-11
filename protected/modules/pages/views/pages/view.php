<?php

/**
 * View page
 * @var Page $model
 */

// Set meta tags
$this->pageTitle       = ($model->meta_title) ? $model->meta_title : $model->title;
$this->pageKeywords    = $model->meta_keywords;
$this->pageDescription = ($model->meta_title) ? $model->meta_title : $model->title . ' - интернет магазин детской одежды ikiddy. Лучшие цены по доступной цене. Доставка по Киеву и Украине. ☎ Тел.: (063) 561 95 24.';
?>

<h1 class="has_background"><?php echo $model->title; ?></h1>
<p>
	<?php echo $model->short_description; ?>
</p>
<p>
	<?php echo $model->full_description; ?>
</p>