<?php
/**
 * @author       Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */

namespace ManiaLivePlugins\eXpansion\Helpers;


use ManiaLive\Utilities\Console;
use ManiaLive\Utilities\Logger;

class Helper
{

    private static $singletons;
    private static $paths;

    /**
     * Returns helper that allows to get paths
     *
     * @return Paths
     */
    public static function getPaths()
    {
        if (self::$paths == null)
            self::$paths = new Paths();
        return self::$paths;
    }

    /**
     * Returns instance of singleton instance.
     *
     * @return Singletons
     */
    public static function getSingletons()
    {
        if (self::$singletons == null)
            self::$singletons = Singletons::getInstance();
        return self::$singletons;
    }

    public static function log($message){
        Logger::info('[Adm/AdminPanel]'. $message);
        Console::println('[Adm/AdminPanel]'. $message);
    }

} 