# Marsgen PHP File Generator

Marsgen is a PHP generator. It generates predefined files and folders with given data. It can be used to generate scaffolding. It can create files and folders and put codes inside.

##### Steps
  - Prepare code generation template
  - Create a seed file
  - Run from command line
 
# Usage
If you have  PHP installed and if its callable from your terminal just download this repository and run this command: (for windows there is a bat file so you can just use "marsgen" instead of "php marsgen.php")
```
D:\marsgen>php marsgen.php generate /example/planets /example/planet_seed.php /output
```
This command will fetch every file under */example/planets* folder and it will load config from */example/planet_seed.php* and generate all files and folders under */output* folder.

Seed file and output folder are optional. If no output folder defined it will generate files on the folder where command called from.

# Templating and Syntax 
Seed files and folders may have variables. Lets say you want to generate VenusModel.php VenusView.php you can name the templaste files as -Planet-Model.php and -Planet-View.php and put this variable on seed file.
```php
$seed['__FileSystem__'] = [
  '-Planet-' => 'Venus'
];
$seed['myVar'] = 'Hello World';
$seed['myArray'] = [['name'=>'item1'],['name'=>'item2']];
```
In template files you can place variables with ```/*{myVar}*/``` syntax with above seed file this will generate ```Hello world``` as output.

You can loop code blocks with for ```/*{for:myArray}*/ Name value is /*{myArray>name}*/. /*{/for*/}``` as you can see to access sub values of for item we use ```/*{myArray>name}*/``` syntax. This for each will generate ```Name value is: item1. Name value is: item2.``` You can use isset blocks inside for blocks.

Isset block is simple ``` /*{isset:myVar}*/ myVar's value is /*{myVar}*/ /*{/isset}*/```

# Sample
**Template file: SourceFolder/Controllers/-Planet-Controller.php**
```php
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
```
**Template file: MercurySeedFile.php**

```php
<?php
$seed = [];
$seed['__FileSystem__'] = [
  '-Planet-' => 'Mercury',
  '-Echo-' => 'Hello'
];

$seed['the_planet'] = 'Mercury';
$seed['first_planet'] = 'Mercury';
$seed['second_planet'] = 'Venus';
$seed['third_planet'] = 'Earth';
$seed['fourth_planet'] = 'Mars';

$seed['outter_planets'] = [
  ['name' => 'Jupiter', 'distance' =>'5.2 AU'],
  ['name' => 'Saturn', 'distance' =>'9.5 AU'],
  ['name' => 'Uranus', 'distance' =>'19.2 AU'],
  ['name' => 'Neptune', 'distance' =>'30.1 AU']
];

return $seed;
```
**Result: TargetFolder/Controllers/MercuryController.php**
```php
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
``` 

##### Notes:
  - Nested foreach() and isset() controls are not supported.
  - There is no else condition for isset() function for now.

This is a personal helper repository for one of my projects so I only included functions what I needed. If you add more functionality please send a pull request to my repository so everyone can enjoy it :)

##### Plans:
Current version is enough for my needs but I may add these features to template parser later.
  - Option to add values from command line instead of seed file
  - Else condition for isset().
  - If/else condition.
  - Switch/Case condition.
  - Nested foreach support. 