<html>
<head>
	<meta charset="UTF-8">
	<title></title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/style.min.css">
	

	<!-- FACEBOOK -->
	<meta property="og:url"                content="" />
	<meta property="og:type"               content="" />
	<meta property="og:title"              content="" />
	<meta property="og:description"        content="" />
	<meta property="og:image"              content="" />

</head>
<body>

<?php 
	if(!isset($_COOKIE['firsttime'])) {
  	setcookie("firsttime", "no", time() + (10 * 1), "/"); // 1 dia
	}
?>

	<div id="ContainerNatal" class="<?php if(isset($_COOKIE['firsttime']) && $_COOKIE['firsttime'] == 'no'){ echo 'is-closed'; } ?>">
    <canvas id="pixie"></canvas>

    <a href="#/" id="CloseNatal"></a>

    <div class="Arte">
    	<img src="assets/img/kv.png" alt="" id="kv">
    	<img src="assets/img/logo.svg" alt="" id="Logo">
    </div>

    <div class="Glitters">
    	<img src="assets/img/g1.png" alt="" class="glitter--center">
	    <img src="assets/img/g2.png" alt="" class="glitter--center">
	    <img src="assets/img/g3.png" alt="" class="glitter--center">
	    <img src="assets/img/g4.png" alt="" class="glitter--left glitter--top">
	    <img src="assets/img/g5.png" alt="" class="glitter--bottom glitter--left">
	    <img src="assets/img/g6.png" alt="" class="glitter--bottom glitter--right">
	    <img src="assets/img/g7.png" alt="" class="glitter g7">
	    <img src="assets/img/g8.png" alt="" class="glitter--right g8">
	    <img src="assets/img/g9.png" alt="" class="gglitter-bottom glitter--top glitter--right">
    </div>
	</div>

	
	<script src="assets/js/jquery.js"></script>

	<script>
		
		var WIDTH = window.innerWidth,
			HEIGHT = window.innerHeight,
			MAX_PARTICLES = 400,
			DRAW_INTERVAL = 30,
			container = document.querySelector('#ContainerNatal'),
			canvas = document.querySelector('#pixie'),
			context = canvas.getContext('2d'),
			gradient = null,
			pixies = new Array();

		function setDimensions(e) {
			WIDTH = window.innerWidth;
			HEIGHT = window.innerHeight;
			container.style.width = WIDTH+'px';
			container.style.height = HEIGHT+'px';
			canvas.width = WIDTH;
			canvas.height = HEIGHT;
		}
		setDimensions();
		window.addEventListener('resize', setDimensions);

		function Circle() {
			this.settings = {ttl:8000, xmax:5, ymax:2, rmax:10, rt:1, xdef:960, ydef:540, xdrift:4, ydrift: 4, random:true, blink:true};

			this.reset = function() {
				this.x = (this.settings.random ? WIDTH*Math.random() : this.settings.xdef);
				this.y = (this.settings.random ? HEIGHT*Math.random() : this.settings.ydef);
				this.r = ((this.settings.rmax-1)*Math.random()) + 1;
				this.dx = (Math.random()*this.settings.xmax) * (Math.random() < .5 ? -1 : 1);
				this.dy = (Math.random()*this.settings.ymax) * (Math.random() < .5 ? -1 : 1);
				this.hl = (this.settings.ttl/DRAW_INTERVAL)*(this.r/this.settings.rmax);
				this.rt = Math.random()*this.hl;
				this.settings.rt = Math.random()+1;
				this.stop = Math.random()*.2+.4;
				this.settings.xdrift *= Math.random() * (Math.random() < .5 ? -1 : 1);
				this.settings.ydrift *= Math.random() * (Math.random() < .5 ? -1 : 1);
			}

			this.fade = function() {
				this.rt += this.settings.rt;
			}

			this.draw = function() {
				if(this.settings.blink && (this.rt <= 0 || this.rt >= this.hl)) {
					this.settings.rt = this.settings.rt*-1;
				} else if(this.rt >= this.hl) {
					this.reset();
				}

				var newo = 1-(this.rt/this.hl);
				context.beginPath();
				context.arc(this.x, this.y, this.r, 0, Math.PI*2, true);
				context.closePath();

				var cr = this.r*newo;
				gradient = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, (cr <= 0 ? 1 : cr));
				gradient.addColorStop(0.0, 'rgba(255,255,255,'+newo+')');
				gradient.addColorStop(this.stop, 'rgba(255,220,20,'+(newo*.6)+')');
				gradient.addColorStop(1.0, 'rgba(234,220,20,0)');
				context.fillStyle = gradient;
				context.fill();
			}

			this.move = function() {
				this.x += (this.rt/this.hl)*this.dx;
				this.y += (this.rt/this.hl)*this.dy;
				if(this.x > WIDTH || this.x < 0) this.dx *= -1;
				if(this.y > HEIGHT || this.y < 0) this.dy *= -1;
			}

			this.getX = function() { return this.x; }
			this.getY = function() { return this.y; }
		}

		for (var i = 0; i < MAX_PARTICLES; i++) {
			pixies.push(new Circle());
			pixies[i].reset();
		}

		function draw() {
			context.clearRect(0, 0, WIDTH, HEIGHT);
			for(var i = 0; i < pixies.length; i++) {
				pixies[i].fade();
				pixies[i].move();
				pixies[i].draw();
			}
		}
		setInterval(draw, DRAW_INTERVAL);

		$(document).ready(function(){
			var $mountains = $('#mountains');
			var $grass = $('#grass');
			var $container = $('#ContainerNatal');
			$container.mousedown(function(ev){
				var ox = ev.clientX;
				var om = parseInt($mountains.css('background-position').substr(0, $mountains.css('background-position').search(' ')));
				var og = parseInt($grass.css('background-position').substr(0, $grass.css('background-position').search(' ')));
				$container.mousemove(function(e){
					$mountains.css('background-position', om+((e.clientX-ox)/10)+'px 0px');
					$grass.css('background-position', og+((e.clientX-ox)/4)+'px 10px');
				});
				$container.mouseup(function(){
					$container.unbind('mousemove');
					$container.unbind('mouseup');
				});
			});

			$('#CloseNatal').on('click', function(e){
				e.preventDefault();

				$('#ContainerNatal').addClass('is-closed');
			})
		});
	
	</script>
</body>
</html>