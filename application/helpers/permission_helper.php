<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('has_permission')) {
    function has_permission($permissions, $menu, $action) {
        foreach ($permissions as $perm) {
            if ($perm['permission'] == $menu && $perm[$action] == 1) {
                return true;
            }
        }
        return false;
    }
}
