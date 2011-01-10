<?php
  include("header_active.php");
?>
<div class="main_section">

<h1 class="simple_header">
Вибачте, сайт не зміг виконати вказану дію
</h1>

Ви можете:
<ul>
<li>
перейти на <a href="index.php">стартову сторінку сайту</a> та спробувати повторити дію;
</li>
<li>
скористуватись навігаційним меню для виконання бажаної дії;
</li>
<li>
подзвонити по телефону 8-044-<b>251-04-03</b> і одержати безкоштовну консультацію.
</li>
</ul>

<?php if($this->page_error_message != NULL): ?>
<div style="border: solid 1px red;font-style:italic;background:red;color:white;">
<span style="font-style:bold;">Технічні деталі: </span><br />
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