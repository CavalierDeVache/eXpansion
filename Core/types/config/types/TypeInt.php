<?php
namespace ManiaLivePlugins\eXpansion\Core\types\config\types;

use ManiaLivePlugins\eXpansion\Core\types\config\Variable;

/**
 * Description of Int
 *
 * @author De Cramer Oliver
 */
class TypeInt extends Variable
{

    public function setValue($value)
    {
        if ($this->basicValueCheck($value)) {
            return $this->setRawValue((int)$value);
        }
        return false;
    }

    public function basicValueCheck($value)
    {
        return parent::basicValueCheck($value) && is_numeric($value);
    }

    public function getPreviewValues()
    {
        return $this->getRawValue();
    }

    public function castValue($value)
    {
        return (int)$value;
    }
}
