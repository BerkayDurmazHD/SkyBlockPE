<?php

namespace CharlesLee;

use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\{Player, Server};
use pocketmine\utils\Config;
use CharlesLee\Forms\{Form, SimpleForm, CustomForm};
use pocketmine\utils\TextFormat as C;
class FormsFunc implements Listener{
	
	public $players = [];
	
	public function __construct(Main $plugin){
		$this->p = $plugin;
		$this->f = new Events($this->p);
	}


public function mainForm(Player $player){
  
		$form = new SimpleForm(function (Player $s, int $data = null){
			$player = $s->getPlayer();
		
			switch($data){
				
				case 0:
				$this->f->createIsland($player);
				break;
				
				case 1:
				$this->f->tpIsland($player);
				break;
				
				case 2:
				$this->f->removeIsland($player);
				break;
				
				case 3:
				$this->kickPlayerForm($player);
				break;
				
				case 4:
				$this->friendForm($player);
				break;
				
				case 5:
				$this->f->setSpawnIsland($player);
				break;
			}
   });
   
   $form->setTitle("§8Island Form");
   $form->setContent("§7Pls Click To Form Button");
   
   if(!file_exists($this->p->getDataFolder()."Players/".$player->getName().".yml")){
   $form->addButton("Create Island");
   }
   
   if(file_exists($this->p->getDataFolder()."Players/".$player->getName().".yml")){
   $form->addButton("Teleport Island");
   $form->addButton("Remove Your Island");
   $form->addButton("Kıck Player in Your Island");
   $form->addButton("Friends Form");
   $form->addButton("Set Spawn Your Island");
   }
   $form->sendToPlayer($player);
	}


 
 public function kickPlayerForm($player){
 	$form = new CustomForm(function (Player $s, array $args = null){
 		$player = $s->getPlayer();
 		$result = $args[0];
 		$this->f->kickPlayer($player, $args[0]);

 			
 });
 	
  	$form->setTitle("§cKick Player");
  	$form->addInput("Player:", "ex: Neverproo");
  	$form->sendToPlayer($player);
 }
 
public function friendForm($player){
 	
   $form = new SimpleForm(function (Player $s, int $args = null){
 		$player = $s->getPlayer();
 		$result = $args[0];

 		if($args === null){
     return;
     }

 		switch($args){
 			
 			case 0:
 			$this->friendAddForm($player);
 			break;
 			
 			
 			case 1:
 			$this->removeFriendForm($player);
 			break;
 			
 			case 2:
 			$this->friendListForm($player);
 			break;
 			
 			case 3:
 			$this->firendTpForm($player);
 			break;
 			
 			case 4:
 		$this->f->inviteK($player);
 			break;
 			
 			case 5:
 			$this->f->inviteR($player);
 			break;
 			
 		}
 		});
 		
 		$form->setTitle("§8Friend Form");
 		$form->setContent("§7Pls Click Button!");
 		$form->addButton("Add Friend İn Your İsland");
 		$form->addButton("Kick Friend İn Your İsland");
 		$form->addButton("Your İsland Friend List");
   $form->addButton("Teleport your Friend İsland");
   $form->addButton("Friend İnvite Accept");
   $form->addButton("Friend İnvite Rejection");
 		$form->sendToPlayer($player);
 }
 
 
 public function friendAddForm($player){
  $form = new CustomForm(function (Player $s, array $args = null){
 		$player = $s->getPlayer();
 		$result = $args[0];

 		
 		
 		$input = $args[1];
 		
 		
 			$this->f->inviteSend($player, $oyuncu);
 			
 			
 		

 		
 		});
 		
 		$form->setTitle("Add Friend Form");
 		$form->addLabel("§7Pls !");
 		$form->addInput("§ePlayer Name:", "Exp: Neverproo");
 		$form->sendToPlayer($player);
 }
 
 
 
 public function friendTpForm($player){
 	$form = new CustomForm(function (Player $s, array $args = null){
 		$player = $s->getPlayer();
 		$result = $args[0];

 		if($args === null){
     return;
     }
 		
 		$input = $args[1];
 		
 		
 		$this->f->friendTp($player, $input);
 		
 		});
 		
 		$form->setTitle("Teleport Your Friend İsland");
 		$form->addLabel("§7Please write the name of your friends you want to go to the island of!");
 		$form->addInput("§ePlayer Name:", "exp: Neverproo");
 		$form->sendToPlayer($player);
 }
 
 
 public function removeFriendForm($player){
 		$form = new CustomForm(function (Player $s, array $args = null){
 		$player = $s->getPlayer();
 		$result = $args[0];

 		if($args === null){
     return;
     }

 		$input = $args[1];
 		
 		
 			$this->f->removeFriend($player, $oyuncu);
 			
 		
 		
 		});
 		
 		$form->setTitle("Kick Your Friend in İsland");
 		$form->addLabel("§7Please write the name of the player you want to kick out of the friendship in the space below!!");
 		$form->addInput("§ePlayer Name:", "orn: Neverproo");
 		$form->sendToPlayer($player);
 }
 
 
 public function friendListForm($player){
 		$form = new CustomForm(function (Player $s, array $args = null){
 		$player = $s->getPlayer();
 		$result = $args[0];

 			
 		
 		
 		});
 		
 		$form->setTitle("Friend List");
 		$form->addLabel("§aYour Friends\n".$this->f->friendList($player));
 		
 		$form->sendToPlayer($player);
 }
 

}

?>