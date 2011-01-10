<?php
  include("header_active.php");
?>
<div class="main_section">

<h1 class="simple_header">
Адміністрування
</h1>

<?php require_once('RealEstateAgency/Util.php'); ?>

<form method="POST" id="loginform" <?php echo 'action="' . tools_url(array('page'=>'admin')) . '"' ?> >

<input type="hidden" name="page" value="admin" />

<?php if($this->incorrect_login_message): ?>
<span style="color:red;">Неправильне ім'я користувача або пароль.</span><br />
<?php endif; ?>

<?php if($this->incorrect_login_message_time): ?>
<span style="color:red;">Будь-ласка, почекайте, система не може прийняти Ваш запит.</span><br />
<?php endif; ?>

<?php if( ! $this->logged ): ?>
<!-- Login -->
<input type="hidden" name="login" value="1" />
Ім'я: <input type="text" name="nick" />
<br />
Пароль: <input type="password" name="key" size="5" />
<br />
<input type="submit" name="submit" value="Логин" />
<?php else: ?>

<p>
<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'object') ) . '">'; ?>
<nobr>Запропонувати нерухомість - продажа</nobr></a>
</p>

<p>
<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'object','op_type'=>'1') ) . '">'; ?>
<nobr>Запропонувати нерухомість - оренда</nobr></a>
</p>
<input type="hidden" name="logged" value="yes" />

<!-- <input type="submit" name="disconnect" value="Розірвати зв'язок" /> -->

<?php endif; ?>

</form>


</div> <!-- main_section : end -->

<?php
	include("footer_1.php");
?>
