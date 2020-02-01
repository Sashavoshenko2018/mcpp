<?php

namespace mcpp\packs;

use Exception;
use mcpp\Server;

class PackManager
{
    const PACK_DIR = "resources/"; // Mods folder located in server root
    /** @var ResourcePack[] */
    private $resourcePacks = [];
    /** @var Addon[] */
    private $addons = [];
    /** @var boolean */
    private $isPacksRequired = false;

    public function __construct()
    {
        $server = Server::getInstance();
        $this->isPacksRequired = $server->getConfigBoolean("packs-required", false);
        $packConfig = $server->getConfigString("packs-enabled", "");
        if(empty($packConfig)){
            return;
        }
        $packNames = explode(";", $packConfig);
        if(!file_exists(self::PACK_DIR)){
            mkdir(self::PACK_DIR, 0755);
        }
        foreach($packNames as $packName){
            if(!is_file(self::PACK_DIR . $modName . '.zip')){
                $server->getLogger()->warning("Pack with name \"{$modName}\" doesn't exists.");
            }else{
                try{
                    $resourcePack = new ResourcePack(self::PACK_DIR . $modName . '.zip', $modName);
                    if(!isset($this->resourcePacks[$resourcePack->id])){
                        $this->resourcePacks[$resourcePack->id] = $resourcePack;
                    }else{
                        $server->getLogger()->warning("Resource pack: " . $modName . " Error: UUID duplication");
                    }
                }catch(Exception $e){
                    $server->getLogger()->warning("Resource pack: " . $modName . " Error: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * @return boolean
     */
    public function isPacksRequired()
    {
        return $this->isPacksRequired;
    }

    /**
     * @return ResourcePack[]
     */
    public function getResourcePacks()
    {
        return $this->resourcePacks;
    }

    /**
     * @return Addon[]
     */
    public function getAddons()
    {
        return $this->addons;
    }

    /**
     * @return ResourcePack
     */
    public function getResourcePackById($id)
    {
        return isset($this->resourcePacks[$id]) ? $this->resourcePacks[$id] : null;
    }
}
