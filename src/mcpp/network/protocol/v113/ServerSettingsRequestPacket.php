<?php

namespace mcpp\network\protocol\v113;

use mcpp\network\protocol\Info113;
use mcpp\network\protocol\PEPacket;

class ServerSettingsRequestPacket extends PEPacket
{
    const NETWORK_ID = Info113::SERVER_SETTINGS_REQUEST_PACKET;
    const PACKET_NAME = "SERVER_SETTINGS_REQUEST_PACKET";

    public function decode($playerProtocol)
    {
    }

    public function encode($playerProtocol)
    {
    }
}
