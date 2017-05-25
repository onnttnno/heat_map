<?php



//this is core Controllers
//it trow csv to Model for spit and save data to db
//it load data form model
// it trown to another model for comput avg and use gausian distibution
namespace App\Http\Controllers;

ini_set('max_execution_time', 3000000);
ini_set('max_input_time ', 3000000);
ini_set("memory_limit","2048M");

use Illuminate\Http\Request;
use App\Model\CSV;
use App\Model\CsvToDB;
use App\Model\HeatMatrix;
//lib or package which use

//for csv
use Validator;
use Excel;
use Session;

//for time
use DateTime;
use DatePeriod;
use DateIntercal;
use Carbon\Carbon;
use App;


//for compute matrix
use MCordingley\LinearAlgebra\Matrix;

//
use Exception;

class HeatController extends Controller
{

    public $first;
    public $secound;
    public $third;
    public $fourth;
    public $fiveth;
        // init stage for compute color in heatmap
        public function __construct()
        {

            $this->first=50;
            $this->secound=60;
            $this->third=70;
            $this->fourth=80;
            $this->fiveth=90;

        }


        //show index
        //getdata from db adn trow to model for generation matrix

        public function index(){
            $dataInDB = CsvToDB::get();

            $arrayMatrix=array();

            foreach ($dataInDB as $csv) {

                    $array=array();

                    array_push ($array,
                    $csv->row0,$csv->row1,$csv->row2,$csv->row3,$csv->row4,$csv->row5,$csv->row6,$csv->row7,$csv->row8,$csv->row9
                    ,$csv->row10,$csv->row11,$csv->row12,$csv->row13,$csv->row14,$csv->row15,$csv->row16,$csv->row17,$csv->row18,$csv->row19
                    ,$csv->row20,$csv->row21,$csv->row22,$csv->row23,$csv->row24,$csv->row25,$csv->row26,$csv->row27,$csv->row28,$csv->row29
                    ,$csv->row30,$csv->row31,$csv->row32,$csv->row33,$csv->row34,$csv->row35,$csv->row36,$csv->row37,$csv->row38,$csv->row39
                    ,$csv->row40,$csv->row41,$csv->row42,$csv->row43,$csv->row44,$csv->row45,$csv->row46,$csv->row47,$csv->row48,$csv->row49
                    ,$csv->row50,$csv->row51,$csv->row52,$csv->row53,$csv->row54,$csv->row55,$csv->row56,$csv->row57,$csv->row58,$csv->row59
                    ,$csv->row60,$csv->row61,$csv->row62,$csv->row63

                    );

                    $heatMatrix = new HeatMatrix;

                    array_push ($arrayMatrix,$heatMatrix->create($array));
                }

            if (count($dataInDB)>0 && !empty($dataInDB)) {
                $dateFrom = Carbon::parse($dataInDB[0]->from)->format('Y-m-d')." ".Carbon::parse($dataInDB[0]->from)->format('H:i');
                $dateTo =Carbon::parse($dataInDB[count($dataInDB) -1]->to)->format('Y-m-d')." ".Carbon::parse($dataInDB[count($dataInDB) -1]->to)->format('H:i');
                $matrix = array();
                return view('heat_map',['dataInDB' => $dataInDB,'dateFrom'=>$dateFrom,'dateTo'=>$dateTo,'matrix' => $matrix,
                'first' => $this->first,'secound' => $this->secound,'third' => $this->third,'fourth' => $this->fourth,'fiveth' => $this->fiveth]);
            }
            else{

                $dateFrom = "";
                $dateTo ="";
                $matrix = array();
                return view('heat_map',['dataInDB' => $dataInDB,'dateFrom'=>$dateFrom,'dateTo'=>$dateTo,'matrix' => $matrix,
                'first' => $this->first,'secound' => $this->secound,'third' => $this->third,'fourth' => $this->fourth,'fiveth' => $this->fiveth]);

            }



        }


        //import data form csv file to DB
        //by form,to,interval,timezone, each column
        //and matrix push 1 row  to 1 column
            public function import(Request $request)

            {


                //$array_date_from = array();
                //$array_date_to  = array();
                //$array_interval  = array();
                //$array_timezone  = array();
                //$array_metrix       = array();

                $pureDatas=array();

                $date_from = new DateTime;
                $date_to = new DateTime;
                $interval =new DateTime;
                $timezone = "";




                $row = 0;
//try {



                if($request->exists('btn-import'))                                {
                                    $validator = Validator::make($request->all(), [
                                      //'csvFile'     => 'required|mimes:csv,txt',
                                     'csvFile'     => 'required',
                                   ]);
                                   if ($validator->fails()) {
                                       return redirect('/')
                                                   ->withErrors($validator)
                                                   ->withInput();

                                   }
                                   else
                                    {



                                        $fileCsv = $request->file('csvFile')->getRealPath();

                                        $datas = CSV::load($fileCsv, function($reader) {
                                        })->noHeading()->all();



                                                    if(!empty($datas) && $datas->count())
                                                    {

                                                        $i =0;
                                                        //read all row
                                                        foreach ($datas as $data)
                                                        {


                                                                //check is data wich use
                                                            if(is_numeric($data[0]) && is_numeric($data[1]) && is_numeric($data[2]) && is_numeric($data[3]) )
                                                            {
                                                                //pull pure data and fillter it

                                                                array_push($pureDatas,$data);


                                                            }


                                                        }

                                                    }

                                                    $i=0;
                                                    while ($i < count($pureDatas)) {

                                                        $data=$pureDatas[$i];
                                                        //which information
                                                        if(is_null($data[20]))
                                                        {

                                                            /*
                                                            string substr ( string $string , int $start [, int $length ] )
Returns the portion of string speci                             fied by the start and length parameters.
$rest = substr("abcdef", -3, 1); // returns "d"
                                                            */

                                                            //form
                                                            $date = $data[0]."";
                                                            $date_from =  Carbon::parse(substr ($date,0,1)."".substr($date,1,1)."".substr ($date,2,1)."".substr ($date,3,1).'-'.substr ($date,4,1).''.substr ($date,5,1).'-'.substr ($date,6,1).''.substr ($date,7,1).'  '.$data[1][0].
                                                            ''.$data[1][1].':'.$data[1][2].''.$data[1][3]);

                                                            //to

                                                            $date = $data[2]."";
                                                            $date_to =Carbon::parse(substr ($date,0,1)."".substr ($date,1,1)."".substr ($date,2,1)."".substr ($date,3,1).'-'.substr ($date,4,1).''.substr ($date,5,1).'-'.substr ($date,6,1).''.substr ($date,7,1).'  '.$data[3][0].
                                                            ''.$data[3][1].':'.$data[3][2].''.$data[3][3]);


                                                            //interval

                                                            $interval=date_format( new DateTime($data[4]),' H:i:s');

                                                            //timezone
                                                            $timezone = $data[5];

                                                            $i++;

                                                        }
                                                        //matrix
                                                        else
                                                        {
                                                            $matrix = array();

                                                            for ($r=0; $r < 64; $r++) {
                                                                //push all column in same row to only 1 data
                                                                $row ="";
                                                                for ($c=0; $c < 64; $c++) {
                                                                    $row=$row.$pureDatas[$i+$r][$c];

                                                                }
                                                                array_push($matrix,$row);

                                                            }




                                                            //information
                                                            $csv = new CsvToDB;

                                                            $csv->from = $date_from;
                                                            $csv->to   = $date_to;
                                                            $csv->interval= $interval;
                                                            $csv->timezone= $timezone;

                                                                //matrix data
                                                            $csv->row0 = $matrix[0];


                                                            $csv->row1 = $matrix[1];


                                                            $csv->row2 = $matrix[2];

                                                            $csv->row3 = $matrix[3];

                                                            $csv->row4 = $matrix[4];

                                                            $csv->row5 = $matrix[5];

                                                            $csv->row6 = $matrix[6];

                                                            $csv->row7 = $matrix[7];

                                                            $csv->row8 = $matrix[8];

                                                            $csv->row9 = $matrix[9];



                                                            //20 row

                                                            $csv->row10 = $matrix[10];


                                                            $csv->row11 = $matrix[11];

                                                            $csv->row12 = $matrix[12];

                                                            $csv->row13 = $matrix[13];

                                                            $csv->row14 = $matrix[14];

                                                            $csv->row15 = $matrix[15];

                                                            $csv->row16 = $matrix[16];

                                                            $csv->row17 = $matrix[17];

                                                            $csv->row18 = $matrix[18];

                                                            $csv->row19 = $matrix[19];



                                                            //30 row


                                                            $csv->row20 = $matrix[20];


                                                            $csv->row21 = $matrix[21];

                                                            $csv->row22 = $matrix[22];

                                                            $csv->row23 = $matrix[23];

                                                            $csv->row24 = $matrix[24];

                                                            $csv->row25 = $matrix[25];

                                                            $csv->row26 = $matrix[26];

                                                            $csv->row27 = $matrix[27];

                                                            $csv->row28 = $matrix[28];

                                                            $csv->row29 = $matrix[29];


                                                                //40
                                                            $csv->row30 = $matrix[30];

                                                            $csv->row31 = $matrix[31];

                                                            $csv->row32 = $matrix[32];

                                                            $csv->row33 = $matrix[33];

                                                            $csv->row34 = $matrix[34];

                                                            $csv->row35 = $matrix[35];

                                                            $csv->row36 = $matrix[36];

                                                            $csv->row37 = $matrix[37];

                                                            $csv->row38 = $matrix[38];

                                                            $csv->row39 = $matrix[39];


                                                                //50
                                                            $csv->row40 = $matrix[40];

                                                            $csv->row41 = $matrix[41];

                                                            $csv->row42 = $matrix[42];

                                                            $csv->row43 = $matrix[43];

                                                            $csv->row44 = $matrix[44];

                                                            $csv->row45 = $matrix[45];

                                                            $csv->row46 = $matrix[46];

                                                            $csv->row47 = $matrix[47];

                                                            $csv->row48 = $matrix[48];

                                                            $csv->row49 = $matrix[49];


                                                                //60

                                                            $csv->row50 = $matrix[50];

                                                            $csv->row51 = $matrix[51];

                                                            $csv->row52 = $matrix[52];

                                                            $csv->row53 = $matrix[53];

                                                            $csv->row54 = $matrix[54];

                                                            $csv->row55 = $matrix[55];

                                                            $csv->row56 = $matrix[56];

                                                            $csv->row57 = $matrix[57];

                                                            $csv->row58 = $matrix[58];

                                                            $csv->row59 = $matrix[59];
                                                                //64
                                                            $csv->row60 = $matrix[60];

                                                            $csv->row61 = $matrix[61];

                                                            $csv->row62 = $matrix[62];

                                                            $csv->row63 = $matrix[63];

                                                            $csv->save();

                                                            while (!$csv) {
                                                                $csv->save();
                                                            }

                                                            $i =$i+64;

                                                        }



                                                    }




                                    }
                                }



                                return redirect()->back();

//}

//catch (\Exception $e) {
    //return $e->getMessage();
//}
            }



        //clear data in DB

            public function clear(Request $request){

                    CsvToDB::truncate();


                    return redirect('/');
            }

        //search frequency of heapmap
        //Do...
        //1.find avg. from all matrix
        //2.use gausian distibution
        //3.convert matrix to Imagic

        public function search(Request $request){
            //when sarch push
            //retrive form and to in DB

                    if (CsvToDB::get()->count() <= 0) {

                        Session::flash('message', "No result!!!");
                        return redirect('/');

                        }


                    elseif (CsvToDB::get()->count() > 0) {

                            Session::flash('message', "");
                            $dataInDB = CsvToDB::get();
                            $dateFrom = Carbon::parse($dataInDB[0]->from)->subSeconds(1)->format('Y-m-d H:i');
                            $dateTo =Carbon::parse($dataInDB[count($dataInDB) -1]->to)->addSeconds(1)->format('Y-m-d H:i');

                            if($request->exists('search'))
                                    {





                                        $validator = Validator::make($request->all(), [
                                          //'csvFile'     => 'required|mimes:csv,txt',
                                         'From'     => 'required|date|after_or_equal:'.$dateFrom .'|before_or_equal:'.$dateTo,
                                         'To'     => 'required|date|after_or_equal:'.$dateFrom .'|before_or_equal:'.$dateTo,
                                       ]);
                                       if ($validator->fails())
                                       {
                                           return redirect('/')
                                                       ->withErrors($validator)
                                                       ->withInput();

                                       }
                                       //get date form and date to
                                       else
                                       {
                                           $from=Carbon::parse($request->From)->format('y/m/d h:m');
                                           $to =Carbon::parse($request->To)->format('y/m/d h:m');

                                           //find  nearest time
                                           $min_time =CsvToDB::where('from', '<=', $from)->orderBy('from', 'desc')->limit(1)->get();
                                           $max_time = CsvToDB::where('to', '>=', $to)->orderBy('to', 'asc')->limit(1)->get() ;

                                           //check it can get data from db realy?
                                           if(isset($max_time[0]) && isset($min_time[0]))
                                           {
                                                       $max = Carbon::parse($max_time[0]->to);
                                                       $min = Carbon::parse($min_time[0]->from);

                                                       //get data in DB wich in this interval
                                                       $csv = new CsvToDB;
                                                       $data = $csv::where('from','>=',$min_time[0]->from)->where('to','<=',$max_time[0]->to)->get();

                                                       // make array of heap matrix
                                                       $arrayMatrix=array();

                                                       foreach ($data as $csv) {

                                                               $array=array();

                                                               array_push ($array,
                                                               $csv->row0,$csv->row1,$csv->row2,$csv->row3,$csv->row4,$csv->row5,$csv->row6,$csv->row7,$csv->row8,$csv->row9
                                                               ,$csv->row10,$csv->row11,$csv->row12,$csv->row13,$csv->row14,$csv->row15,$csv->row16,$csv->row17,$csv->row18,$csv->row19
                                                               ,$csv->row20,$csv->row21,$csv->row22,$csv->row23,$csv->row24,$csv->row25,$csv->row26,$csv->row27,$csv->row28,$csv->row29
                                                               ,$csv->row30,$csv->row31,$csv->row32,$csv->row33,$csv->row34,$csv->row35,$csv->row36,$csv->row37,$csv->row38,$csv->row39
                                                               ,$csv->row40,$csv->row41,$csv->row42,$csv->row43,$csv->row44,$csv->row45,$csv->row46,$csv->row47,$csv->row48,$csv->row49
                                                               ,$csv->row50,$csv->row51,$csv->row52,$csv->row53,$csv->row54,$csv->row55,$csv->row56,$csv->row57,$csv->row58,$csv->row59
                                                               ,$csv->row60,$csv->row61,$csv->row62,$csv->row63

                                                               );

                                                               $heatMatrix = new HeatMatrix;

                                                               array_push ($arrayMatrix,$heatMatrix->create($array));
                                                           }

                                                           //compute avg
                                                           //1.sum all matrix

                                                         $sum = $arrayMatrix[0];

                                                           for ($k=1; $k <count($arrayMatrix) ; $k++) {
                                                              // $item=new Matrix($arrayMatrix[$i]);

                                                              // $sum = $sum->addMatrix($item);

                                                              for ($i=0; $i <64 ; $i++) {
                                                                  for ($j=0; $j <64  ; $j++) {

                                                                      $sum[$i][$j] = $sum[$i][$j] + $arrayMatrix[$k][$i][$j];
                                                                  }
                                                              }
                                                           }
                                                           //2.divide by count

                                                           //$avgMatrix = $sum->multiplyScalar(1/$min->diffInMinutes($max));
                                                           $avgMatrix = array();
                                                           for ($i=0; $i < 64 ; $i++) {
                                                               for ($j=0; $j < 64 ; $j++) {
                                                                   $avgMatrix[$i][$j] = $sum[$i][$j]/(1/$min->diffInMinutes($max));
                                                               }
                                                           }
                                                           /*
                                                           //matrix to array
                                                            $matrix=array();
                                                            for ($row=0; $row < 64; $row++) {
                                                                $rowMatrix=array();
                                                                for ($column=0; $column < 64; $column++) {
                                                                    $rowMatrix[]=$avgMatrix->get($row,$column);
                                                                }
                                                                $matrix[]=$rowMatrix;
                                                            }

                                                            */



                                                      // return view('test',['matrix' => $matrix]);

                                                       $dataInDB = CsvToDB::get();

                                                       $arrayMatrix=array();

                                                       foreach ($dataInDB as $csv) {

                                                               $array=array();

                                                               array_push ($array,
                                                               $csv->row0,$csv->row1,$csv->row2,$csv->row3,$csv->row4,$csv->row5,$csv->row6,$csv->row7,$csv->row8,$csv->row9
                                                               ,$csv->row10,$csv->row11,$csv->row12,$csv->row13,$csv->row14,$csv->row15,$csv->row16,$csv->row17,$csv->row18,$csv->row19
                                                               ,$csv->row20,$csv->row21,$csv->row22,$csv->row23,$csv->row24,$csv->row25,$csv->row26,$csv->row27,$csv->row28,$csv->row29
                                                               ,$csv->row30,$csv->row31,$csv->row32,$csv->row33,$csv->row34,$csv->row35,$csv->row36,$csv->row37,$csv->row38,$csv->row39
                                                               ,$csv->row40,$csv->row41,$csv->row42,$csv->row43,$csv->row44,$csv->row45,$csv->row46,$csv->row47,$csv->row48,$csv->row49
                                                               ,$csv->row50,$csv->row51,$csv->row52,$csv->row53,$csv->row54,$csv->row55,$csv->row56,$csv->row57,$csv->row58,$csv->row59
                                                               ,$csv->row60,$csv->row61,$csv->row62,$csv->row63

                                                               );

                                                               $heatMatrix = new HeatMatrix;

                                                               array_push ($arrayMatrix,$heatMatrix->create($array));
                                                           }

                                                       if (count($dataInDB)>0 && !empty($dataInDB)) {
                                                           $dateFrom = Carbon::parse($dataInDB[0]->from)->format('Y-m-d h:m');
                                                           $dateTo =Carbon::parse($dataInDB[count($dataInDB) -1]->to)->format('Y-m-d h:m');
                                                           return view('heat_map',['dataInDB' => $dataInDB,'dateFrom'=>$dateFrom,'dateTo'=>$dateTo,'matrix' => $avgMatrix ,
                                                          'first' => $this->first,'secound' => $this->secound,'third' => $this->third,'fourth' => $this->fourth,'fiveth' => $this->fiveth]);
                                                       }
                                                       else{

                                                           $dateFrom = "";
                                                           $dateTo ="";
                                                           return view('heat_map',['dataInDB' => $dataInDB,'dateFrom'=>$dateFrom ,'dateTo'=>$dateTo ,'matrix' => $avgMatrix ,
                                                           'first' => $this->first,'secound' => $this->secound,'third' => $this->third,'fourth' => $this->fourth,'fiveth' => $this->fiveth]);

                                                       }
                                            }


                                            else{
                                                return $from;
                                            }
                                       }



                        }
                }


            }








}
