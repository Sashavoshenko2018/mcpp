<?php

namespace mcpp\command\defaults;

use mcpp\command\CommandSender;
use mcpp\network\protocol\Info;
use mcpp\Server;

class MakeServerCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"Generates Mcpp phar",
			"/makeserver"
		);
		$this->setPermission("mcpp.command.makeserver");
	}

	public function execute(CommandSender $sender, $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		$server = $sender->getServer();
		$pharPath = Server::getInstance()->getPluginPath() . DIRECTORY_SEPARATOR . "Mcpp" . DIRECTORY_SEPARATOR . $server->getName() . "_" . $server->getMcppVersion() . ".phar";
		if(file_exists($pharPath)){
			$sender->sendMessage("Phar file already exists, overwriting...");
			@unlink($pharPath);
		}
		
		$phar = new \Phar($pharPath);
		$phar->setMetadata([
			"name" => $server->getName(),
			"version" => $server->getMcppVersion(),
			"api" => $server->getApiVersion(),
			"minecraft" => $server->getVersion(),
			"protocol" => Info::CURRENT_PROTOCOL,
			"creationDate" => time()
		]);
		
		$phar->setStub('<?php define("mcpp\\\\PATH", "phar://". __FILE__ ."/"); require_once("phar://". __FILE__ ."/src/mcpp/Main.php");  __HALT_COMPILER();');
		$phar->setSignatureAlgorithm(\Phar::SHA1);
		$phar->startBuffering();

		$filePath = substr(\mcpp\PATH, 0, 7) === "phar://" ? \mcpp\PATH : realpath(\mcpp\PATH) . "/";
		$filePath = rtrim(str_replace("\\", "/", $filePath), "/") . "/";
		foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($filePath . "src")) as $file){
			$path = ltrim(str_replace(["\\", $filePath], ["/", ""], $file), "/");
			if($path{0} === "." or strpos($path, "/.") !== false or substr($path, 0, 4) !== "src/"){
				continue;
			}
			
			$phar->addFile($file, $path);
		}
		
		foreach($phar as $file => $finfo){
			if($finfo->getSize() > (1024 * 512)){
				$finfo->compress(\Phar::GZ);
			}
		}
		
		if(!isset($args[0]) or (isset($args[0]) and $args[0] != "nogz")){
			$phar->compressFiles(\Phar::GZ);
		}
		
		$phar->stopBuffering();

		$sender->sendMessage($server->getName() . " " . $server->getMcppVersion() . " Phar file has been created on " . $pharPath);

		return true;
	}
}
