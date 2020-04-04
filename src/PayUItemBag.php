<?php

namespace Omnipay\PayU;

use Omnipay\Common\ItemBag;
use Omnipay\Common\ItemInterface;

class PayUItemBag extends ItemBag
{
    /**
     * Add an item to the bag
     *
     * @param ItemInterface|array $item An existing item, or associative array of item parameters
     * @see Item
     *
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new PayUItem($item);
        }
    }

}