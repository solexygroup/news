<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
foreach($this->item as $item){
	echo "<h1>" . $item->greeting . "</h1>";
	echo $item->intro . "<br/><br/>";
}
?>
