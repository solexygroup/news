<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Проверка доступа.
if (!JFactory::getUser()->authorise('core.manage', 'com_news'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 401);
}

// Устанавливаем обработку ошибок в режим использования Exception.
JError::$legacy = false;

// Подключаем хелпер.
JLoader::register('NewsHelper', dirname(__FILE__) . '/helpers/news.php');

// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');

// Получаем экземпляр контроллера с префиксом news.
$controller = JControllerLegacy::getInstance('News');

// Исполняем задачу task из Запроса.
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task', 'display'));

// Перенаправляем, если перенаправление установлено в контроллере.
$controller->redirect();
