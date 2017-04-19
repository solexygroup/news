<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку controlleradmin Joomla.
jimport('joomla.application.component.controlleradmin');

/**
 * News контроллер.
 */
class NewsControllerNewsItems extends JControllerAdmin
{
	/**
	 * Прокси метод для getModel.
	 *
	 * @param   string  $name    Имя класса модели.
	 * @param   string  $prefix  Префикс класса модели.
	 *
	 * @return  object  Объект модели.
	 */
	public function getModel($name = 'News', $prefix = 'NewsModel')
	{
		return parent::getModel($name, $prefix, array('ignore_request' => true));
	}
}
