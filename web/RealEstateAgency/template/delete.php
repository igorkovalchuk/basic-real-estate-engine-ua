<?php
  include("header_active.php");
?>
<?php
	require_once 'RealEstateAgency/Object/RealEstateObject.php';
?>
<div class="main_section">



<?php
	$objectID = $this->object_id;
	$globalData = $this->global_data;
	$object = RealEstateAgency_Object_RealEstateObject::loadById($globalData, $objectID);
	if ( $object != NULL ) {
		if ( $object->isEditable() ) {
			RealEstateAgency_Object_RealEstateObject::deleteById($globalData, $objectID);
			
			$dir = RealEstateAgency_Const::UPLOAD_IMAGES_DIR;
			
			$data = $object->getImagesList();
			if ($data != NULL) {
				foreach ($data as $index => $name) {
					$filename = $dir.$name;
					unlink($filename);
				}
			}
			
			echo '<p style="color:green;">Даний об\'єкт нерухомості було видалено зі списку.</p>';
		}
	}
?>


</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>
