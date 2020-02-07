<?php

namespace mcpp\network\protocol\v110;

use mcpp\network\protocol\Info;
use mcpp\network\protocol\Info110;
use mcpp\network\protocol\PEPacket;

class PlayerHotbarPacket extends PEPacket
{
    const NETWORK_ID = Info110::PLAYER_HOTBAR_PACKET;
    const PACKET_NAME = "PLAYER_HOTBAR_PACKET";
    public $selectedSlot;
    public $slotsLink;

    public function decode($playerProtocol)
    {
    }

    public function encode($playerProtocol)
    {
        $this->reset($playerProtocol);
        $this->putVarInt($this->selectedSlot);
        $this->putByte(0); // container ID, 0 - player inventory
        if($playerProtocol < Info::PROTOCOL_200){
            $slotsNum = count($this->slotsLink);
            $this->putVarInt($slotsNum);
            for($i = 0; $i < $slotsNum; $i++){
                $this->putVarInt($this->slotsLink[$i]);
            }
        }
        $this->putByte(false); // Should select slot (don't know how it works)
    }
}
