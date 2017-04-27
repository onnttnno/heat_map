//1 is small
//2 is midium
//3 is large

$(document).ready(function() {
     var oldStage = 2;

    $('input:radio[name=size]').change(function() {
        var scale = 0;
        if (this.value == '1/2') {
            var stage = 1;
            if (oldStage >stage) {
                scale = 1/(Math.pow(1.5, oldStage - stage));
            } else if (oldStage == stage) {
                scale = 1;
            }
            else
            {
                scale = Math.pow(1.5, stage - oldStage)
            }
            oldStage = stage;

            var div =document.getElementById('heatmapPic');
            div.style.height="700px";

        }
        else if (this.value == '1') {
            var stage = 2;
            if (oldStage >stage) {
                scale = 1/(Math.pow(1.5, oldStage - stage));
            }
            else if (oldStage == stage) {
                scale = 1;
            }

             else {
                scale = Math.pow(1.5, stage - oldStage)
            }

            oldStage = stage;

            var div =document.getElementById('heatmapPic');
            div.style.height="1000px";
        }
        else if (this.value == '2') {
            //resize to large

            var stage = 3;
            if (oldStage >stage) {
                scale = 1/(Math.pow(1.5, oldStage - stage));
            }
            else if (oldStage  == stage) {
                scale = 1;
            }

            else {
                scale = Math.pow(1.5, stage - oldStage)
            }
            oldStage = stage;

            var div =document.getElementById('heatmapPic');
            div.style.height="1500px";
        }

        //resize div
        //$("#loading_image_container")[0].style.height
        //var div = document.getElementsByClassName('heatmapPic');


        //do and draw
        var c = document.getElementsByClassName('heatmap-canvas')[0];

        var ctx = c.getContext("2d");
        var width = ctx.canvas.width;
        var height = ctx.canvas.height;

        var imageData = ctx.getImageData(0, 0, width, height);
        var copiedCanvas = document.createElement("canvas");
        copiedCanvas.width = width;
        copiedCanvas.height = height;
        copiedCanvas.getContext("2d").putImageData(imageData, 0, 0);

        ctx.canvas.width = ctx.canvas.width*scale;
        ctx.canvas.height = ctx.canvas.height*scale;



        ctx.save();
        ctx.scale(scale,scale);
        ctx.clearRect(0, 0, width, height);
        ctx.drawImage(copiedCanvas, 0, 0);



    });
});
