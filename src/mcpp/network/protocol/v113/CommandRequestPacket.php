<?php

namespace mcpp\network\protocol\v113;

use mcpp\network\protocol\Info113;
use mcpp\network\protocol\PEPacket;

class CommandRequestPacket extends PEPacket
{
    const NETWORK_ID = Info113::COMMAND_REQUEST_PACKET;
    const PACKET_NAME = "COMMAND_REQUEST_PACKET";
    /** @var string */
    public $command = '';

    public function decode($playerProtocol)
    {
        $this->getHeader($playerProtocol);
        $this->command = $this->getString();
    }

    public function encode($playerProtocol)
    {
    }
}
