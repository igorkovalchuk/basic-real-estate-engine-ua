<!-- menu - start -->
<!-- <h1 class="menu_header">Навігація:</h1> -->

<div class="menu">
    
		<?php
			$counters = $this->counters;
		?>
	
		<ul> <b>Продажа</b>
   
        <li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_FLAT) ) . '">'; ?>
                <nobr>квартири</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 0, RealEstateAgency_Const::TYPE_FLAT_NUMBER) ?>
        </li>
        <li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_ROOM) ) . '">'; ?>
                <nobr>кімнати</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 0, RealEstateAgency_Const::TYPE_ROOM_NUMBER) ?>
        </li>
        <li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_HOUSE) ) . '">'; ?>
                <nobr>будинки</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 0, RealEstateAgency_Const::TYPE_HOUSE_NUMBER) ?>
		</li>
		<li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_COTTAGE) ) . '">'; ?>
                <nobr>дачі</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 0, RealEstateAgency_Const::TYPE_COTTAGE_NUMBER) ?>
		</li>
		<li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_LAND) ) . '">'; ?>
                <nobr>земельні ділянки</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 0, RealEstateAgency_Const::TYPE_LAND_NUMBER) ?>
        </li>
        <li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_COMMERCIAL) ) . '">'; ?>
                <nobr>нежитловий фонд</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 0, RealEstateAgency_Const::TYPE_COMMERCIAL_NUMBER) ?>
        </li>
		</ul>
		
		<ul> <b>Оренда</b>
		<li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_FLAT, 'rent'=>'1') ) . '">'; ?>
                <nobr>квартири</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 1, RealEstateAgency_Const::TYPE_FLAT_NUMBER) ?>
		</li>
		<li>
				<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_ROOM, 'rent'=>'1') ) . '">'; ?>
                <nobr>кімнати</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 1, RealEstateAgency_Const::TYPE_ROOM_NUMBER) ?>
		</li>
		<li>
				<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_HOUSE, 'rent'=>'1') ) . '">'; ?>
                <nobr>будинки</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 1, RealEstateAgency_Const::TYPE_HOUSE_NUMBER) ?>
		</li>
		<li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_COTTAGE, 'rent'=>'1') ) . '">'; ?>
                <nobr>дачі</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 1, RealEstateAgency_Const::TYPE_COTTAGE_NUMBER) ?>
		</li>
		<li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_LAND, 'rent'=>'1') ) . '">'; ?>
                <nobr>земельні ділянки</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 1, RealEstateAgency_Const::TYPE_LAND_NUMBER) ?>
		</li>
		<li>
				<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>RealEstateAgency_Const::TYPE_COMMERCIAL, 'rent'=>'1') ) . '">'; ?>
                <nobr>нежитловий фонд</nobr></a>
				<?php echo RealEstateAgency_Object_Counters::getCounter($counters, 1, RealEstateAgency_Const::TYPE_COMMERCIAL_NUMBER) ?>
        </li>
		</ul>
     
</div>

        <?php if(! $this->logged): ?>

        <?php else: ?>

        <div class="menu_admin_active">
        
		<ul>
		
        <p>
        <li>
                <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'admin') ) . '">'; ?>
                <nobr>Адміністрування</nobr></a>
				&nbsp;/&nbsp;
				<?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'admin','disconnect'=>1) ) . '">'; ?>
                <nobr>Вихід</nobr></a>
				
        </li>
        </p>

                  <p>
                  <li>
                        <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'object') ) . '">'; ?>
                        <nobr>Запропонувати&nbsp;-&nbsp;продажа</nobr></a>
                  </li>
                  </p>

                  <p>
                  <li>
                        <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'object','op_type'=>'1') ) . '">'; ?>
                        <nobr>Запропонувати&nbsp;-&nbsp;оренда</nobr></a>
                  </li>
                  </p>

			<?php if($this->logged_administrator): ?>
                  <li>
                        <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'area') ) . '">'; ?>
                        <nobr>Області</nobr></a></li>
                  <li>
                        <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'district') ) . '">'; ?>
                        <nobr>Райони</nobr></a></li>
                  <li>
                        <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl') ) . '">'; ?>
                        <nobr>Населені пункти</nobr></a></li>
                  <li>
                        <?php echo '<a href="' . RealEstateAgency_Util::url( array('page'=>'settl_part') ) . '">'; ?>
                        <nobr>Райони міста</nobr></a></li>
			<?php endif; ?>
        </ul>
		</div>		
        <?php endif; ?>

	<?php if($this->logged) { ?>
		<div class="partner_block_other">
		<div class="partner">Бесплатный хостинг <span style="color:green;">www.ho.ua</span></div>
		</div>
	<?php } else { ?>
		<div class="partner_block">
		<div class="partner">Бесплатный хостинг <a href="http://www.ho.ua">www.ho.ua</a></div>
		</div>
	<?php } ?>




<p style="float: none; height: 1.0em;margin:0px;">
&nbsp;
</p>

<!-- menu - end -->
