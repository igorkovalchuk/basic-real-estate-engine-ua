<?php
  include("header_active.php");
?>
<div class="main_section">

<script type="text/javascript">
	function onObjectDelete() {
		alert("Test");
		return false;
	}
</script>

<?php
require_once 'RealEstateAgency/Object/RealEstateObjectSupport.php';
?>

<p><b>{
<?php if(0 == $this->op_type) { ?>
Продажа
<?php } else if(1 == $this->op_type) { ?>
Оренда
<?php } ?>
}</b></p>

<form enctype="multipart/form-data" method="POST" <?php echo 'action="' . tools_url(array('page'=>'update')) . '"' ?> >

<input type="hidden" name="op_type" 
<?php
    echo "value=\"" . $this->escape($this->op_type) . "\"";
?>
 />

<input type="hidden" name="page" value="update" />

<input type="hidden" name="object_id" 
<?php echo('value="' . $this->escape($this->object_id) . '"'); ?>
/>

<p>
<?php
echo $this->location_details;
?>
</p>

<?php
if ($this->viewmode == 'showpage') {
	// First page;
?>

<p>
<?php
if (count($this->validation)) {
    echo tools_validation_error_string("generally","Помилка. Будь-ласка, перевірте дані ще раз.");
}
?>
</p>

<p>
<?php
echo tools_startTag_a(array('page'=>'delete', 'object_id'=>$this->object_id),array());
echo 'Видалити об\'єкт';
echo tools_endTag_a();
?>
</p>

<table>

<?php if(1 == $this->op_type) { ?>
<tr>
<td>
Строк оренди:
</td>
<td>
<input type="text"  name="rent_period"
<?php echo('value="' . $this->escape($this->rent_period) . '"'); ?> 
/>
<?php echo tools_validation_error('rent_period',$this->validation); ?>
</td>
</tr>
<?php } ?>

<tr>
<td>
Тип нерухомості:
</td>
<td>
<?php
    $data = NULL;
	if (1 == $this->op_type) {
		$data = RealEstateAgency_Object_RealEstateObjectSupport::listOfTypesForRent();
	} else {
		$data = RealEstateAgency_Object_RealEstateObjectSupport::listOfTypes();
	}
    echo RealEstateAgency_Util::htmlSelect('r_e_type', '', $data, $this->r_e_type, NULL, '');
?>
    <?php echo tools_validation_error('r_e_type',$this->validation); ?>
</td>
</tr>

<tr>
<td>
Кількість кімнат:
</td>
<td>
<input type="text" name="rooms"
<?php echo('value="' . $this->escape($this->rooms) . '"'); ?>
/>
<?php echo tools_validation_error('rooms',$this->validation); ?>
</td>
</tr>

<tr>
<td>
Кімнати:
</td>
<td>
<?php
    $data = RealEstateAgency_Object_RealEstateObjectSupport::listOfRoomsTypes();
    echo RealEstateAgency_Util::htmlSelect('rooms_type', '', $data, $this->rooms_type, NULL, '');
?>
<?php echo tools_validation_error('rooms_type',$this->validation); ?>
</td>
</tr>

<tr style="background:#dddddd;">
<td>
Вартість, євро:
</td>
<td>
    <input type="text" name="price"
        <?php echo('value="' . $this->escape($this->price) . '"'); ?>
    />
    <?php echo tools_validation_error('price',$this->validation); ?>
</td>
</tr>

<?php
    $data = $this->list_of_city_districts;
    if ($data && count($data)) {
?>

<tr>
<td>
Виберіть район:
</td>
<td>
<?php echo RealEstateAgency_Util::htmlSelect('city_district', '', $data, $this->city_district, '', ''); ?>

<?php
    }
?>
<?php echo tools_validation_error('city_district',$this->validation); ?>
</td>
</tr>

<tr>
<td>
Масив:
</td>
<td>
<input type="text"  name="city_sub_district"
<?php echo('value="' . $this->escape($this->city_sub_district) . '"'); ?> 
/>
<?php echo tools_validation_error('city_sub_district',$this->validation); ?>
</td>
</tr>

<tr>
<td>
Вулиця:
</td>
<td>
<input type="text"  name="street"
<?php echo('value="' . $this->escape($this->street) . '"'); ?> 
/>
<?php echo tools_validation_error('street',$this->validation); ?>
</td>
</tr>

<tr>
<td>
Номер будинку:
</td>
<td>
<input type="text"  name="house_num"
<?php echo('value="' . $this->escape($this->house_num) . '"'); ?> 
/>
<?php echo tools_validation_error('house_num',$this->validation); ?>
</td>
</tr>

<tr style="background:#dddddd;">
<td>
Загальна площа:
</td>
<td>
<input type="text"  name="sq_all"
<?php echo('value="' . $this->escape($this->sq_all) . '"'); ?> 
/>
<?php echo tools_validation_error('sq_all',$this->validation); ?>
</td>
</tr>

<tr style="background:#dddddd;">
<td>
Жила площа:
</td>
<td>
<input type="text"  name="sq_live"
<?php echo('value="' . $this->escape($this->sq_live) . '"'); ?> 
/>
<?php echo tools_validation_error('sq_live',$this->validation); ?>
</td>
</tr>

<tr style="background:#dddddd;">
<td>
Площа кухні:
</td>
<td>
<input type="text"  name="sq_kitchen"
<?php echo('value="' . $this->escape($this->sq_kitchen) . '"'); ?> 
/>
<?php echo tools_validation_error('sq_kitchen',$this->validation); ?>
</td>
</tr>

<?php if(
	($this->r_e_type != RealEstateAgency_Const::TYPE_FLAT_NUMBER) && 
	($this->r_e_type != RealEstateAgency_Const::TYPE_ROOM_NUMBER) 
) { ?>
<tr style="background:#dddddd;">
<td>
Земля, площа:
</td>
<td>
<input type="text"  name="sq_land"
<?php echo('value="' . $this->escape($this->sq_land) . '"'); ?> 
/>
<?php echo tools_validation_error('sq_land',$this->validation); ?>
</td>
</tr>
<?php } ?>

<tr>
<td>
Поверх:
</td>
<td>
<input type="text"  name="floor"
<?php echo('value="' . $this->escape($this->floor) . '"'); ?> 
/>
<?php echo tools_validation_error('floor',$this->validation); ?>
</td>
</tr>

<tr>
<td>
Поверхів:
</td>
<td>
<input type="text"  name="floors"
<?php echo('value="' . $this->escape($this->floors) . '"'); ?> 
/>
<?php echo tools_validation_error('floors',$this->validation); ?>
</td>
</tr>



<tr>
<td>
Додаткова інформація:
</td>
<td>
<textarea type="text" name="description" rows="3" cols="50">
<?php echo($this->escape($this->description)); ?>
</textarea>
<?php echo tools_validation_error('description',$this->validation); ?>
</td>
</tr>

</table>

<p>
<input type="hidden" name="MAX_FILE_SIZE" 
<?php echo('value="' . RealEstateAgency_Const::MAX_FILE_SIZE . '"'); ?> 
/>

Додати зображення: <input name="userfile" type="file" />
</p>

<p>
<input type="submit" name="just_save" value="Записати" />
</p>

<?php
    // End of Page 1
} else if ($this->viewmode == 'resultpage') {
    // Page 2
?>



<p>
<b><span style="color:green;">Ваші дані записані. Дякуємо!</span></b>
</p>

<p>
<?php if ($this->upload_status_error) { ?>
	<b><span style="color:red;"><?php echo $this->escape($this->upload_status); ?></span></b>
<?php } else { ?>
	<b><span style="color:green;"><?php echo $this->escape($this->upload_status); ?></span></b>
<?php } ?>
</p>


<?php
    // End of page 2
} else {
?>

Помилка збереження даних.

<?php
}
?>

</form>

</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>
