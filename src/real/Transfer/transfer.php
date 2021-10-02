<?php

declare(strict_types=1);

namespace real\Transfer;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\network\mcpe\protocol\TransferPacket;
use pocketmine\player\Player;
use function array_shift;
use function count;

final class TransferCommand extends Command{

	
	public function onEnable(): void{
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

  public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool{
        
        switch($cmd->getName()){
            case "transfer":
                if($sender instanceof Player){
                    $this->run($sender); 
                    $this->setPermission("wdpe.transfer.command");
		                $this->setUsage("/transfer <server>");
                } 
            break;   
        }
        return true;    
    } 
  
  public function run(CommandSender $sender, string $commandLabel, array $args) : bool{
		if(!$this->testPermission($sender)) return false;
		if(!$sender instanceof Player) return false;
		if(count($args) < 1) throw new InvalidCommandSyntaxException();
		$server = array_shift($args);
		$sender->sendMessage("§aTransferring you to {§server}");
		$pk = new TransferPacket();
		$pk->address = $server;
		$pk->port = 1;
		$sender->getNetworkSession()->sendDataPacket($pk);
		return true;
	} 
    
}