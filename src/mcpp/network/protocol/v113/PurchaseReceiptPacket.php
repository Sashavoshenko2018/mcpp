<?php

namespace mcpp\network\protocol\v113;

use mcpp\network\protocol\Info113;
use mcpp\network\protocol\PEPacket;

class PurchaseReceiptPacket extends PEPacket
{
    const NETWORK_ID = Info113::PURCHASE_RECEIPT_PACKET;
    const PACKET_NAME = "PURCHASE_RECEIPT_PACKET";
    /** @var string[] */
    public $receipts = [];

    public function decode($playerProtocol)
    {
        $this->getHeader($playerProtocol);
        $receiptsCount = $this->getVarInt();
        for($i = 0; $i < $receiptsCount; $i++){
            $this->receipts[] = $this->getString();
        }
    }

    public function encode($playerProtocol)
    {
        // only client send this packet, not we
    }
}
