<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление списка сообщений компонента news.
 */
class newsViewNewsitems extends JViewLegacy
{
	/**
	 * Сообщения.
	 *
	 * @var  array
	 */
	protected $items;

	/**
	 * Постраничная навигация.
	 *
	 * @var  object
	 */
	protected $pagination;

	/**
	 * Состояние модели.
	 *
	 * @var  object
	 */
	protected $state;

	/**
	 * Доступы пользователя.
	 *
	 * @var  object
	 */
	protected $canDo;

	/**
	 * Отображаем список сообщений.
	 *
	 * @param   string  $tpl  Имя файла шаблона.
	 *
	 * @return  void
	 *
	 * @throws  Exception
	 */
	public function display($tpl = null)
	{
		try
		{
			// Получаем данные из модели.
			$this->items = $this->get('Items');

			// Получаем объект постраничной навигации.
			$this->pagination = $this->get('Pagination');

			// Получаем объект состояния модели.
			$this->state = $this->get('State');

			// Получаем доступы пользователя.
			$this->canDo = NewsHelper::getActions($this->state->get('filter.category_id'));

			// Устанавливаем панель инструментов.
			$this->addToolBar();

			// Отображаем представление.
			parent::display($tpl);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Устанавливает панель инструментов.
	 *
	 * @return void
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_NEWS_MANAGER_NEWS'), 'news');

		if ($this->canDo->get('core.create'))
		{
			JToolBarHelper::addNew('news.add');
		}

		if ($this->canDo->get('core.edit'))
		{
			JToolBarHelper::editList('news.edit');
		}

		if ($this->canDo->get('core.edit.state'))
		{
			JToolBarHelper::divider();
			JToolbarHelper::publish('news.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('news.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('news.archive');
		}

		if ($this->state->get('filter.state') == -2 && $this->canDo->get('core.delete'))
		{
			JToolBarHelper::deleteList('', 'news.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($this->canDo->get('core.edit.state'))
		{
			JToolBarHelper::trash('news.trash');
		}

		if ($this->canDo->get('core.admin'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_news');
		}
	}
}
