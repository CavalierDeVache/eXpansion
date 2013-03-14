<?php

namespace ManiaLivePlugins\eXpansion\Widgets_Record;

use \ManiaLive\Event\Dispatcher;
use ManiaLivePlugins\eXpansion\Dedimania\Events\Event as DediEvent;
use ManiaLivePlugins\eXpansion\LocalRecords\Events\Event as LocalEvent;

class Widgets_Record extends \ManiaLivePlugins\eXpansion\Core\types\ExpPlugin implements \ManiaLivePlugins\eXpansion\LocalRecords\Events\Listener, \ManiaLivePlugins\eXpansion\Dedimania\Events\Listener {

    public function exp_onInit() {
        $this->setVersion(0.1);
    }

    public function exp_onLoad() {
        Dispatcher::register(DediEvent::getClass(), $this);
        Dispatcher::register(LocalEvent::getClass(), $this, LocalEvent::ON_UPDATE_RECORDS);
    }

    public function exp_onReady() {
        $this->enableDedicatedEvents();
        foreach ($this->storage->players as $player)
            $this->onPlayerConnect($player->login, false); // create panel for everybody
        foreach ($this->storage->spectators as $player)
            $this->onPlayerConnect($player->login, true); // create panel for everybody
    }

    public function onUpdateRecords($data) {
        Gui\Widgets\RecordsPanel::$localrecords = $data;
        Gui\Widgets\RecordsPanel::RedrawAll();
    }

    public function onDedimaniaUpdateRecords($data) {
        Gui\Widgets\RecordsPanel::$dedirecords = $data['Records'];        
        Gui\Widgets\RecordsPanel::RedrawAll();
    }

    public function onDedimaniaGetRecords($data) {
        Gui\Widgets\RecordsPanel::$dedirecords = $data['Records'];
        Gui\Widgets\RecordsPanel::RedrawAll();
        $this->exp_chatSendServerMessage("Dedimania found %s records for current map.", null, array(sizeof($data['Records'])));
        echo "Dedimania: Found " . sizeof($data['Records']) . " records for current map!";
    }

    public function onPlayerConnect($login, $isSpectator) {
        $panel = Gui\Widgets\RecordsPanel::Create($login);
        $panel->setSize(50, 60);
        $panel->setPosition(-160, 60);
        $panel->show();
    }

    public function onPlayerDisconnect($login) {
        Gui\Widgets\RecordsPanel::Erase($login);
    }

    public function onDedimaniaOpenSession() {
        
    }

    public function onNewRecord($data) {
        
    }

    public function onDedimaniaNewRecord($data) {
        
    }

    public function onDedimaniaPlayerConnect($data) {
        
    }

    public function onDedimaniaPlayerDisconnect() {
        
    }

}

?>