<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Данные по сортировке.
$listDirn	= $this->escape($this->state->get('list.direction'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
$saveOrder	= $listOrder == 'ordering';

foreach ($this->items as $i => $item) :
	$canEdit = JFactory::getUser()->authorise('core.edit', 'com_news.message.' . $item->id);
	$canChange = JFactory::getUser()->authorise('core.edit.state', 'com_news.message.' . $item->id);
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php if ($canEdit) : ?>
				<a href="<?php echo JRoute::_('index.php?option=com_news&task=news.edit&id=' . (int) $item->id); ?>">
					<?php echo $item->greeting; ?>
				</a>
			<?php else: ?>
				<?php echo $item->greeting; ?>
			<?php endif; ?>
		</td>
		<td class="center">
			<?php echo $this->escape($item->category_title); ?>
		</td>
		<td class="center">
			<?php echo JHtml::_('jgrid.published', $item->state, $i, 'newsitems.', $canChange); ?>
		</td>
		<td class="order">
			<?php if ($saveOrder) : ?>
				<?php if ($listDirn == 'asc') : ?>
					<span><?php echo $this->pagination->orderUpIcon($i, true, 'newsitems.orderup', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
					<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'newsitems.orderdown', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
				<?php elseif ($listDirn == 'desc') : ?>
					<span><?php echo $this->pagination->orderUpIcon($i, true, 'newsitems.orderdown', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
					<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'newsitems.orderup', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
				<?php endif; ?>
			<?php endif; ?>
			<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
			<input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" <?php echo $disabled; ?> class="text-area-order" />
		</td>
		<td>
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
