<?php
  include("header_active.php");
?>
<div class="main_section">

<h1 class="simple_header">
�������, ���� �� ��� �������� ������� ��
</h1>

�� ������:
<ul>
<li>
������� �� <a href="index.php">�������� ������� �����</a> �� ���������� ��������� ��;
</li>
<li>
�������������� ����������� ���� ��� ��������� ������ 䳿;
</li>
<li>
���������� �� �������� 8-044-<b>251-04-03</b> � �������� ����������� ������������.
</li>
</ul>

<?php if($this->page_error_message != NULL): ?>
<div style="border: solid 1px red;font-style:italic;background:red;color:white;">
<span style="font-style:bold;">������ �����: </span><br />
<textarea style="width:100%;height:10.0em;color: gray;">
<?php
echo $this->page_error_message;
?>
</textarea>
<?php endif; ?>
</div>

<p>
<?php
$date = ( strftime("%A, %d.%m.%Y, %H:%M:%S") );
echo $date;
?>
</p>

</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>