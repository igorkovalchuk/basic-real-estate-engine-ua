<?php

require_once 'RealEstateAgency/Object/Base.php';

class RealEstateAgency_Object_List extends RealEstateAgency_Object_Base
{

    public function toString() {
        $list = $this->getList();
        $str = '<hr />' . get_class($this).':<br />';
        foreach ($list as $index => $object) {
            $str .= '<hr />' . $object->toString() . '<hr />' . "\n";
        }
        $str .= '<hr />';
        return $str;
    }
    
    
    
    
}