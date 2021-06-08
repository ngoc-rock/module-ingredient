<?php

namespace Ngoc\Ingredient\Block\Product;

class View extends \Magento\Catalog\Block\Product\View
{
    public function getIngredientText(){
        $options = $this->getProduct()->getData('ingredient');
        $result = [];
        if(!empty($options)){
            if(is_string($options)){
                $options = explode(',', $options);
            }
            $attribute = $this->getProduct()->getResource()->getAttribute('ingredient');
            if ($attribute->usesSource()) {
                foreach($options as $option){
                    $result[] = $attribute->getSource()->getOptionText($option);
                }
            }
        }
        return $result;
    }
}
