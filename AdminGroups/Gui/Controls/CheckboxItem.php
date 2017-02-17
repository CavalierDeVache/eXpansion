<?php

namespace ManiaLivePlugins\eXpansion\AdminGroups\Gui\Controls;

use ManiaLive\Gui\Controls\Frame;
use ManiaLivePlugins\eXpansion\Gui\Control;
use ManiaLivePlugins\eXpansion\Gui\Elements\Checkbox;
use ManiaLivePlugins\eXpansion\Gui\Elements\ListBackGround;

/**
 * Description of CheckboxItem
 *
 * @author Reaby
 */
class CheckboxItem extends Control
{

    protected $frame;

    public function __construct($counter, Checkbox $permission, CheckBox $inheritance = null)
    {
        $this->frame = new Frame();
        $this->frame->setSize(68, 4);
        $this->frame->addComponent(new ListBackGround($counter, 68, 4));
        $this->frame->addComponent($permission);
        if ($inheritance != null) {
            $this->frame->addComponent($inheritance);
            $inheritance->setPosX(54);
        }
        $this->addComponent($this->frame);
        $this->setSize(68, 4);
    }

    public function destroy()
    {

    }

    public function erase()
    {
        $this->frame->destroy();
        parent::destroy();
    }
}
