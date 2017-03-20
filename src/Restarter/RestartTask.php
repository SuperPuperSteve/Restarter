<?php

namespace Restarter;

use pocketmine\scheduler\PluginTask;

use Restarter\Restarter;

class RestartTask extends PluginTask {
	
	private $seconds;
	private $restartSeconds;
	
	public function __construct(Restarter $plugin){
		parent::__construct($plugin);
		(int) $this->restartSeconds = $this->getOwner()->config->get('restart');
	}
	
	public function onRun($currentTick){
		$this->getLogger()->info("секунд: ".++$this->seconds);
		$secondsLeft = ($this->restartSeconds - $this->seconds);
		
		//целая минута
		if($secondsLeft % 60 == 0 and $secondsLeft != 60){
			if($this->seconds == $this->restartSeconds){
				$this->shutdownServer();
				return;
			} else {
				$minutes = $secondsLeft / 60;
				$message = $this->getMessage('restart_inMinutes', '{minutes}', $minutes);
				$this->getOwner()->getServer()->broadcastMessage($message);
				return;
			}
		} else {
			//не целая минута
			if($secondsLeft > 60){
				return;
			}
			
			if($secondsLeft == 60){
				$message = $this->getMessage('restart_60');
				$this->getOwner()->getServer()->broadcastMessage($message);
				return;
			}
			
			if($secondsLeft == 30){
				$message = $this->getMessage('restart_30');
				$this->getOwner()->getServer()->broadcastMessage($message);
				return;
			}
			
			if($secondsLeft == 15){
				$message = $this->getMessage('restart_15');
				$this->getOwner()->getServer()->broadcastMessage($message);
				return;
			}
			
			if($secondsLeft == 5){
				$message = $this->getMessage('restart_5');
				$this->getOwner()->getServer()->broadcastMessage($message);
				return;
			}
		}
		
	}
	
	private function shutdownServer(){
		$message = $this->getMessage('restart_message');
		$this->getOwner()->getServer()->broadcastMessage($message);
		
		$this->getOwner()->getServer()->shutdown();
	}
	
	private function getLogger(){
		return $this->getOwner()->getServer()->getLogger();
	}

	private function getMessage($message, $keys = [], $values = []){
		return $this->getOwner()->getMessage($message, $keys, $values);
	}
	
}