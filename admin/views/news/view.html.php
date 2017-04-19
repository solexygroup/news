<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление редактирования сообщения.
 */
class newsViewNews extends JViewLegacy
{
	/**
	 * Сообщение.
	 *
	 * @var  object
	 */
	protected $item;

	/**
	 * Объект формы.
	 *
	 * @var  object
	 */
	protected $form;

	/**
	 * JavaScript файл валидации формы.
	 *
	 * @var  string
	 */
	protected $script;

	/**
	 * Доступы пользователя.
	 *
	 * @var  object
	 */
	protected $canDo;

	/**
	 * Отображает представление.
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
			$this->form = $this->get('Form');
			$this->item = $this->get('Item');
			$this->script = $this->get('Script');

			// Получаем доступы пользователя.
			$this->canDo = NewsHelper::getActions($this->item->catid, $this->item->id);

			// Устанавливаем панель инструментов.
			$this->addToolBar();

			// Отображаем представление.
			parent::display($tpl);

			// Устанавливаем документ.
			$this->setDocument();
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Устанавливает панель инструментов.
	 *
	 * @return  void
	 */
	protected function addToolBar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);

		JToolBarHelper::title($isNew ? JText::_('COM_NEWS_MANAGER_NEWS_NEW') : JText::_('COM_NEWS_MANAGER_NEWS_EDIT'), 'news');

		// Устанавливаем действия для новых и существующих записей.
		if ($isNew)
		{
			// Для новых записей проверяем право создания.
			if ($this->canDo->get('core.create'))
			{
				JToolBarHelper::apply('news.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('news.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('news.save2new', 'save-new.png',
										'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false
										);
			}

			JToolBarHelper::cancel('news.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			// Для существующих записей проверяем право редактирования.
			if ($this->canDo->get('core.edit'))
			{
				// Мы можем сохранять новую запись.
				JToolBarHelper::apply('news.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('news.save', 'JTOOLBAR_SAVE');

				// Мы можем сохранять  в новую запись, но нужна проверка на создание.
				if ($this->canDo->get('core.create'))
				{
					JToolBarHelper::custom('news.save2new', 'save-new.png',
											'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false
											);
				}
			}

			// Для сохранения копии записи проверяем право создания.
			if ($this->canDo->get('core.create'))
			{
				JToolBarHelper::custom('news.save2copy', 'save-copy.png',
										'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false
										);
			}

			JToolBarHelper::cancel('news.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
		}
	}

	/**
	 * Метод для установки свойств документа.
	 *
	 * @return  void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . $this->script);

	}

}
