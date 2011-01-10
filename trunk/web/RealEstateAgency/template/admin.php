<?php
  include("header_active.php");
?>
<div class="main_section">

<h1 class="simple_header">
�������������
</h1>

<?php require_once('RealEstateAgency/Util.php'); ?>

<form method="POST" id="loginform" <?php echo 'action="' . tools_url(array('page'=>'admin')) . '"' ?> >

<input type="hidden" name="page" value="admin" />

<?php if($this->incorrect_login_message): ?>
<span style="color:red;">����������� ��'� ����������� ��� ������.</span><br />
<?php endif; ?>

<?php if($this->incorrect_login_message_time): ?>
<span style="color:red;">����-�����, ���������, ������� �� ���� �������� ��� �����.</span><br />
<?php endif; ?>

<?php if( ! $this->logged ): ?>
<!-- Login -->
<input type="hidden" name="login" value="1" />
��'�: <input type="text" name="nick" />
<br />
������: <input type="password" name="key" size="5" />
<br />
<input type="submit" name="submit" value="�����" />
<?php else: ?>

<p>
<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'object') ) . '">'; ?>
<nobr>������������� ���������� - �������</nobr></a>
</p>

<p>
<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'object','op_type'=>'1') ) . '">'; ?>
<nobr>������������� ���������� - ������</nobr></a>
</p>
<input type="hidden" name="logged" value="yes" />

<!-- <input type="submit" name="disconnect" value="�������� ��'����" /> -->

<?php endif; ?>

</form>


</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>
