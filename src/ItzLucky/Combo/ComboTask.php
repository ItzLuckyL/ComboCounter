<?php

namespace ItzLucky\Combo;

use pocketmine\Server;
use pocketmine\scheduler\Task;
use ItzLucky\Combo\Main;

class ComboCounterTask extends Task {
  
  public function onRun(int $tick){
  
    foreach(Server::getInstance()->getOnlinePlayers() as $players){
        $players->sendTip("Combo: " . ComboCounter::getInstance()->combo[$players->getName()]);
      }
    }
  }
}
