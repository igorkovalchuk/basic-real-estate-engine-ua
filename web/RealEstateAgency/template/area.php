<?php
  include("header_active.php");
?>
<div class="main_section">

<h1 class="simple_header">
Адміністрування: області
</h1>

<form method="POST" <?php echo 'action="' . RealEstateAgency_Util::url(array('page'=>'area')) . '"' ?> >

<input type="hidden" name="page" value="area" />

<input type="hidden" name="object_id"
<?php echo('value="' . $this->escape($this->object_id) . '"'); ?>
 />

Назва області: <input type="text" name="object_name"
<?php echo('value="' . $this->escape($this->object_name) . '"'); ?>
 />

<?php if( $this->page_mode == 'edit' ): ?>
<input type="hidden" name="object_action" value="update" />
<input type="submit" name="submit" value="Записати виправлені дані" />
<?php else: ?>
<input type="hidden" name="object_action" value="new" />
<input type="submit" name="submit" value="Ввести нові дані" />
<?php endif; ?>

</form>

<?php if( $this->already_saved ): ?>
<br /><span>Вибачте, але такі дані вже були введені раніше.</span><br />
<?php endif; ?>

<?php if( $this->page_mode == 'edit' ): ?>
<p>
<?php echo RealEstateAgency_Util::startTag_a(array('page'=>'area'), array('title'=>'Ввести нові дані')); ?>
Ввести нові дані...
<?php echo RealEstateAgency_Util::endTag_a(); ?>
</p>
<?php endif; ?>

<table style="border: solid 1px gray;">

<?php
    $data_as_list = array();
    if ($this->data_as_list) {
        $data_as_list = $this->data_as_list->getList();
    }
    foreach ($data_as_list as $index => $object) {
        echo '<tr>';
        echo '<td>';
        echo RealEstateAgency_Util::startTag_a(array('page'=>'area', 'object_action'=>'edit', 'object_id'=>$object->getId()), array('title'=>'Редагувати запис'));
        echo $this->escape($object->getObjectName());
        echo RealEstateAgency_Util::endTag_a();
        echo '</td>';
        echo '<td style="padding:5px;padding-left:10px;">';
        echo RealEstateAgency_Util::startTag_a(array('page'=>'area', 'object_action'=>'delete', 'object_id'=>$object->getId()), array('title'=>'Видалити запис'));
        echo '<img src="images/delete15white.png" alt="Видалити запис">';
        echo RealEstateAgency_Util::endTag_a();
        echo '</td>';
        echo '</tr>';
    }
?>

</table>

</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>
