<?php

namespace App\Components;



class Recusive
{
    private $data;
    private $htmlSelect = '';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function categoryRecursive($parentId, $id = '', $text = '')
    {
        foreach ($this->data as $value) {
            
            if ($value['parent_category_id'] == $id && $value['fixed'] == 1) {
                if ( !empty($parentId) && $parentId == $value['id']){
                    $this->htmlSelect .= "<option selected value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
                 }else {
                    $this->htmlSelect .= "<option value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";

                 }
               
                $this->categoryRecursive($parentId, $value['id'], $text . '--');
            }
        }
        return $this->htmlSelect;
    }
}
