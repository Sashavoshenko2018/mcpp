<?php

namespace mcpp\network\protocol\v120;

use mcpp\network\protocol\Info120;
use mcpp\network\protocol\PEPacket;

class ServerSettingsRequestPacket extends PEPacket
{
    const NETWORK_ID = Info120::SERVER_SETTINGS_REQUEST_PACKET;
    const PACKET_NAME = "SERVER_SETTINGS_REQUEST_PACKET";

    public function decode($playerProtocol)
    {
    }

    public function encode($playerProtocol)
    {
    }
}
