<?php if( ! tools_get_input("remote") ) { ?>

<div style="height: 0.5em;">
&nbsp;
</div>

<?php
  include("menu_1.php");
?>

<p>
&nbsp;
</p>

<div class="footer">

<?php //echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'unknown') ) . '">'; ?>
 (c) 2009, ТОВ &quot;...&quot; / Агентство недвижимости ООО &quot;...&quot; , Украина
<?php //echo '</a>'; ?>
</div>

<p>
&nbsp;
</p>

<pre>

<?php
    // Print profiler data;
    // RealEstateAgency_TestUtil::printVerificationData();
    // RealEstateAgency_TestUtil::printProfilerData();
?>

</pre>

<?php } ?>
</body>
</html>
