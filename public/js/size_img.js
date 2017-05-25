//1 is small
//2 is midium
//3 is large

$(document).ready(function() {
     var oldStage = 2;

    $('input:radio[name=size]').change(function() {
        var image = document.getElementById(img);

        if (this.value == '1/2') {
            var stage = 1;
            if (oldStage >stage) {
                image.style.width = "50%";
                image.style.height = "50%";
            } else if (oldStage == stage) {
                image.style.width = "100%";
                image.style.height = "100%";
            }
            else
            {
                image.style.width = "200%";
                image.style.height = "200%";
            }
            oldStage = stage;



        }
        else if (this.value == '1') {
            var stage = 2;
            if (oldStage >stage) {
                image.style.width = "50%";
                image.style.height = "50%";
            } else if (oldStage == stage) {
                image.style.width = "100%";
                image.style.height = "100%";
            }
            else
            {
                image.style.width = "200%";
                image.style.height = "200%";
            }
            oldStage = stage;
        }
        else if (this.value == '2') {
            //resize to large
            var stage = 3;
            if (oldStage >stage) {
                image.style.width = "50%";
                image.style.height = "50%";
            } else if (oldStage == stage) {
                image.style.width = "100%";
                image.style.height = "100%";
            }
            else
            {
                image.style.width = "200%";
                image.style.height = "200%";
            }
            oldStage = stage;
        }

        //resize div
        //$("#loading_image_container").style.height
        //var div = document.getElementsByClassName('heatmapPic');





    });
});
