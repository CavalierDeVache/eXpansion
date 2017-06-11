<?php

namespace ManiaLivePlugins\eXpansion\Widgets_Speedometer;

/**
 * Description of MetaData
 *
 * @author Petri
 */
class MetaData extends \ManiaLivePlugins\eXpansion\Core\types\config\MetaData
{

    public function onBeginLoad()
    {
        parent::onBeginLoad();
        $this->setName(" Speedometer");
        $this->setDescription("Provides speedometer");
        $this->setGroups(array('Widgets'));
    }
}
