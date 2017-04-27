<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCSVTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CSV', function (Blueprint $table) {
           $table->increments('id');
           $table->dateTime('form');
           $table->dateTime('to');
           $table->time('interval');
           $table->text('timezone');

           //row for data matrix
           /*for ($i = 0; $i < 64; $i++) {
                    $table->text('row'.i);
                }*/
                //10 row
            $table->text('row0');
            $table->text('row1');
            $table->text('row2');
            $table->text('row3');
            $table->text('row4');
            $table->text('row5');
            $table->text('row6');
            $table->text('row7');
            $table->text('row8');
            $table->text('row9');

            //20 row
            $table->text('row10');
            $table->text('row11');
            $table->text('row12');
            $table->text('row13');
            $table->text('row14');
            $table->text('row15');
            $table->text('row16');
            $table->text('row17');
            $table->text('row18');
            $table->text('row19');


            //30 row
            $table->text('row20');
            $table->text('row21');
            $table->text('row22');
            $table->text('row23');
            $table->text('row24');
            $table->text('row25');
            $table->text('row26');
            $table->text('row27');
            $table->text('row28');
            $table->text('row29');


            //40 row
            $table->text('row30');
            $table->text('row31');
            $table->text('row32');
            $table->text('row33');
            $table->text('row34');
            $table->text('row35');
            $table->text('row36');
            $table->text('row37');
            $table->text('row38');
            $table->text('row39');



            //50 row

            $table->text('row40');
            $table->text('row41');
            $table->text('row42');
            $table->text('row43');
            $table->text('row44');
            $table->text('row45');
            $table->text('row46');
            $table->text('row47');
            $table->text('row48');
            $table->text('row49');

            //60 row
            $table->text('row50');
            $table->text('row51');
            $table->text('row52');
            $table->text('row53');
            $table->text('row54');
            $table->text('row55');
            $table->text('row56');
            $table->text('row57');
            $table->text('row58');
            $table->text('row59');


            //64 row
            $table->text('row60');
            $table->text('row61');
            $table->text('row62');
            $table->text('row63');


            $table->timestamps();


       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
