<?php

class SpreadTheBlubb extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        if ($GLOBALS['perm']->have_perm("autor")) {
            if (!Navigation::hasItem("/links/settings/blubber")) {
                $settings_tab = new Navigation(_("Blubber"), PluginEngine::getURL($this, array(), "settings"));
                Navigation::addItem("/links/settings/blubber", $settings_tab);
            }
            Navigation::addItem("/links/settings/blubber/spreadtheblubb", new Navigation(_("Blubbervernetzung"), PluginEngine::getURL($this, array(), "settings/set")));
        }
    }

}