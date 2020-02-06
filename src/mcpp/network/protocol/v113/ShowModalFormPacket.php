<?php

namespace mcpp\network\protocol\v113;

use mcpp\network\protocol\Info113;
use mcpp\network\protocol\PEPacket;

class ShowModalFormPacket extends PEPacket
{
    const NETWORK_ID = Info113::MODAL_FORM_REQUEST_PACKET;
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
