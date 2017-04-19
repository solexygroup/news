<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modelitem Joomla.
jimport('joomla.application.component.modelitem');

/**
 * Модель сообщения компонента news.
 */
class NewsModelNews extends JModelItem
{
	/**
	 * Получаем сообщение.
	 *
	 * @param   int  $id  Id сообщения.
	 *
	 * @return  object  Объект сообщения, которое отображается пользователю.
	 *
	 * @throws  Exception  Если сообщение не найдено.
	 *
	 */
	public function getItem($id = null)
	{
		// Если id не установлено, то получаем его из состояния.
		$id = (!empty($id)) ? $id : (int) $this->getState('message.id');

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$id]))
		{
			// Конструируем SQL запрос.
			$query = $this->_db->getQuery(true);
			$query->select('h.greeting, h.intro')
				->from('#__news as h')
				->where('h.state > 0');

			$this->_db->setQuery($query);
			$data = $this->_db->loadObjectList();

			// Генерируем исключение, если сообщение не найдено.
			if (empty($data))
			{
				throw new Exception(JText::_('COM_NEWS_ERROR_MESSAGE_NOT_FOUND'), 404);
			}

			// Загружаем JSON строку параметров.

			$this->_item[$id] = $data;
		}

		return $this->_item[$id];
	}

	/**
	 * Метод для авто-заполнения состояния модели.
	 *
	 * Заметка. Вызов метода getState в этом методе приведет к рекурсии.
	 *
	 * @return  void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Получаем Id сообщения из Запроса.
		$id = $app->input->getInt('id', 0);

		// Добавляем Id сообщения в состояние модели.
		$this->setState('message.id', $id);

		// Загружаем глобальные параметры.
		$params = $app->getParams();

		// Добавляем параметры в состояние модели.
		$this->setState('params', $params);

		parent::populateState();
	}
}
