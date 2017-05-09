<?php
namespace ManiaLivePlugins\eXpansion\AutoUpdate;

use ManiaLivePlugins\eXpansion\AdminGroups\AdminGroups;
use ManiaLivePlugins\eXpansion\AdminGroups\Permission;
use ManiaLivePlugins\eXpansion\AutoUpdate\Gui\Windows\UpdateProgress;
use ManiaLivePlugins\eXpansion\Core\ParalelExecution;
use ManiaLivePlugins\eXpansion\Core\types\ExpPlugin;
use ManiaLivePlugins\eXpansion\Gui\Gui;

/**
 * Auto update will check for updates and will update eXpansion if asked
 *
 * @author Petri & oliverde8
 */
class AutoUpdate extends ExpPlugin
{

    /**
     * Configuration of eXpansion
     *
     * @var Config
     */
    private $config;

    /**
     * Currently on going git updates or checks
     *
     * @var boolean
     */
    private $onGoing = false;

    /**
     * The login of the player that started the currently running steps
     *
     * @var String
     */
    private $currentLogin;

    public function eXpOnLoad()
    {

    }

    public function eXpOnReady()
    {
        $adm = AdminGroups::getInstance();

        $adm->addAdminCommand("update", $this, "autoUpdate", "server_update");
        $adm->addAdminCommand("check", $this, "checkUpdate", "server_update");

        $this->config = Config::getInstance();
        $this->enableDedicatedEvents();
    }

    /**
     * Get composer command to use.
     *
     * @return string
     */
    public function getComposerName()
    {
        if(file_exists('composer.phar')) {
            return PHP_BINARY . " composer.phar";
        } else {
            // Hope composer is installed.
            return "composer";
        }
    }

    /**
     * Will check if updates are necessary.
     */
    public function checkUpdate()
    {
        $AdminGroups = AdminGroups::getInstance();

        //If on going updates cancel !!
        if ($this->onGoing) {
            $msg = "#admin_error#An update or check for update is already under way!";
            $AdminGroups->announceToPermission(Permission::SERVER_UPDATE, $msg);

            return;
        }

        $this->onGoing = true;

        $composer = $this->getComposerName();
        if ($this->config->useGit) {
            $cmds = array("$composer update --prefer-source --no-interaction --dry-run");
        } else {
            $cmds = array("$composer update --prefer-dist --no-interaction --dry-run");
        }

        $AdminGroups->announceToPermission(
            Permission::SERVER_UPDATE,
            '#admin_action#[#variable#AutoUpdate#admin_action#] Checking updates for #variable#eXpansion & Components'
        );

        $exec = new ParalelExecution($cmds, array($this, 'checkExecuted'), 'eXpansion_update_check');
        $exec->setValue('login', $this->currentLogin);
        $exec->start();
    }

    /**
     * Handles the results of one of the update steps. and starts next step.
     *
     * @param ParalelExecution $paralelExec The parallel execution utility
     * @param string[] $results The results of the previous steps execution
     * @param int $ret The value returned from the previous
     */
    public function checkExecuted($paralelExec, $results, $ret = 1)
    {
        $AdminGroups = AdminGroups::getInstance();

        if ($ret != 0) {
            $this->console('Error while checking for updates eXpansion !!');
            $this->console($results);
            Gui::showError(
                $results,
                AdminGroups::getAdminsByPermission(Permission::SERVER_UPDATE)
            );
            $AdminGroups->announceToPermission(
                Permission::SERVER_UPDATE,
                '#admin_error#Error while checking for updates of #variable#eXpansion & Components !!'
            );
        } else {
            if ($this->arrayContainsText('Nothing to install or update', $results)) {
                $this->console('eXpansion & Components are up to date');
                $AdminGroups->announceToPermission(
                    Permission::SERVER_UPDATE,
                    '#vote_success#eXpansion & Components are up to date!'
                );
            } else {
                $this->console('eXpansion needs updating!!');
                $AdminGroups->announceToPermission(
                    Permission::SERVER_UPDATE,
                    '#admin_error#eXpansion needs updating!'
                );
            }
        }

        $this->onGoing = false;
    }

    /**
     * Will start the auto update process using git or http
     *
     * @param $login
     */
    public function autoUpdate($login)
    {
        $AdminGroups = AdminGroups::getInstance();

        //If on going updates cancel !!
        if ($this->onGoing) {
            $msg = "#admin_error#An update or check for update is already under way!";
            $AdminGroups->announceToPermission(Permission::SERVER_UPDATE, $msg);

            return;
        }

        $this->onGoing = true;

        $composer = $this->getComposerName();
        if ($this->config->useGit) {
            $cmds = array("$composer update --no-interaction --prefer-source");
        } else {
            $cmds = array("$composer update --no-interaction --prefer-dist");
        }

        $AdminGroups->announceToPermission(
            Permission::SERVER_UPDATE,
            '#admin_action#[#variable#AutoUpdate#admin_action#] Updating #variable#eXpansion & Components'
        );

        $exec = new ParalelExecution($cmds, array($this, 'updateExecuted'), 'eXpansion_update');
        $exec->setValue('login', $this->currentLogin);
        $exec->start();
    }


    /**
     * Handles the results of one of the update steps. and starts next step.
     *
     * @param ParalelExecution $paralelExec The parallel execution utility
     * @param string[] $results The results of the previous steps execution
     * @param int $ret The value returned from the previous
     */
    public function updateExecuted($paralelExec, $results, $ret = 1)
    {
        $AdminGroups = AdminGroups::getInstance();

        if ($ret != 0) {
            $this->console('Error while updating eXpansion !!');
            $this->console($results);
            Gui::showError(
                $results,
                AdminGroups::getAdminsByPermission(Permission::SERVER_UPDATE)
            );
            $AdminGroups->announceToPermission(
                Permission::SERVER_UPDATE,
                '#admin_error#Error while updating #variable#eXpansion & Components !!'
            );
        } else {
            $this->console('eXpansion Updated!!');
            $AdminGroups->announceToPermission(
                Permission::SERVER_UPDATE,
                '#vote_success#Update of #variable#eXpansion & Components #vote_success#Done'
            );
        }

        $this->onGoing = false;
    }


    public function eXpOnUnload()
    {
        parent::eXpOnUnload();
        UpdateProgress::EraseAll();
    }

    /**
     * Checks if one of the strings in the array contains another text
     *
     * @param string $needle text to search for in the array
     * @param string[] $array The array of text in which we need to search for the text
     *
     * @return bool was the needle found in the array
     */
    protected function arrayContainsText($needle, $array)
    {
        foreach ($array as $val) {
            if (strpos($val, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
