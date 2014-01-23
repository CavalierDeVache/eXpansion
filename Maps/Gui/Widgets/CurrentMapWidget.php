<?php

namespace ManiaLivePlugins\eXpansion\Maps\Gui\Widgets;

class CurrentMapWidget extends \ManiaLive\Gui\Window {

    protected $bg;
    protected $authorTime, $logo;

    protected function onConstruct() {

        $bg = new \ManiaLib\Gui\Elements\Quad(54, 13);
        $bg->setAlign("left", "center");
        $bg->setStyle("Bgs1InRace");
        $bg->setSubStyle("NavButtonBlink");
        $bg->setPosition(-44, 3);
        $this->addComponent($bg);

        $icon = new \ManiaLib\Gui\Elements\Quad(4.5, 4.5);
        $icon->setStyle("UIConstructionSimple_Buttons");
        $icon->setSubStyle("AuthorTime");
        $icon->setAlign("right", "center2");
        $icon->setPosition(5.2, -1);
        $this->addComponent($icon);

        $this->authorTime = new \ManiaLib\Gui\Elements\Label();
        $this->authorTime->setTextColor("fff");
        $this->authorTime->setTextPrefix('$s');
        $this->authorTime->setTextSize(1.5);
        $this->authorTime->setAlign("right", "top");
        $this->addComponent($this->authorTime);
    }

    function setMap(\Maniaplanet\DedicatedServer\Structures\Map $map) {
        $this->authorTime->setText(\ManiaLive\Utilities\Time::fromTM($map->authorTime));
    }

    function destroy() {
        parent::destroy();
    }

}

?>
