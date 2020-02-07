<?php

namespace mcpp\network\protocol\v110;

use mcpp\network\protocol\Info110;
use mcpp\network\protocol\PEPacket;

class ShowStoreOfferPacket extends PEPacket
{
    const NETWORK_ID = Info110::SHOW_STORE_OFFER_PACKET;
    const PACKET_NAME = "SHOW_STORE_OFFER_PACKET";
    /** @var string */
    public $productId = '';
    /** @var boolean */
    public $isShowToAll = false;

    public function decode($playerProtocol)
    {
        // only we send this packet, not client
    }

    public function encode($playerProtocol)
    {
        $this->reset($playerProtocol);
        $this->putString($this->productId);
        $this->putByte($this->isShowToAll);
    }
}
