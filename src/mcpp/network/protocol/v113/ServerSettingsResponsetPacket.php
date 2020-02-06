<?php

namespace mcpp\network\protocol\v113;

use mcpp\network\protocol\Info113;
use mcpp\network\protocol\PEPacket;

class ServerSettingsResponsetPacket extends PEPacket
{
    const NETWORK_ID = Info113::SERVER_SETTINGS_RESPONSE_PACKET;
    const PACKET_NAME = "SERVER_SETTINGS_RESPONSE_PACKET";
    public $formId;
    public $data;

    public function decode($playerProtocol)
    {
    }

    public function encode($playerProtocol)
    {
        $this->reset($playerProtocol);
        $this->putVarInt($this->formId);
        $this->putString($this->data);
    }
}
