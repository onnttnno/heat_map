
    <script>
      window.onload = function() {
          //get data stage
          var first = parseFloat('{{ Session::get('first');}}')/100;
          var secound = parseFloat('{{ Session::get('secound');}}')/100;
          var third = parseFloat('{{ Session::get('third');}}')/100;
          var fourth = parseFloat('{{ Session::get('fourth');}}')/100;
          var fiveth = parseFloat('{{ Session::get('fiveth');}}')/100;

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
                       '.0': '#FFFFFF',
                       first.toString(): '#FFFFFF',
                       secound.toString(): '#FFFFFF',
                       third.toString(): '#FFFFFF',
                       fourth.toString(): '#FFFFFF',
                       fiveth.toString(): '#FFFFFF'
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
                 var val = Math.floor(matrix[i][j]*100);
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
