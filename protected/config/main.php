<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ 
if(file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'i-main.php')) {
    return require_once 'i-main.php';
}
return require_once 'inst-main.php';
