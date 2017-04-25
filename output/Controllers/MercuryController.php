<?php 
namespace Planets\Controllers;

use Planets\Models\MercuryModel;
use Planets\Models\MercuryView;

/*
* Mercury Class
*/
class MercuryController extends BaseController
{
  
  function __construct()
  {
    # code...
  }

  function get(){

    //Some Values
    $Mercury = 'First Planet';
    $Venus = 'Second Planet';
    $Earth = 'Blue Marble';
    $Mars = 'Second Home';
    //Let's use for each
    
    $JupiterDistance = '5.2 AU';
    $SaturnDistance = '9.5 AU';
    $UranusDistance = '19.2 AU';
    $NeptuneDistance = '30.1 AU'; 

    $model = New MercuryModel();
    $view = New MercuryView();
  }
}