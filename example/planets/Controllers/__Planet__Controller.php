<?php 
namespace Planets\Controllers;

use Planets\Models\/*{the_planet}*/Model;
use Planets\Models\/*{the_planet}*/View;

/*
* Mercury Class
*/
class /*{the_planet}*/Controller extends BaseController
{
  
  function __construct()
  {
    # code...
  }

  function get(){

    //Some Values
    $/*{first_planet}*/ = 'First Planet';
    $/*{second_planet}*/ = 'Second Planet';
    $/*{third_planet}*/ = 'Blue Marble';
    $/*{fourth_planet}*/ = 'Second Home';
    //Let's use for each
    /*{for:outter_planets}*/
    $/*{outter_planets>name}*/Distance = '/*{outter_planets>distance}*/';/*{/for}*/ 

    $model = New /*{the_planet}*/Model();
    $view = New /*{the_planet}*/View();
  }
}