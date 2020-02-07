<?php

namespace mcpp\network\protocol\v110;

use mcpp\network\protocol\Info110;
use mcpp\network\protocol\PEPacket;

class ShowModalFormPacket extends PEPacket
{
    const NETWORK_ID = Info110::MODAL_FORM_REQUEST_PACKET;
    const PACKET_NAME = "MODAL_FORM_REQUEST_PACKET";
    public $formId;
    public $data;

    public function encode($playerProtocol)
    {
        $this->reset($playerProtocol);
        $this->putVarInt($this->formId);
        $this->putString($this->data);
    }

    public function decode($playerProtocol)
    {
    }
}
