<?php

namespace CharlesLee;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\{Player, Server};

class Parentf implements Listener{

    public function __construct(Main $plugin){
        $this->p = $plugin;
		
    }
    
	
    public function break(BlockBreakEvent $e){
        $o = $e->getPlayer();
        $isname = $o->getLevel()->getFolderName();
        $b = $e->getBlock();
        if(file_exists($this->p->getDataFolder() . "Players/".$isname.".yml")){
            if($isname == $o->getName()){
                $e->setCancelled(false);
            }else{
                $cfg = new Config($this->p->getDataFolder()."Players/".$isname.".yml", Config::YAML);
                
                $friends = $cfg->get("Friends");
                if(@in_array($o->getName(), $friends)){
                    $e->setCancelled(false);
                }elseif(!$o->isOp()){
                    $e->setCancelled(true);
                   
                }
            }
        }else{
            
        }
    }

    public function blockplace(BlockPlaceEvent $e){
        $o = $e->getPlayer();
        $isname = $o->getLevel()->getFolderName();
        $b = $e->getBlock();
        if(file_exists($this->p->getDataFolder() . "Players/".$isname.".yml")){
            if($isname == $o->getName()){
                $e->setCancelled(false);
            }else{
                $cfg = new Config($this->p->getDataFolder()."Players/".$isname.".yml", Config::YAML);
                
                $friends = $cfg->get("Friends");
                if(@in_array($o->getName(), $friends)){
                    $e->setCancelled(false);
                }elseif(!$o->isOp()){
                    $e->setCancelled(true);
                   
                }
            }
        }else{
            
        }
    }
	
	
    public function ortakTikla(PlayerInteractEvent $e){
        $o = $e->getPlayer();
        $isname = $o->getLevel()->getFolderName();
        $b = $e->getBlock();
        if(file_exists($this->p->getDataFolder() . "Players/".$isname.".yml")){
            if($isname == $o->getName()){
                $e->setCancelled(false);
            }else{
                $cfg = new Config($this->p->getDataFolder()."Players/".$isname.".yml", Config::YAML);
                
                $friends = $cfg->get("Friends");
                if(@in_array($o->getName(), $friends)){
                    $e->setCancelled(false);
                }elseif(!$o->isOp()){
                    $e->setCancelled(true);
                   
                }
            }
        }else{
            
        }
    }
	
	
   
    
	public function Pvp(EntityDamageEvent $e){
        if($e instanceof EntityDamageByEntityEvent){
            if($e->getEntity() instanceof Player && $e->getDamager() instanceof Player){
                $g = $e->getEntity();
                $isname = $g->getLevel()->getName();
                if(file_exists($this->p->getDataFolder()."Friends/".$isname.".yml")){
                    $e->setCancelled(true);
                }else{}
            }
        }
    }
	

}