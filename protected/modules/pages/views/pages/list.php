<?php

/**
 * View category pages
 * @var PageCategory $model
 */

// Set meta tags
$this->pageTitle = ($model->meta_title) ? $model->meta_title : $model->name;
$this->pageKeywords = $model->meta_keywords;
$this->pageDescription = $model->meta_description;
?>

<h1 class="has_background"><?php echo $model->name ?></h1>
	<?php if (sizeof($pages) > 0): ?>
		<?php foreach ($pages as $page): ?>
			<h2 class="newtitle"><?php echo CHtml::link($page->title, array('/pages/pages/view', 'url'=>$page->url)); ?></h2><br/>
			<?php 
			$parts = explode('<hr />', $page->full_description);
			echo $parts[0] . '<hr /></div>'; 
			?>
			<b><?php echo CHtml::link('подробнее...', array('/pages/pages/view', 'url'=>$page->url), array('style' => 'margin-left: 5px;')); ?></b>
		<?php endforeach ?>
	<?php else: ?>
		<?php echo Yii::t('PagesModule.core', 'В категории нет страниц.') ?>
	<?php endif ?>

	<?php $this->widget('CLinkPager', array(
		'pages' => $pagination,
	)) ?>

