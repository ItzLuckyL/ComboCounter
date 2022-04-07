<?php

namespace ItzLucky\Combo;

use pocketmine\player\Player;

use pocketmine\event\Listener;

use pocketmine\plugin\PluginBase;

use pocketmine\event\entity\{
    EntityDamageByEntityEvent,
    EntityDamageEvent
};

use pocketmine\event\player\{
    PlayerJoinEvent,
    PlayerQuitEvent
};

use pocketmine\command\{
    CommandSender,
    Command
};

class Main extends PluginBase implements Listener {
 
  public $combo = [];
  private static $instance;
  
  public function onEnable(){
    self::$instance = $this;
    $this->getServer()->getPluginManager()->registerEvents($this, $this); 
    $this->getScheduler()->scheduleRepeatingTask(new ComboCounterTask, 1);
  }
  
  public function onDamage(EntityDamageEvent $ev){
    $player = $ev->getEntity();
    $cause = $player->getLastDamageCause();
    
    if($cause instanceof EntityDamageByEntityEvent){
      $damager = $cause->getDamager();
      if($damager instanceof Player and $player instanceof Player){
         if(isset($this->combo[$damager->getName()])){
           $this->combo[$damager->getName()]++;
         }
         if(isset($this->combo[$player->getName()])){
           $this->combo[$player->getName()] = 0; 
         }
      }
    }
  }
                               
  public function onJoin(PlayerJoinEvent $ev){
      $player = $ev->getPlayer();
      $this->combo[$player->getName()] = 0;
    }
                               
  public function onQuit(PlayerQuitEvent $ev){
    $player = $ev->getPlayer();
    if(isset($this->combo[$player->getName()])){
      unset($this->combo[$player->getName()]); 
    }
  }
   
  public static function getInstance(): ComboCounter {
   return self::$instance;
  }
}
