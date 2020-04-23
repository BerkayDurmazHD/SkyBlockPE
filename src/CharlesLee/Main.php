<?php

namespace CharlesLee;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\Config;
use pocketmine\{Player, Server};
use pocketmine\event\Listener;
class Main extends PluginBase implements Listener{
	
	
	public function onEnable(){
		$this->getLogger()->info("Plugin Enable");
		
		$this->getServer()->getPluginManager(new Events($this), $this);
		$this->getServer()->getPluginManager(new FormsFunc($this), $this);
   $this->getServer()->getPluginManager(new Parentf($this), $this);
		@mkdir($this->getDataFolder()."Players/");
 $this->f = new FormsFunc($this);
	}
	
	
	public function onCommand(CommandSender $g, Command $kmt, string $label, array $args): bool{
		if($kmt == "skyblock"){
			$this->f->mainForm($g);
		}
		return true;
		}
		
}

?>
