<?php
/**
 * module class
 * Application modules related class
 *
 * Copyright (C) 2010 Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
    die("can not access this file directly");
}

class module extends simbio
{
    private $modules_dir = 'modules';
    private $module_table = 'mst_module';
    public $module_list = array();
    public $appended_first_a = '<li class="active"><a class="menu home#replaced#" href="index.php"><i class="fa fa-home fa-fw"></i><span>Home<span class="fa arrow"></span></a><ul>';
    public $appended_first_b = '</ul></li>';
    public $appended_second = '<li><a class="menu opac" href="../index.php" title="View OPAC in New Window" target="_blank"><i class="fa fa-search fa-fw"></i><span>OPAC</span></a></li>';
    public $appended_last = '<li><a class="menu logout" href="logout.php"><i class="fa fa-sign-out fa-fw"></i><span>LOGOUT</span></a></li>';


    /**
     * Method to set modules directory
     *
     * @param   string  $str_modules_dir
     * @return  void
     */
    public function setModulesDir($str_modules_dir)
    {
        $this->modules_dir = $str_modules_dir;
    }


    /**
     * Method to generate a list of module menu
     *
     * @param   object  $obj_db
     * @return  string
     */
    public function generateModuleMenu($obj_db)
    {
        // get module data from database
        $_mods_q = $obj_db->query('SELECT * FROM '.$this->module_table);
        while ($_mods_d = $_mods_q->fetch_assoc()) {
            $this->module_list[] = array('name' => $_mods_d['module_name'], 'path' => $_mods_d['module_path'], 'desc' => $_mods_d['module_desc']);
        }

        // create the HTML Hyperlinks
        //$_menu = '<ul id="menuList">';
	$_menu = '';
        $_menu .= !isset($_GET['mod'])?str_replace('#replaced#', ' menuCurrent',$this->appended_first_a):str_replace('#replaced#', '',$this->appended_first_a);
	$_menu .= $this->generateSubMenu('default');
	$_menu .= $this->appended_first_b;
	$_menu .= $this->appended_second;
        // sort modules
        if ($this->module_list) {
            foreach ($this->module_list as $_module) {
                $_formated_module_name = ucwords(str_replace('_', ' ', $_module['name']));
                $_mod_dir = $_module['path'];
                if (isset($_SESSION['priv'][$_module['path']]['r']) && $_SESSION['priv'][$_module['path']]['r'] && file_exists($this->modules_dir.$_mod_dir)) {
                    
                    $this->setModulesDir(MDLBS);
                    $current_module = '';
                    $current_module = trim($_module['name']);
                    $can_read = utility::havePrivilege($current_module, 'r');
                    $sub_menu = $this->generateSubMenu(($current_module AND $can_read)?$current_module:'');
                    
                    $_menu .= '<li class="'.( (isset($_GET['mod']) && $_GET['mod']==$_module['path'])?'active':'' ).'"><a class="menu '.$_module['name'].( (isset($_GET['mod']) && $_GET['mod']==$_module['path'])?' menuCurrent':'' ).'" title="'.$_module['desc'].'" href="index.php?mod='.$_mod_dir.'"><i class="fa fa-'.$_module['name'].' fa-fw"></i><span>'.__($_formated_module_name).'</span><span class="fa arrow"></span></a><ul class="nav nav-second-level">'.$sub_menu.'</ul></li>';
                }
            }
        }
        $_menu .= $this->appended_last;
        //$_menu .= '</ul>';

        return $_menu;
    }


    /**
     * Method to generate a list of module submenu
     *
     * @param   string  $str_module
     * @return  string
     */
    public function generateSubMenu($str_module = '')
    {
        global $dbs;
        $_submenu = '';
        $_submenu_file = $this->modules_dir.$str_module.DIRECTORY_SEPARATOR.'submenu.php';
        if (file_exists($_submenu_file)) {
            include $_submenu_file;
        } else {
            include 'default/submenu.php';
        }
        // iterate menu array
        foreach ($menu as $_list) {
            if ($_list[0] == 'Header') {
                $_submenu .= '<li><a href="#" class="subMenuHeader">'.$_list[1].'<span class="fa plus-minus"></span></a>';
            } elseif ($_list[0] == 'A'){
		$_submenu .= '<ul><li class="sub_menu"><a class="subMenuItem" '
                    .' href="'.$_list[2].'"'
                    .' title="'.( isset($_list[3])?$_list[3]:$_list[1] ).'" href="#"><i class="fa fa-angle-right"></i><span>'.$_list[1].'</span></a></li>';
	    } elseif ($_list[0] == 'Z'){
		$_submenu .= '<li class="sub_menu"><a class="subMenuItem" '
                    .' href="'.$_list[2].'"'
                    .' title="'.( isset($_list[3])?$_list[3]:$_list[1] ).'" href="#"><i class="fa fa-angle-right"></i><span>'.$_list[1].'</span></a></li></ul></li>';
	    } else {
                $_submenu .= '<li class="sub_menu"><a class="subMenuItem" '
                    .' href="'.$_list[1].'"'
                    .' title="'.( isset($_list[2])?$_list[2]:$_list[0] ).'" href="#"><i class="fa fa-angle-right"></i><span>'.$_list[0].'</span></a></li>';
            }
        }
        $_submenu .= '&nbsp;';
        return $_submenu;
    }
}
