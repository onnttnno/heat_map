<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Excel;


class CSV extends Excel{
    //protected $table = 'foods';


   protected $delimiter  = ',';
   protected $enclosure  = '"';
   protected $lineEnding = '\r\n';



}


?>
