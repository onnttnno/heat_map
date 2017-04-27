<?php

//this class is translate data form DB to matrix
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class HeatMatrix extends Model{

    private $matrix;

    public function __construct()
    {

        $matrix = array();


    }

    public function create($data)
    {

        foreach ($data as $row)
        {
            $rowData = array();
            $rows =str_split($row);


            foreach ($rows as $column) {

                $item = intval($column);
                array_push($rowData,$item);
            }

            $this->matrix[]=$rowData;

        }



        return $this->matrix;
    }


}


?>
