<?php
if (Yii::app()->request->getRequestUri() == '/index.php') {
	$this->redirect('/', TRUE, 301);
}

Yii::import('application.modules.store.components.SCompareProducts');
Yii::import('application.modules.store.models.wishlist.StoreWishlist');

$assetsManager = Yii::app()->clientScript;
$assetsManager->registerCoreScript('jquery');
$assetsManager->registerCoreScript('jquery.ui');
// Disable jquery-ui default theme
$assetsManager->scriptMap = array('jquery-ui.css' => FALSE);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo CHtml::encode($this->pageTitle) ?></title>
	<meta charset="UTF-8"/>
	<meta name="description" content="<?php echo CHtml::encode($this->pageDescription) ?>">
	<meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords) ?>">
	<?php echo $this->getCustomHead() ?>

	<link rel="stylesheet"
		  href="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jqueryui/css/custom-theme/jquery-ui-1.8.19.custom.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/reset.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/style2.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/catalog.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/forms.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/google.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/jquery.fancybox.css">

	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/autocomplete.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.cycle.all.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jcarousellite_1.0.1.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/common.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/bootstrap-carousel.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.shorten.1.0.js"></script>

	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-40103949-1']);
		_gaq.push(['_trackPageview']);

		(function () {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>
<body>
<!-- top panel -->
<div id="top">
	<div id="topin">
		<div class="phones">
			<table>
				<tr>
					<td align="center"><img
							src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/mobile/life.png"></td>
					<td>(063) 56 19 524</td>
				</tr>
				<tr>
					<td align="center"><img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/mobile/mts.png">
					</td>
					<td>(066) 15 51 456</td>
				</tr>
				<!--<tr>
					<td align="center"><img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/mobile/kyivstar.png"></td>
					<td>(068) 78 78 431</td>
				</tr>-->
			</table>
		</div>
		<div class="account">
			<a href="<?php echo Yii::app()->createUrl('/store/wishlist/index') ?>">
				<?php echo Yii::t('core', 'Список желаний ({c})', array('{c}' => StoreWishlist::countByUser())) ?>
			</a>
			/
			<a href="<?php echo Yii::app()->createUrl('/store/compare/index') ?>">
				<?php echo Yii::t('core', 'Товары на сравнение ({c})', array('{c}' => SCompareProducts::countSession())) ?>
			</a>
			/
			<?php if (Yii::app()->user->isGuest): ?>
				<?php echo CHtml::link(Yii::t('core', 'Вход'), array('/users/login/login'), array('class' => 'light')) ?>
				/
				<?php echo CHtml::link(Yii::t('core', 'Регистрация'), array('/users/register'), array('class' => 'light')) ?>
			<?php else: ?>
				<?php echo CHtml::link(Yii::t('core', 'Личный кабинет'), array('/users/profile/index'), array('class' => 'light')) ?>
				/
				<?php echo CHtml::link(Yii::t('core', 'Мои заказы'), array('/users/profile/orders'), array('class' => 'light')) ?>
				/
				<?php echo CHtml::link(Yii::t('core', 'Выход'), array('/users/login/logout'), array('class' => 'light')) ?>
			<?php endif; ?>

		</div>


		<div class="search">
			<form method="post" action="/products/search">
				<div>
					<?php echo CHtml::form($this->createUrl('/store/category/search')) ?>
					<input name="q" class="searchit" type="text" id="searchQuery" placeholder="Поиск товаров"/>
					<button class="searchbut"></button>
					<?php echo CHtml::endForm() ?>

				</div>
			</form>
		</div>

		<div class="clr"></div>
	</div>
</div>
<!-- / top panel -->
<div id="head">
	<div id="headin">
		<a href="/" id="logo"><img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/logo.png" width="219"
								   height="72" alt="i-Kiddy - интернет магазин детской одежды в Киеве"/></a>
		<a href="<?php echo $this->createUrl('/category/tovari/sex/165'); ?>" id="boy">для мальчиков</a>
		<a href="<?php echo $this->createUrl('/category/tovari/sex/166'); ?>" id="girl">для девочек</a>

		<div id="cart">
			<?php $this->renderFile(Yii::getPathOfAlias('orders.views.cart._small_cart') . '.php'); ?>
		</div>

		<div class="clr"></div>

		<div id="menu">
			<ul id="iepie">
				<li class="home"><a href="/">Главная</a></li>
				<li><a href="<?php echo $this->createUrl('/category/tovari'); ?>">Товары</a></li>
				<li class="action"><a href="<?php echo $this->createUrl('/page/akcii'); ?>">Акции</a></li>
				<li><a href="<?php echo $this->createUrl('/news'); ?>">Новости</a></li>
				<li><a href="<?php echo $this->createUrl('/page/dostavka-i-oplata'); ?>">Доставка</a></li>
				<li><a href="<?php echo $this->createUrl('/feedback'); ?>">Контакты</a></li>
			</ul>
		</div>

		<div class="clr"></div>
	</div>
</div>
<!-- / head -->
<div id="content">
	<?php if (Yii::app()->controller->id != 'category'): ?>
		<div class="brandsc">
			<div class="carusel_frame brandc box_title">
				<div class="carusel">
					<?php
					Yii::import('application.modules.store.models.StoreCategory');
					$items = StoreCategory::model()->findByPk(1)->asCMenuArray();
					if (isset($items['items'])) {
						$this->widget('application.extensions.mbmenu.MbMenu', array(
								'cssFile' => Yii::app()->theme->baseUrl . '/assets/css/menu.css',
								'htmlOptions' => array('class' => 'dropdown', 'id' => 'nav'),
								'items' => $items['items'])
						);
					}
					?>
				</div>
				<button class="prev"></button>
				<button class="next"></button>
			</div>
		</div>
	<?php endif; ?>
	<?php if (($messages = Yii::app()->user->getFlash('messages'))): ?>
		<div class="flash_messages">
			<button class="close">×</button>
			<?php
			if (is_array($messages)) {
				echo implode('<br>', $messages);
			} else {
				echo $messages;
			}
			?>
		</div>
	<?php endif; ?>
	<?php echo $content; ?>

</div>
<!-- content end -->

<div style="clear:both;"></div>

<?php
if (isset($this->clips['underFooter'])) {
	echo $this->clips['underFooter'];
}
?>

<div id="footer">
	<div id="footerin">
		<div id="footerinin">
			<ul class="dub-menu">
				<?php
				$this->widget('zii.widgets.CMenu', array('items' => array(array('label' => Yii::t('core', 'Акции'), 'url' => array('/pages/pages/view', 'url' => 'akcii')), array('label' => Yii::t('core', 'Доставка и оплата'), 'url' => array('/pages/pages/view', 'url' => 'dostavka-i-oplata')), array('label' => Yii::t('core', 'Обратная связь'), 'url' => array('/feedback/default/index')),),));
				?>
			</ul>
			<div class="clr"></div>
			<div class="rules">
				© «Интернет-магазин i-kiddy», <?php echo date('Y'); ?>. Все права защищены
			</div>

			<div class="social">
				<span>Мы в:</span><br/>
				<a target="_blank" href="/out?url=https://www.facebook.com/pages/I-kiddy/151089808403099" class="facebook">Facebook</a>
				<a target="_blank" href="/out?url=https://twitter.com/ikiddy_com" class="twitter">Twitter</a>
				<a target="_blank" href="/out?url=http://vk.com/i_kiddy" class="vkontakte">ВКонтакте</a>
			</div>

			<div class="counters">
				<!--LiveInternet counter-->
				<script type="text/javascript"><!--
					document.write("<a target='_blank' href='/out?url=http://www.liveinternet.ru/click' " +
						"target=_blank><img src='//counter.yadro.ru/hit?t26.1;r" +
						escape(document.referrer) + ((typeof(screen) == "undefined") ? "" :
						";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
							screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
						";" + Math.random() +
						"' alt='' title='LiveInternet: показано число посетителей за" +
						" сегодня' " +
						"border='0' width='88' height='15'><\/a>")
					//--></script>
				<!--/LiveInternet-->
				<!-- Yandex.Metrika counter -->
				<script type="text/javascript">
					(function (d, w, c) {
						(w[c] = w[c] || []).push(function () {
							try {
								w.yaCounter21097039 = new Ya.Metrika({id: 21097039,
									webvisor: true,
									clickmap: true,
									trackLinks: true,
									accurateTrackBounce: true});
							} catch (e) {
							}
						});

						var n = d.getElementsByTagName("script")[0],
							s = d.createElement("script"),
							f = function () {
								n.parentNode.insertBefore(s, n);
							};
						s.type = "text/javascript";
						s.async = true;
						s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

						if (w.opera == "[object Opera]") {
							d.addEventListener("DOMContentLoaded", f, false);
						} else {
							f();
						}
					})(document, window, "yandex_metrika_callbacks");
				</script>
				<noscript>
					<div><img src="//mc.yandex.ru/watch/21097039" style="position:absolute; left:-9999px;" alt=""/>
					</div>
				</noscript>
				<!-- /Yandex.Metrika counter -->
			</div>

			<div class="clr"></div>
		</div>
	</div>
</div>
</body>
</html>
