<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем логирование.
JLog::addLogger(
	array('text_file' => 'com_news.php'),
	JLog::ALL,
	array('com_news')
);

// Устанавливаем обработку ошибок в режим использования Exception.
JError::$legacy = false;

// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');

// Получаем экземпляр контроллера с префиксом News.
$controller = JControllerLegacy::getInstance('News');

// Исполняем задачу task из Запроса.
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task', 'display'));

// Перенаправляем, если перенаправление установлено в контроллере.
$controller->redirect();
