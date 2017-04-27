<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Bootstrap CSS -->
    <link rel = "stylesheet" href= "{{ url('css/app.css')}}">
    <style>
      body, html, h2 { margin:0; padding:0; height:100%;}
      body { font-family:sans-serif; }
      body * { font-weight:200;}
      #heatmapContainerWrapper { width:100%; height:100%; position:absolute; background:rgba(0,0,0,.1); }
      #heatmapContainer { width:100%; height:100%;}
      #heatmapLegend { background:white; position:absolute; bottom:0; right:0; padding:10px; }
      #min { float:left; }
      #max { float:right; }
      h1 { position:absolute; background:black; color:white; padding:10px;}
      #all-examples-info { position:absolute; background:white; font-size:16px; padding:20px; top:100px; width:350px; line-height:150%; }
      .heatmap-canvas{

          background-image: url("{{asset('/img/fish.jpg')}}");
          -webkit-background-image: url("{{asset('/img/fish.jpg')}}");
          border:1px solid black;


      }

    </style>

  </head>
  <body>


<input type="hidden" name="_token" value="{{ csrf_token() }}">
<p id="unicode"></p>

<div id="heatmapContainerWrapper">
 <div id="heatmapContainer">




     <script src="{{url('js/build/heatmap.js')}}"></script>
         <script>
           window.onload = function() {
             // helper function
             function $(id) {
               return document.getElementById(id);
             };


             // create a heatmap instance
             var heatmap = h337.create({
               container: document.getElementById('heatmapContainer'),
               opacity:.6,
               radius:5,
               // this line makes datapoints unblurred
               blur: 1,


               gradient: {
                            // enter n keys between 0 and 1 here
                            // for gradient color customization
                            '.0': 'white',
                            '.6': 'blue',
                            '.7': 'green',
                            '.8': 'yellow',
                            '.9': 'red'
                          },


             });

             // boundaries for data generation
             var width = 64;
             var height = 64;

             // generate 1000 datapoints
             var generate = function() {
               // randomly generate extremas


               var max = 0;
               var matrix = JSON.parse('{{ json_encode($matrix) }}');


               var t = [];


               for (var i = 0; i < 64; i++) {
                   for (var j = 0; j <64 ; j++) {
                      var val = Math.floor(matrix[i][j]*1000);
                      max = Math.max(max, val);
                      var point = {
                          x: i,
                          y: j,
                          value: val
                      };
                      t.push(point);

                   }

               }


              /* for (var i = 0; i < 400; i++) {
                   var val = Math.floor(Math.random()*100);
                   max = Math.max(max, val);

                   var point = {
                       x: Math.floor(Math.random()*width),
                       y: Math.floor(Math.random()*height),
                       value: val
                   };




                 // btw, we can set a radius on a point basis
                //(Math.random()* 30) >> 0;
                 // add to dataset
                 t.push(point);
             }*/
               var init = +new Date;
               // set the generated dataset
               heatmap.setData({

                 max: max,
                 data: t
               });
               //console.log('took ', (+new Date) - init, 'ms');
             };
             // initial generate
             generate();

             var c = document.getElementsByClassName('heatmap-canvas')[0];

             var ctx = c.getContext("2d");
             var width = ctx.canvas.width;
             var height = ctx.canvas.height;

             var imageData = ctx.getImageData(0, 0, 64, 64);
             var copiedCanvas = document.createElement("canvas");
             copiedCanvas.width = width;
             copiedCanvas.height = height;
             copiedCanvas.getContext("2d").putImageData(imageData, 0, 0);


             ctx.save();
             ctx.scale(width/64, height/64);
             ctx.clearRect(0, 0, width, height);
             ctx.drawImage(copiedCanvas, 0, 0);

             //add img background

             //{{asset('/img/fish.jpg')}}



             // whenever a user clicks on the ContainerWrapper the data will be regenerated -> new max & min


           };
         </script>




     </div>
     </div>

      <script type="text/javascript" src="{{ url('js/select_file.js')}}" ></script>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
