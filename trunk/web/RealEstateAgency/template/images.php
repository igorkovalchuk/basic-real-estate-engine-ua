<?php
  include("header_active.php");
?>
<?php
	require_once 'RealEstateAgency/Object/RealEstateObject.php';
?>
<div class="main_section">

<?php
	$object_id = $this->object_id;
	$data = RealEstateAgency_Object_RealEstateObject::getImagesListStatic($object_id);
	
	$started = false;
	
	if ($data != NULL) {
		foreach ($data as $index => $filename) {
			
			$filename = basename($filename);

			$url = tools_image_url($filename);
			if (! $started) {
				echo '<hr>';
			}
			$started = true;
			echo '<p align="center">';
			echo '<img src="';
			echo $url;
			echo '" />';
			echo '</p>';
			echo '<hr>';
		}
	}
?>


</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>
