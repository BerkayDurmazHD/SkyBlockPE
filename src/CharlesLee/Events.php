<?php

namespace CharlesLee;

use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

class Events implements Listener{
	
	public $players = [];
	
	public function __construct(Main $plugin){
		$this->p = $plugin;
		$this->s = new Config($this->p->getDataFolder()."Settings.yml", Config::YAML);
	}
	
	
	public function copyIsland(Player $player, $sekil){
        $sd = $this->p->getServer()->getDataPath();
        $ssd = $this->p->getDataFolder(); @mkdir($sd."worlds/".$player->getName()."/");
        @mkdir($sd."worlds/".$player->getName()."/region/");
        $dunya = opendir($this->p->getDataFolder()."AdaKopyalari/".$sekil."/region/");
        while($dosya = readdir($dunya)){
        	
            if($dosya != "." and $dosya != ".."){
                copy($ssd."AdaKopyalari/".$sekil."/region/".$dosya, $sd."worlds/".$player->getName()."/region/".$dosya);

  copy($ssd."AdaKopyalari/".$sekil."/level.dat", $sd."worlds/".$player->getName()."/level.dat");
            }
        }
        
        $this->renameLevel($player->getName(), $player->getName());
       }
        
	
	public function createIsland($player){
		$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
	$x =	 $this->s->get("X");
	$y = $this->s->get("Y");
	$z = $this->s->get("Z");
	$deflevel = $this->s->get("Default-Island-LevelName");
	$this->copyIsland($player, $deflevel);
	$player->sendMessage("§aIsland Create...");
	$cfg->set("X", $x);
	$cfg->set("Y", $y);
	$cfg->set("Z", $z);
	$cfg->set("level", $player->getName());
	$cfg->set("name", $player->getName());
	$cfg->save();
	$this->tpIsland($player);
}


 public function tpIsland($player){
 	$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
 	
 	$x = $cfg->get("X");
 	$y = $cfg->get("Y");
 	$z = $cfg->get("Z");
 	$lev = $cfg->get("level");
 $level =	$this->p->getServer()->getLevelByName($player->getName());
 $this->p->getServer()->loadLevel($player->getName());
 $player->teleport(new Position($x, $y, $z, $level));
 
 $player->sendMessage("Teleported...");
 }
 
 public function setSpawnIsland($player){
 	$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
 	
 	if($player->getLevel()->getFolderName() == $player->getName()){
 	$cfg->set("X", $player->getX());
 	$cfg->set("Y", $player->getY());
 	$cfg->set("Z", $player->getZ());
 	$cfg->save();
 	$player->sendMessage("§fSpawn changed");
 	// dil sistemi kodlicagim icin salliyorum 
 	}else{
 		$player->sendMessage("§fPls go your island");
 	}
 
 }
 
 
 public function removeIsland($player){
 	$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
 	
 	unlik($cfg);
 	
 	$worlds = $this->p->getDataPath()."".$player->getName();
 	 system("rm -rf ".escapeshellarg($worlds));
 	 
 	 $player->sendMessage("§fRemove Your Island");
 }
 
 
 public function kickPlayer($player, $pp){
 	$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
 	
 	if($pl = $this->p->getServer()->getPlayer($pp)){
 	
 	 if($pl->getLevel()->getFolderName() == $player->getName()){
 	 	
 	 	
 	 	$pl->teleport($this->p->getServer()->getDefaultLevel()->getDefaultSpawn(),0,0);
 	 	$pl->sendMessage("§cYour Kicked from Island");
 	 	$player->sendMessage("§c Your Kick ".$pl->getName());
 	 	
 	 }else{
 	 	$player->sendMessage("".$pl->getName()." Dony Have Your İsland"); //kesin yanlis yazmisimdir A2 Seviye ing boyle oluyor
 	 }
 	 
 	}else{
 		$player->sendMessage("".$pp." Dont Online ");
 	}
}

 public function friendList(Player $player){
 	$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
 	
 	$ort = $cfg->get("Friends");
 	
 	if($ort !== null){
 		
 		$ortt .= "\n§e» §7".$ort;
 		return $ortt;
 	}else{
 		$player->sendMessage("§cYou Dont Have Friends"); // SAD! aga b
 	}
 	
 	
 }


 public function addFriend($player, $ort){
 	$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
 	
 	$fr = $cfg->get("Friends");
 	
 	if(in_array($fr, $ort)){
 	if(empty($fr)){
 		
 		$cfg->set("Friends", array($ort));
 		$cfg->save();
 		
 		$player->sendMessage("§cYour Add Friend To".$ort);
 		$player->sendMessage("§c".$player->getName()." Add To Friend");
 		
 	}else{
 		$ortf = $cfg->get("Friends", []);
 		$ortf[] = $ort;
 		
 		$cfg->set("Friends", $ortf);
 		
 		$cfg->save();
 	 }
 }else{
 	$player->sendMessage("§c".$ort." Your Friends!");
 }
}
 
 public function removeFriend($player, $ort){
 	$cfg = new Config($this->p->getDataFolder()."Players/".$player->getName().".yml", Config::YAML);
 	$fr = $cfg->get("Friends");
 	if(in_array($fr, $ort)){
 		
 		$s = array_search($fr, $ort);
 		unset($s);
 		$cfg->save();
 		
 		$player->sendMessage("§cYour Remove Friend To ".$ort);
 	}else{
 		$player->sendMessage("§c".$ortt." Dont Your Friend");
 	}
 }
 
 public function tpFriend($player, $s){
 	if(file_exists($this->p->getDataFolder()."Players/".$s.".yml")){
 		$cfg = new Config($this->p->getDataFolder()."Players/".$s.".yml", Config::YAML);
 		$fr = $cfg->get("Friends");
 		
 		if(in_array($fr, $player)){
 			$this->p->getServer()->loadLevel($s);
 			$lev = $this->p->getServer()->getLevelByName($s);
 			$player->teleport(new Position($cfg->get("X"), $cfg->get("Y"), $cfg->set("Z"), $lev));
 			$player->sendMessage("§cYour Teleported");
 			
 		}else{
 			$player->sendMessage("§c".$s." Dont Your Friend"); // SAD!
 			
 		}
 		
 		
  	}else{
  		$player->sendMessage("§c".$s." Dont Have İsland");
  	}
 }
 
 public function renameLevel($oldName, $newName){
	$from = Server::getInstance()->getDataPath() . "/worlds/" . $oldName;
        $to = Server::getInstance()->getDataPath() . "/worlds/" . $newName;

        rename($from, $to);

        Server::getInstance()->loadLevel($newName);
        $provider = Server::getInstance()->getLevelByName($newName)->getProvider();

        if(!$provider instanceof BaseLevelProvider) return;
        $provider->getLevelData()->setString("LevelName", $newName);
        $provider->saveLevelData();

     $laname = Server::getInstance()->getLevelByName($newName); Server::getInstance()->unloadLevel($laname);
        Server::getInstance()->loadLevel($newName); 
    }
    
    
    public function inviteSend($g, $oyuncu){
	if($o = $this->p->getServer()->getPlayer($oyuncu)){
			$name = $g->getName();
			$oname = $o->getName();
			
			$cfg = new Config($this->p->getDataFolder()."Players/$name.yml", Config::YAML);
			$ocfg = new Config($this->p->getDataFolder()."Players/$oname.yml", Config::YAML);
			
				
			$this->players[$oisim] = $isim;
			
			$o->sendMessage("ss");
			$g->sendMessage("§aFriends invite Send");
			
		}else{
 $g->sendMessage("§cPlayer Dont Active");
	}
}
    
 public function inviteControl(string $name): bool{
		return isset($this->players[$name]);
	}
	
	public function inviteC(string $name): string{
		return $this->players[$name];
	}
	
	public function inviteR($g){
		$name = $g->getName();
		if($this->inviteCotrol($name)){
			$o = $this->p->getServer()->getPlayer($this->inviteC($name));
			unset($this->players[$name]);
			$oyuncu->sendMessage(" §e".$name." §7İnvite R");
			
		}else{
			$g->sendMessage(" §cDont Have İnvite");
		}
		
	}
	
	public function inviteK(Player $g){
		$name = $g->getName();
		if($this->inviteControl($name)){
			$o = $this->p->getServer()->getPlayer($this->inviteC($name));
			unset($this->players[$isim]);
			$this->addFriend($g, $o);
			
		}else{
			$g->sendMessage(" §cDont Have İnvite");
		}
	}
    
}
?>