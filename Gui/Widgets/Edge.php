<?php

namespace ManiaLivePlugins\eXpansion\Gui\Widgets;

use ManiaLib\Gui\Elements\Quad;
use ManiaLive\Gui\Container;
use ManiaLive\Gui\Controls\Frame;
use ManiaLivePlugins\eXpansion\Gui\Config;
use ManiaLivePlugins\eXpansion\Gui\Elements\DicoLabel;
use ManiaLivePlugins\eXpansion\Gui\Elements\WidgetBackGround;
use ManiaLivePlugins\eXpansion\Gui\Structures\Script;

/**
 *
 * @author reaby
 */
class Edge extends Widget {

    protected $quad;
    protected $label;
    protected $orientation;
    protected $background;
    protected $_mainWindow, $_windowFrame, $bg;
    protected $sscript;
    protected $widgetSize;

    public function onConstruct() {
        parent::onConstruct();

        $sizeX = 40;
        $sizeY = 6;
        $config = Config::getInstance();

        $this->setName("Autohide Switcher");
        $this->setDisableAxis("x");

        $this->_windowFrame = new Frame();
        $this->_windowFrame->setId("Frame");
        $this->_windowFrame->setScriptEvents(true);
        $this->addComponent($this->_windowFrame);

        $this->bg = new WidgetBackGround(30, 6);
        $this->_windowFrame->addComponent($this->bg);

        $this->label = new DicoLabel(20, 6);
        $this->label->setTextColor("fff");
        $this->label->setPosition(5, -3);
        $this->label->setAlign("left", "center");
        $msg = exp_getMessage("Auto hide");
        $this->label->setText($msg);
        $this->_windowFrame->addComponent($this->label);

        $this->quad = new Quad(6, 6);
        $this->quad->setPosY(-0.5);
        $this->quad->setPosX(21);
        $this->quad->setStyle('Icons64x64_1');
        $this->quad->setSubStyle('GenericButton');
        $this->quad->setColorize("f00");
        $this->quad->setId("Edge");
        $this->quad->setAlign("left", "top");
        $this->quad->setScriptEvents();
        $this->_windowFrame->addComponent($this->quad);

        $this->_minButton = new Quad(5.5, 5.5);
        $this->_minButton->setAlign("left", "top");
        $this->_minButton->setId("minimizeButton");
        $this->_minButton->setStyle("Icons128x32_1");
        $this->_minButton->setSubStyle("Settings");
        $this->_minButton->setScriptEvents(true);
        $this->_minButton->setPosition(40 - 6, -0.5);
        $this->_windowFrame->addComponent($this->_minButton);

        $script = new Script("Gui\Scripts\TrayWidget");
        $script->setParam('isMinimized', 'True');
        $script->setParam('autoCloseTimeout', 30000);
        $script->setParam('posXMin', -30);
        $script->setParam('posX', -30);
        $script->setParam('posXMax', -4);
        $this->registerScript($script);

        $this->sscript = new Script("Gui\Scripts\EdgeScript");
        $this->sscript->setParam("imageOff", "<1.,0.,0.>");
        $this->sscript->setParam("imageOn", "<0.,1.,0.>");
        $this->registerScript($this->sscript);

        $this->setSize($sizeX, $sizeY);
    }

    public function onResize($oldX, $oldY) {
        parent::onResize($oldX, $oldY);
        $this->bg->setSize($this->sizeX, $this->sizeY);
    }

    function onIsRemoved(Container $target) {
        parent::onIsRemoved($target);
        $this->destroy();
    }

}

?>
