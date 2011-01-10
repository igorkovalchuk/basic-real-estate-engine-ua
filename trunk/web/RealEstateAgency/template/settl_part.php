<?php
  include("header_active.php");
?>
<div class="main_section">

<h1 class="simple_header">
�������������: ������ ����
</h1>

<form method="POST" <?php echo 'action="' . RealEstateAgency_Util::url(array('page'=>'settl_part')) . '"' ?> >

<input type="hidden" name="page" value="settl_part" />

<input type="hidden" name="object_id"
<?php echo('value="' . $this->escape($this->object_id) . '"'); ?>
 />

<?php if( ! ( $this->sections_ready & RealEstateAgency_Const::FILTER_AREA ) ): ?>
    <!-- select areas, button 'next' -->
    �������:
    <?php
        $data = $this->list_of_areas->getArray();
        echo RealEstateAgency_Util::htmlSelect('area_id', '', $data, $this->area_id, '������� �������', '');
    ?>
    <input type="submit" name="do_select" value="Գ���������" />
<?php elseif( ! ( $this->sections_ready & RealEstateAgency_Const::FILTER_DISTRICT ) ): ?>

    <?php
        echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl_part', 'filter_action'=>'reset_area') ) . '">'.$this->escape($this->area_name).' �������</a>';
        echo '<br />';
        $data = $this->list_of_districts->getArray();
        echo RealEstateAgency_Util::htmlSelect('district_id', '', $data, $this->district_id, '������� �����', '');
    ?>
    <input type="submit" name="do_select" value="Գ���������" />


<?php elseif( ! ( $this->sections_ready & RealEstateAgency_Const::FILTER_SETTLEMENT ) ): ?>
    <?php
        echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl_part', 'filter_action'=>'reset_area') ) . '">'.$this->escape($this->area_name).' �������</a>';
        echo '<br />';
        echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl_part', 'filter_action'=>'reset_district') ) . '">'.$this->escape($this->district_name).' �����</a>';
        echo '<br />';
        $data = $this->list_of_settlements->getArray();
        echo RealEstateAgency_Util::htmlSelect('settlement_id', '', $data, $this->settlement_id, '������� ��������� �����', '');
    ?>
    <input type="submit" name="do_select" value="Գ���������" />

<?php elseif( $this->filter_ready ): ?>
        <?php
        // Filter complete;
        echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl_part', 'filter_action'=>'reset_area') ) . '">'.$this->escape($this->area_name).' �������</a>';
        echo '<br />';
        echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl_part', 'filter_action'=>'reset_district') ) . '">'.$this->escape($this->district_name).' �����</a>';
        echo '<br />';
        echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl_part', 'filter_action'=>'reset_settlement') ) . '">'.$this->escape($this->settlement_name).'</a>';
        echo '<br />';
        ?>

����� ������ ����: <input type="text" name="object_name"
<?php echo('value="' . $this->escape($this->object_name) . '"'); ?>
 />

<?php if( $this->page_mode == 'edit' ): ?>
<input type="hidden" name="object_action" value="update" />
<input type="submit" name="do_submit" value="�������� ��������� ���" />
<?php else: ?>
<input type="hidden" name="object_action" value="new" />
<input type="submit" name="do_submit" value="������ ��� ���" />
<?php endif; ?>

<?php else: ?>
<?php
        throw new Exception('Web page. Detected incorrect filter state.');
?>
<?php endif; ?>

<br />

</form>

<?php if( $this->already_saved ): ?>
<br /><span>�������, ��� ��� ��� ��� ���� ������ �����.</span><br />
<?php endif; ?>

<?php if( $this->page_mode == 'edit' ): ?>
<p>
<?php echo RealEstateAgency_Util::startTag_a(array('page'=>'settl_part'), array('title'=>'������ ��� ���')); ?>
������ ��� ���...
<?php echo RealEstateAgency_Util::endTag_a(); ?>
</p>
<?php endif; ?>

<table style="border: solid 1px gray;">

<?php
    $data_as_list = array();
    if ($this->list_of_settlement_parts) {
        $data_as_list = $this->list_of_settlement_parts->getList();
    }
    foreach ($data_as_list as $index => $object) {
        echo '<tr>';
        echo '<td>';
        echo RealEstateAgency_Util::startTag_a(array('page'=>'settl_part', 'object_action'=>'edit', 'object_id'=>$object->getId()), array('title'=>'���������� �����'));
        echo $this->escape($object->getObjectName());
        echo RealEstateAgency_Util::endTag_a();
        echo '</td>';
        echo '<td style="padding:5px;padding-left:10px;">';
        echo RealEstateAgency_Util::startTag_a(array('page'=>'settl_part', 'object_action'=>'delete', 'object_id'=>$object->getId()), array('title'=>'�������� �����'));
        echo '<img src="images/delete15white.png" alt="�������� �����">';
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
