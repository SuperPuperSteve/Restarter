<?php

namespace Restarter;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

class Restarter extends PluginBase {
	
	public function onEnable(){
		if(!is_dir($this->getDataFolder())){
			@mkdir($this->getDataFolder());
		}
		
		$this->saveDefaultConfig();
		$this->config = $this->getConfig();

		$this->getServer()->getScheduler()->scheduleRepeatingTask(new RestartTask($this), 20);
	}
	
	public function onDisable(){
		
	}
	
	public function getMessage($message, $keys = [], $values = []){
		$string = $this->config->get($message);
		return str_replace($keys, $values, $string);
	}
	
}