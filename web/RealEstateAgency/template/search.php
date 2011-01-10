<?php
  include("header_active.php");
?>
<?php
	require_once 'RealEstateAgency/Object/RealEstateObjectSupport.php';
	require_once 'RealEstateAgency/Object/SearchPaginator.php';
?>
<div class="main_section">

<!-- style="border: solid 1px gray;" -->
<div class="search"> <!-- div search -->

<div style="height:2.5em;"> <!-- div filter -->
<b>

<form method="POST" <?php echo 'action="' . tools_url(array('page'=>$this->page,'op_type'=>$this->op_type)) . '"' ?> >

<div style="float:right;"> <!-- div filter float -->

<span class="filter">
<label>Період, днів&nbsp;</label>
<input tabindex="1000" type="text" name="search_period" maxlength="2" size="2"
<?php echo "value=\"" . $this->escape($this->search_period) . "\""; ?>
 />
</span>

<span class="filter">
<label>Кімнат&nbsp;</label>
<input tabindex="1001" type="text" name="search_rooms" maxlength="2" size="2"
<?php echo "value=\"" . $this->escape($this->search_rooms) . "\""; ?>
 />
</span>

<span class="filter">
<label>Район / м.Київ&nbsp;</label>
<?php echo RealEstateAgency_Util::htmlSelect('search_city_district', 'tabindex="1002"', tools_get_search_city_districts(), $this->search_city_district, '', ''); ?>
</span>

<span class="filter">
<label>Ціна, від&nbsp;</label>
<input tabindex="1003" type="text" name="search_price_1" maxlength="7" size="7"
<?php echo "value=\"" . $this->escape($this->search_price_1) . "\""; ?>
 />
<label>до&nbsp;</label>
<input tabindex="1004" type="text" name="search_price_2" maxlength="7" size="7"
<?php echo "value=\"" . $this->escape($this->search_price_2) . "\""; ?>
 />
</span>

<span class="filter">
<input tabindex="1005" type="submit" name="submit" value="Пошук" />
</span>

</div> <!-- div filter float -->

</form>

</b>
</div> <!-- div filter -->

<table style="clear:both;">

	<th>
	Область,
	район
	</th>
	<th>
	Насел. пункт
	</th>
	<th>
	Район міста
	</th>
	<th>
	Вулиця
	</th>
	<th>
	Ціна
	</th>
<?php if(1 == $this->op_type) { ?>
	<th>
	Строк
	</th>
<?php } ?>
	<th>
	Кімнат
	</th>
	<th>
	&nbsp;
	</th>
	<th>
	Поверх
	</th>
	<th>
	Площа
	</th>
	<th>
	Фото
	</th>
	<th>
	Додаткові дані
	</th>
<?php
	if ($this->logged) {
		echo "<th>";
		echo "</th>\n";
	}
?>

<?php
    $data_as_list = array();
	$search_counter = 0;
    if ($this->list_of_settlements) {
        $data_as_list = $this->list_of_settlements->getList();
		$search_counter = $this->list_of_settlements->getCounter();
    }
	
	$data_as_list_count = count($data_as_list);
	
    foreach ($data_as_list as $index => $object) {
        echo '<tr>';
        
        echo '<td>';
        echo $this->escape($object->getAreaName());
        
		$districtName = $object->getDistrictName();
		if ($districtName == '...') {
			$districtName = '';
		}
		if ($districtName != '') {
			echo ", ";
		}
        echo $this->escape($districtName);
        echo '</td>';
        
        echo '<td>';
		$settlementName = $object->getSettlementName();
		if ($settlementName == NULL) {
			$settlementName = $object->getLocationText();
		}
        echo $this->escape($settlementName);
        echo '</td>';
        
        echo '<td>';
        echo $this->escape($object->getSettlementPartName());
        echo '</td>';
        
        echo '<td>';
        echo $this->escape($object->getStreet());
        echo ' ';
        echo $this->escape($object->getHouseNumber());
		
		if ($object->getSettlementSubPartName() != NULL) {
			echo $this->escape( ' (' . $object->getSettlementSubPartName() . ')' );
		}
		
        echo '</td>';
        
        echo '<td>';
        echo $this->escape($object->getPrice());
        echo '</td>';
        
		if(1 == $this->op_type) {
			echo '<td>';
			echo $this->escape($object->getRentPeriod());
        	echo '</td>';
		}
		
		echo '<td align="center">';
        echo $this->escape($object->getRooms());
        echo '</td>';
		
		echo '<td>';
		echo RealEstateAgency_Object_RealEstateObjectSupport::getRoomsTypeShortly( $object->getRoomsType() );
		echo '&nbsp;';
		echo '</td>';
		
		echo '<td>';
        echo $this->escape($object->getFloor());
        echo '&nbsp;/&nbsp;';
        echo $this->escape($object->getFloors());
        echo '</td>';
		
        echo '<td>';
        echo $this->escape($object->getSquareAll());
        echo '&nbsp;/&nbsp;';
        echo $this->escape($object->getSquareLive());
        echo '&nbsp;/&nbsp;';
        echo $this->escape($object->getSquareKitchen());
        echo '</td>';
        
		$objectID = $object->getObjectID();
		
		echo '<td>';
	if ($object->isAnyImage()) {
		echo '&nbsp;';
		echo tools_startTag_a(array('page'=>'image', 'object_id'=>$objectID),array('class'=>'photolink'));
		// echo '<img width="35" height="25" alt="Фото" src="photo.gif"/>';
		echo 'Фото';
		echo tools_endTag_a();
		echo '&nbsp;';
	} else {
		echo '&nbsp;';
	}
		echo '</td>';
		
		echo '<td>';
        echo $this->escape($object->getDescription());
        echo '</td>';
		
        if ($this->logged) {
			echo '<td>';
			if ($object->isEditable()) {
				echo tools_startTag_a(array('page'=>'update', 'object_id'=>$objectID),array());
				echo 'Редагувати';
				echo tools_endTag_a();
			}
			echo '</td>';
		}
		
        echo "</tr>\n";
    }
?>


<?php
	$colspan = 11;
	if(1 == $this->op_type) {
		$colspan = 12;
	}

	$url_parameters = array('page'=>$this->page,'op_type'=>$this->op_type, 'search_position'=>$this->search_position);
	$navigation = RealEstateAgency_Object_SearchPaginator::drawPaginator($search_counter, $url_parameters, $data_as_list_count);

?>

	<?php if($navigation): ?>

<tr>
	<td style="text-align: left; height: 2.0em;" colspan="<?php echo($colspan); ?>" >
		<?php echo($navigation); ?>
	</td>
</tr>

	<?php endif ?>

</table>

</div> <!-- div search -->



</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>
