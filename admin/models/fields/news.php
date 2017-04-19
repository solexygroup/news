<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем тип поля list.
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Класс поля формы news компонента news.
 */
class JFormFieldNews extends JFormFieldList
{
	/**
	 * Тип поля.
	 *
	 * @var  string
	 */
	protected $type = 'News';

	/**
	 * Метод для получения списка опций для поля списка.
	 *
	 * @return  array  Массив JHtml опций.
	 */
	protected function getOptions()
	{
		// Получаем объект базы данных.
		$db = JFactory::getDbo();

		// Конструируем SQL запрос.
		$query = $db->getQuery(true);
		$query->select('h.id, h.greeting, h.catid')
			->from('#__news as h')
			->select('c.title as category')
			->leftJoin('#__categories AS c ON c.id = h.catid')
			->where('h.state > 0');
		$db->setQuery($query);
		$messages = $db->loadObjectList();

		// Массив JHtml опций.
		$options = array();

		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id,
					$message->greeting . ($message->catid ? ' (' . $message->category . ')' : '')
				);
			}
		}
		else
		{
			$options[] = JHtml::_('select.option', 0, JText::_('COM_NEWS_ERROR_MESSAGE_NOT_FOUND'));
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
