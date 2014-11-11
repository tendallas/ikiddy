<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	/**
	 * @var string
	 */
	public $pageKeywords;

	/**
	 * @var string
	 */
	public $pageDescription;

	/**
	 * @var string
	 */
	private $_pageTitle;
	
	/**
	 * Set layout and view
	 * @param mixed $model
	 * @param string $view Default view name
	 * @return string
	 */
	protected function setDesign($model, $view)
	{
		// Set layout
		if ($model->layout)
			$this->layout = $model->layout;

		// Use custom page view
		if ($model->view)
			$view = $model->view;

		return $view;
	}
	
	/**
	 * Insert custom meta
	 * @return string
	 */
	public function getCustomHead()
	{
		$head = array();
		$uri = Yii::app()->request->getRequestUri();
		
		$stopArray = array('/sort/', '/per_page/', '/view/', '/color/', '/min_price/', '/max_price/');
		foreach ($stopArray as $disallow) 
		{
			if (substr_count($uri, $disallow)) 
			{
				$head[] = '<meta name="robots" content="noindex, nofollow" />';
			}
			
			unset ($disallow);
		}
		
		if (substr_count($uri, '/size/'))
		{
			$part = explode('/size/', $uri);
			$head[] = '<link rel="canonical" href="http://' . CHttpRequest::getServerName() . $part[0] . '" />';
		}
		
		if (substr_count($uri, '%3B')) 
		{
			$part = explode('%3B', $uri);
			$head[] = '<link rel="canonical" href="http://' . CHttpRequest::getServerName() . $part[0] . '" />';
		}	 	
		
		return implode("\n", $head);
	}
	
	/**
	 * Generate head scripts and links
	 * @return string
	 */
	public function generateHeadData($path) {
		$data = array();
		$files = CFileHelper::findFiles(YiiBase::getPathOfAlias('webroot') . $path);
		foreach ($files as $key => $value) {
			$ext = CFileHelper::getExtension($value);
			$value = str_replace(YiiBase::getPathOfAlias('webroot'), '', $value);
			if ($ext == 'css') {
				$data['text/css'][] = '<link rel="stylesheet" href="' . $value . '">';
			} elseif ($ext == 'js') {
				$data['text/javascript'][] = '<script type="text/javascript" src="' . $value . '"></script>';
			}
		}
		$output = "<!-- Css Links -->\n" . implode("\n", $data['text/css']) . "\n\n<!-- JS Links -->\n" . implode("\n", $data['text/javascript']);
		
		return $output;
	}
	
	/**
	 * @param $message
	 */
	public function addFlashMessage($message)
	{
		$currentMessages = Yii::app()->user->getFlash('messages');

		if (!is_array($currentMessages))
			$currentMessages = array();

		Yii::app()->user->setFlash('messages', CMap::mergeArray($currentMessages, array($message))); 
	}

	public function setPageTitle($title)
	{
		$this->_pageTitle=$title;
	}


	public function getPageTitle()
	{
		//$title=Yii::app()->settings->get('core', 'siteName');
		$controller = $this->getUniqueId();
		
		$sql = Yii::app()->db->createCommand()
				    ->select('*')
				    ->from('SeoOptimise')
				    ->where('uri=:uri', array(':uri'=> Yii::app()->request->getUrl()))
				    ->queryRow();
		
		
		if ($controller == 'store/category') {
			Yii::import('application.modules.store.widgets.filter.SFilterRenderer');
			$filters = new SFilterRenderer();
			$active = $filters->getActiveFilters();
			
			$FString = array();

			if ($active) {
				foreach($active as $filter) {
					$FString[] = $filter['label'];
					unset($filter);
				}

				$this->_pageTitle .= ' '.implode(' ', $FString);
			}
		}
		
		$title = 'интернет магазин ikiddy';
		
		if(!empty($this->_pageTitle))
			$title=$this->_pageTitle.=' - '.$title;
		if ($sql['title']) {
			$title = $sql['title'];
		}
		
		return $title;
	}
}
