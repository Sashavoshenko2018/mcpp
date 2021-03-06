<?php

namespace mcpp\network\protocol\v113;

abstract class Protocol113
{
    const CONTAINER_ID_NONE = -1;
    const CONTAINER_ID_INVENTORY = 0;
    const CONTAINER_ID_FIRST = 1;
    const CONTAINER_ID_LAST = 100;
    const CONTAINER_ID_OFFHAND = 119;
    const CONTAINER_ID_ARMOR = 120;
    const CONTAINER_ID_CREATIVE = 121;
    const CONTAINER_ID_SELECTION_SLOTS = 122;
    const CONTAINER_ID_FIXEDINVENTORY = 123;
    const CONTAINER_ID_CURSOR_SELECTED = 124;
}
