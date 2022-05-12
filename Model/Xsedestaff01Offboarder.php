<?php

class Xsedestaff01Offboarder extends AppModel {
  // Required by COmanage Plugins
  public $cmPluginType = "other";

  public function cmPluginMenus() {
    $menus = array();
    $url = array();

    $url['controller'] = 'xsedestaff_offboard_petitions';
    $url['action'] = 'add';

    $menus["coperson"][_txt('pl.xsedestaff01_offboarder.menu.coperson.link.text')] = $url;

    return $menus;
  }
}
