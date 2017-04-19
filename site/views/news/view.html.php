<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление сообщения компонента news.
 */
class NewsViewNews extends JViewLegacy
{
	/**
	 * Сообщение.
	 *
	 * @var  object
	 */
	protected $item;

	/**
	 * Переопределяем метод display класса JViewLegacy.
	 *
	 * @param   string  $tpl  Имя файла шаблона.
	 *
	 * @throws  Exception  Если сообщение не найдено.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		try
		{
			// Получаем сообщение.
			$this->item = $this->get('Item');

			// Подготавливаем документ.
			$this->_prepareDocument();

			// Отображаем представление.
			parent::display($tpl);
		}
		catch (Exception $e)
		{
			if ($e->getCode() == 404)
			{
				// Сообщение не найдено.
				throw new Exception($e->getMessage(), 404);
			}

			JFactory::getApplication()->enqueueMessage(JText::_('COM_NEWS_ERROR_OCCURRED'), 'error');
			JLog::add($e->getMessage(), JLog::ERROR, 'com_news');
		}
	}

	/**
	 * Подготавливает документ.
	 *
	 * @return  void
	 */
	protected function _prepareDocument()
	{
		$app   = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Так как приложение устанавливает заголовок страницы по умолчанию,
		// мы получаем его из пункта меню.
		$menu = $menus->getActive();



	}
}
