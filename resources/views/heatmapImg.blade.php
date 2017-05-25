<script src="{{url('js/build/heatmap.js')}}"></script>
    <script >


      window.onload = function() {

          //get data stage
          first     = '.'+(parseInt(JSON.parse('{{ json_encode($first) }}'))/10);
          secound   = '.'+(parseInt(JSON.parse('{{ json_encode($secound) }}'))/10);
          third     = '.'+(parseInt(JSON.parse('{{ json_encode($third) }}'))/10);
          fourth    = '.'+(parseInt(JSON.parse('{{ json_encode($fourth) }}'))/10);
          fiveth    = '.'+(parseInt(JSON.parse('{{ json_encode($fiveth) }}'))/10);

          console.log(first);
          console.log(secound);
          console.log(third);
          console.log(fourth);
          console.log(fiveth);
          console.log(typeof  first);


         var config= {
            container: document.getElementById('heatmapContainer'),
            opacity:.6,
            radius:3,
            // this line makes datapoints unblurred
            blur: 1,


            gradient: {
                         // enter n keys between 0 and 1 here
                         '.0': '#FFFFFF',

                       },


          }

         var gradient = config['gradient'];
          gradient[first]   =$('#one').css('backgroundColor');
          gradient[secound] =$('#two').css('backgroundColor');
          gradient[third]   =$('#three').css('backgroundColor');
          gradient[fourth]  =$('#four').css('backgroundColor');
          gradient[fiveth]  =$('#five').css('backgroundColor');

          console.log(config['gradient']);



        // create a heatmap instance
        var heatmap = h337.create(config);

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

        ctx.canvas.width = ctx.canvas.width/**1.5*/;
        ctx.canvas.height = ctx.canvas.height/**1.5*/;

        ctx.save();
        ctx.scale((width/64)/**1.5*/, (height/64)/**1.5*/);
        ctx.clearRect(0, 0, width, height);
        ctx.drawImage(copiedCanvas, 0, 0);

        //var div = document.getElementById("heatmapPic");
        //div.style.height = "1500px";






      };
    </script>
