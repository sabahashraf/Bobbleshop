 function init() {
        var canvas = document.getElementById('canvas');
        var stage = new createjs.Stage(canvas);

        img = new Image();
        img.src = 'images/custom_canvas.jpg';
        img.onload = function(event) {
            var data = {
                images: [img],
                frames: {width:220, height:470, count: 6, regX:110, regY:235},
                animations: {
                    'toggle': [0, 5],
                }
            }
            var spritesheet = new createjs.SpriteSheet(data);
            var animation = new createjs.Sprite(spritesheet, 'toggle');
            animation.x = canvas.width/2;
            animation.y = canvas.height/2;

            stage.addChild(animation);
            createjs.Ticker.addEventListener("tick", update);
            createjs.Ticker.setFPS(1);
            function update(event) {
                stage.update();
            }
        }

    }
	
	function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "gethint.php?q=" + str, true);
        xmlhttp.send();
    }
}