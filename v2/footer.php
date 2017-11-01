<div class="offers-full is-hidden">
<div class="offers-top">
	<ul class="icons">
		
		<?php 
			  						
			//BUSCA CATEGORIAS COM OFERTAS ATIVAS
			$resCat = $SQL->executa(' SELECT 	DISTINCT c.categoria,c.alias,c.class
												FROM categorias c 
												INNER JOIN ofertas o 
												ON (c.alias=o.categoria)
												WHERE 
												(o.preco_vista<>"" or o.total_prazo<>"" or o.entrada<>"") and 
												(o.imagem_p NOT LIKE "%sem_imagem%") 
												and "'.date('Y-m-d').'" <= o.termino 
												and c.status=1 ORDER BY 
												case c.id 
													when 22 then 1
													when 21 then 2
													when 2  then 3
													when 3  then 4
													when 11 then 5
													when 4	then 6
													when 7	then 7
													else 8
												end,
											    c.categoria LIMIT 15');
			if($resCat->num_rows>0){

				//echo '<li class="natal"><a href="http://www.condor.com.br/cestasdenatal" target="_blank">Cestas de Natal</a></li>';

				while($rowCat = $resCat->fetch_object()){
	
					if($rowCat->class!='') $classIcone = $rowCat->class; else $classIcone = 'tv-offer';
					echo '<li class="'.$classIcone.'">
							<a href="'.$URLSITE.'/ofertas/'.$tabloid_alias.'/'.$rowCat->alias.'">'.utf8_encode($rowCat->categoria).'</a>
						  </li>';

				}
			}			
			
		 ?>
		
	</ul> <!-- icons -->
</div> <!-- offers-top -->

<div class="offers-bottom">
	<span>fechar</span>
	<button type="button"></button>
</div> <!-- offers-bottom -->			
</div>



<section class="site-map min">
<div class="site-map-title">
	<h3>Mapa do site</h3>
</div>
<div class="site-map-content">
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<h4><a href="/">O Condor</a></h4>
				<ul>
					<li><a href="<?=$URLSITE?>/institucional/nossa_historia">Nossa História</a></li>
					<li><a href="<?=$URLSITE?>/institucional/nossa_estrutura">Nossa Estrutura</a></li>
					<li><a href="<?=$URLSITE?>/lojas">Nossas Lojas</a></li>
					<li><a href="<?=$URLSITE?>/institucional/premios">Prêmios</a></li>
					<li><a href="<?=$URLSITE?>/institucional/o_condor_e_seu_fundador">Condor e Seu Fundador</a></li>
					<li><a href="<?=$URLSITE?>/institucional/esta_nascendo_o_instituto_joanir_zonta">Instituto Joanir Zonta</a></li>
					<li><a href="<?=$URLSITE?>/imprensa/noticias">Imprensa</a></li>
					<li><a href="<?=$URLSITE?>/40anos40carros">Promoção 40 Anos, 40 Carros</a></li>
				</ul>
				<ul>
					<li><a href="<?=$URLSITE?>/acoes_condor">Ações Condor</a></li>
					<li><a href="<?=$URLSITE?>/acoes_condor/universidade_corporativa/universidade_corporativa_condor">Universidade Corporativa</a></li>
					<li><a href="<?=$URLSITE?>/acoes_condor/sustentabilidade_condor/sustentabilidade/sustentabilidade">Sustentabilidade</a></li>
					<li><a href="<?=$URLSITE?>/acoes_condor/cultura_e_lazer/cultura_e_lazer">Cultura e Lazer</a></li>
				</ul>
				<ul>
					<li><a href="<?=$URLSITE?>/servicos_financeiros_condor/">Serviços Financeiros</a></li>
					<li><a href="<?=$URLSITE?>/servicos_financeiros_condor/megafacilidades_condor/megafacilidades_condor">Megafacilidades Condor</a></li>
					<li><a href="<?=$URLSITE?>/servicos_financeiros_condor/cartao_condor_mastercard/cartao_condor_mastercard">Cartão Condor Mastercard®</a></li>
					<li><a href="<?=$URLSITE?>/servicos_financeiros_condor/carne_condor/carne_condor">Carnê Condor</a></li>
					<li><a href="<?=$URLSITE?>/servicos_financeiros_condor/formas_de_pagamento/a_vista">Formas de Pagamento</a></li>
				</ul>
				<ul>
					<li><a href="<?=$URLSITE?>/para_sua_empresa">Para sua empresa</a></li>
					<li><a href="<?=$URLSITE?>/para_sua_empresa/cartao_condor_card_mais_alimentacao">Cartão Condor Mais Alimentação</a></li>
					<li><a href="<?=$URLSITE?>/para_sua_empresa/cartao_condor_card_mais_convenio">Cartão Condor Mais Convênio</a></li>
					<li><a href="<?=$URLSITE?>/para_sua_empresa/cartao_condor_card_mais_empresarial">Cartão Condor Mais Empresarial</a></li>
					<li><a href="<?=$URLSITE?>/para_sua_empresa/cartao_presente">Cartão Presente</a></li>
					<li><a href="<?=$URLSITE?>/para_sua_empresa/cesta_de_natal/">Cestas de Natal</a></li>
				</ul>
			</div> <!-- O Condor -->

			<div class="col-md-2">
				<h4><a href="/ofertas">Ofertas</a></h4>
				<ul>
					<?php
			  						
  						//EXIBE ANTES DA PUBLICACAO PARA ADMIN 
  						if(!isset($_SESSION['s_admin_id'])){ $condTabAdmin = ' and "'.date('Y-m-d').'" >= o.inicio '; }

  						//BUSCA TABLOIDES
  						$selected = 0;
  						$stringTabAtivo = 'SELECT 	DISTINCT t.tabloide,
											t.alias as alias,
											t.id as id
											FROM tabloides t 
											INNER JOIN ofertas o 
											ON (t.id=o.id_tabloide)
											WHERE 
											(o.preco_vista<>"" or o.total_prazo<>"" or o.entrada<>"") and 
											(o.imagem_p NOT LIKE "%sem_imagem%") 
											and "'.date('Y-m-d').'" <= o.termino '.$condTabAdmin.'
											and t.status=1 GROUP BY categoria LIMIT 12';
  						$resTab 	= $SQL->executa($stringTabAtivo);
  						if($resTab->num_rows>0){
	  						
	  						while($rowTab = $resTab->fetch_object()){
		  						
		  						if($selected==0){ $selectedClass = 'selected'; $selected=1; }else{ $selectedClass = ''; }
		  						echo '<li><a href="'.$URLSITE.'/ofertas/'.$tabloid_alias.'/'.$rowCat->alias.'">'.utf8_encode($rowTab->tabloide).'</a></li>';
		  						
		  					}
  						}	
  											  						
  					?>
<!-- 					<li><a href="/#ofertas-da-tv">ofertas do dia</a></li> -->
				</ul>
			</div> <!-- Ofertas -->
		</div> <!-- row -->

		<div class="row">
			<div class="col-md-12">
				<h4><a href="<?=$URLSITE?>/receitas">Receitas</a></h4>
			</div> <!-- Receitas -->
		</div> <!--  row -->

		<div class="row">
			<div class="col-md-12">
				<h4><a href="<?=$URLSITE?>/cadastro">Cadastro</a></h4>
			</div> <!-- Cadastro -->
		</div> <!-- row -->

		<div class="row">
			<div class="col-md-12">
				<h4><a href="/sac">Contato</a></h4>
				<ul>
					<li><a href="<?=$URLSITE?>/sac">SAC</li></a>
				</ul>
				<ul>
					<li><a href="<?=$URLSITE?>/fornecedores">Fornecedores</li></a>
				</ul>
				<ul>
					<li><a href="<?=$URLSITE?>/trabalhe-conosco">Trabalhe Conosco</li></a>
				</ul>
			</div>
		</div> <!-- row -->
	</div> <!-- container -->
</div> <!-- site-map-content -->				
</section> <!-- site-map -->

<footer>

<div class="footer-top">
	<div id="cadastro">
		<div class="input-wrapper">
			<a href="<?=$URLSITE?>/cadastro#c">
				<button class="button xs-small white">RECEBA OFERTAS EM SEU E-MAIL</button>
			</a>
			<!-- <input id="email_newsletter" type="text" class="input input-small white" placeholder="RECEBA OFERTAS EM SEU E-MAIL">
			<button id="enviaNews" type="button" class="button-input send"></button> -->
		</div><!-- input wrapper -->
	</div>
	<div class="footer-moda">
		<span>conheça nosso blog</span>
		<img class="ico-bracket" src="<?=$URLSITE?>/img/icons/bracket.svg" alt="">
		<a href="http://modacondor.com.br/" target="_blank"><img class="moda" src="<?=$URLSITE?>/img/icons/social/moda.png" alt=""></a>
	</div>
</div> <!-- footer top -->
<div class="footer-bottom">
	<div class="container">
		<img class="logo-footer" src="<?=$URLSITE?>/img/logo-condor.svg" alt="Hipermercado Condor">
		
		<div class="footer-social">
			<span>siga-nos</span>
			<img class="ico-bracket" src="<?=$URLSITE?>/img/icons/bracket.svg" alt="">
			<ul class="social">
				<a href="https://pt-br.facebook.com/RedeCondor" target="_blank"><li class="ico facebook"></li></a>
				<a href="https://www.youtube.com/user/redecondor" target="_blank"><li class="ico youtube"></li></a>
				<a href="https://instagram.com/redecondor" target="_blank"><li class="ico instagram"></li></a>
				<!-- <a href="https://twitter.com/redecondor" target="_blank"><li class="ico twitter"></li></a> -->
				<!-- <a href="https://www.pinterest.com/redecondor/" target="_blank"><li class="ico pinterest"></li></a> -->
			</ul>
		</div>
		

		<div class="legal-text">
			<a href="#/">Termos de uso</a>
			<span>
				© Condor Supermercados 2008-2015.
			</span>
			<div>Todos os direitos reservados.</div>
		</div> <!-- legal text -->
		<div class="contact">
			<ul>
				<li>
					<img class="ico-telephone" src="<?=$URLSITE?>/img/icons/telephone.svg" alt="">
					<span>SAC: 0800 416655</span>
				</li>
				<li>
					<img class="ico-sac" src="<?=$URLSITE?>/img/icons/sac.svg" alt="">
					<a href="mailto:contato@condor.com.br">contato@condor.com.br</a>
				</li>
			</ul>
		</div>

	</div> <!-- footer bottom -->
</div> <!-- container -->

<div class="terms-of-use">
	<div class="terms-title">
		<h5>texto legal e termos de uso</h5>
	</div>
	<div class="terms-content">
		<div class="container">
			<p>
				© Condor Supermercados 2008-2015 Todos direitos reservados. As ofertas exibidas na internet através do website condor.com.br e familiascondor.com.br são as mesmas veiculadas nos encartes impressos pelo Condor Super Center. Para solicitar alguma dessas ofertas, o cliente deverá ter em mãos os encartes originais. Não serão válidos impressos através da internet. Os produtos ofertados neste site estão de acordo com o encarte 144/15 (16/09/2015 a 27/09/2015). Caso queira obter mais informações, passe em uma das lojas do Condor Super Center. As fotos são meramente ilustrativas. Os preços referem-se a valores unitários em fotos de produtos repetidos. Todos os preços deste site estão em reais. Para que o atendimento aos nossos clientes seja cada vez melhor, não vendemos por atacado e nos reservamos o direito de limitar por cliente a quantidade de produtos anunciados. SAC: 0800 41 6655. É proibida a venda de bebidas alcoólicas para menores de 18 anos (Lei n.° 8069/90, Art. 81, inciso II, Estatuto da Criança e do Adolescente). O Ministério da Saúde informa: o aleitamento materno evita infecções e alergias e é recomendado até os 2 (dois) anos de idade ou mais. O Ministério da Saúde informa: após os 6 (seis) meses de idade continue amamentando seu filho e ofereça novos alimentos. CONDIÇÕES DE PAGAMENTO À VISTA: dinheiro, cheque (à vista mediante consulta SPC e Serasa). Cartões de débito: Cheque Eletrônico Banco 24 Horas, Maestro, Rede Shop, Visa Eletron. Cartões de crédito: para pagamento de compras à vista com cartões de crédito Visa, MasterCard®, Diners, Amex/Sollo, Condor MasterCard®, este ocorrerá na data do vencimento do cartão do cliente. Cheque pré-datado: verificar as condições na loja (exclusivamente para clientes cadastrados - valor mínimo de R$ 50,00). PAGAMENTO PARCELADO: No cartão CONDOR MASTERCARD®: mercearia, higiene, limpeza e perecíveis em até 3 vezes sem juros; têxtil, bazar e pneus em até 10 vezes sem juros; eletro em até 20 vezes sem juros. Parcelamento válido no limite do ROTATIVO para compras acima de R$ 60,00, com parcela mínima de R$ 20,00. Parcelamento com uso do MEGALIMITE apenas para compras acima de R$ 60,00 e a partir de 3 parcelas. Nos Cartões VISA, MASTERCARD®, AMERICAN EXPRESS e HIPERCARD: eletro em até 10 vezes sem juros; têxtil, bazar e pneus em até 6 vezes sem juros. Parcela mínima de R$ 20,00. CHEQUE PARCELADO (Eletro, Bazar e Têxtil): 1 entrada + 2 vezes sem juros; 2 a 6 cheques sem entrada, taxa de 2,50% a.m. (34,49% a.a.). Valor mínimo da parcela: R$ 30,00 – Exclusivamente para clientes cadastrados. Seguro de Garantia Estendida Original: pode ser parcelado nas mesmas condições do eletro desde que solicitado no momento da aquisição do produto de eletro. Para solicitações do Seguro de Garantia Estendida Original no pós-venda e de maneira isolada, pode ser parcelado em até 5 vezes no cartão de crédito. Formas de pagamento para as Megafacilidades Condor: Recarga para Celular: cartão de débito, dinheiro e no rotativo do Cartão Condor; Vale-gás: cartão de débito, dinheiro e parcelado em até 2x no Cartão Condor; Cartão-presente: cartão de débito, dinheiro e no rotativo do cartão de crédito e do Cartão Condor; Fatura do Cartão Condor: somente em dinheiro, com o limite de R$ 1.000,00 por boleto e até às 21h; Garantia Estendida e Condor Facilita: cartão de débito, dinheiro, cartão de crédito em até 5 vezes no pós-venda ou conforme parcelamento do produto adquirido. MATERIAL ESCOLAR: nos cartões CONDOR MASTERCARD®, VISA, MASTERCARD®, SENFF, ELO E HIPERCARD em até 10x sem juros para compras acima de R$ 30,00, com parcela mínima de R$ 9,00. No cartão AMERICAN EXPRESS em até 6x sem juros, para compras acima de R$ 30,00, com parcela mínima de R$ 9,00. Ofertas válidas dentro da validade dos encartes ou enquanto durarem os estoques. Para melhor atender os nossos clientes, não vendemos por atacado e reservamo-nos o direito de limitar a 12 unidades/kg por cliente a quantidade dos produtos anunciados, conforme acordo APRAS/PROCON-PR. Consultar, nas lojas, o estoque ou quantidade de produtos disponíveis. As fotos são meramente ilustrativas. Os objetos de decoração não fazem parte do preço. Os preços referem-se a valores unitários em fotos de produtos repetidos. Todos os preços deste encarte estão em reais. Fica ressalvada eventual retificação das ofertas aqui veiculadas.
			</p>
		</div> <!-- container -->
	</div>
</div>
</footer>	

<script src="<?=$URLSITE?>/js/jquery-2.1.4.min.js"></script>
<script src="<?=$URLSITE?>/js/jquery.mobile.custom.min.js"></script>
<script src="<?=$URLSITE?>/js/bootstrap.min.js"></script>
<script src="<?=$URLSITE?>/js/jquery.lazyload.min.js"></script>
<script src="<?=$URLSITE?>/js/slick.min.js"></script>
<script src="<?=$URLSITE?>/js/parallax.min.js"></script>
<script src="<?=$URLSITE?>/js/menu.js"></script>
<script src="<?=$URLSITE?>/js/bootstrap-datepicker.min.js"></script>
<script src="<?=$URLSITE?>/js/bootstrap-datepicker.pt.min.js"></script>
<script src="<?=$URLSITE?>/js/perfect-scrollbar.jquery.min.js"></script>
<script src="<?=$URLSITE?>/js/fb-favoritos.js"></script>
<script src="<?=$URLSITE?>/js/lightbox.min.js"></script>

<!-- MASK e VALID -->
<script src="/js/maskedinput.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

   $("#data").mask("99/99/9999");
   $("#telefone, #fax, #fax-comercial, #telefone_comercial").mask("(999) 9999-9999?9");
   $("#cnpj").mask("99.999.999/9999-99");
   
   //Validar de email
   $(".valida-email").blur(function(){var mail=$(this).val();if(mail!=""){var regmail=/^[\w!#$%&amp;'*+\/=?^`{|}~-]+(\.[\w!#$%&amp;'*+\/=?^`{|}~-]+)*@(([\w-]+\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;if(regmail.test(mail)){$(this).css('border-color','green')}else{$(this).css('border-color','red');return false}}});

});
</script>


<script>
$(document).ready(function(){
	
	$('#myModal').modal();
	
	<?php if($acao1=='ord'){ ?>
		var filtro = $("#<?=$valor1?>").html();
		$('#filtroSelecionado').html(filtro);
	<?php } ?>
	$('#filtroOfertas li').on('click', function(){

		var datafiltro = $(this).attr('data-filtro');
		window.location.href = datafiltro;
		
		
	});	
	
	$('#enviaNews').on('click', function(){	
		
		var email_newsletter = $("#email_newsletter").val();

		
		// Returns successful data submission message when the entered information is stored in database.
		var dataString = 'email_newsletter='+ email_newsletter;
		
		if(email_newsletter==''){
		
			alert("Informe seu e-mail.");
		
		}else{
			// AJAX Code To Submit Form.
			$.ajax({
				type: "POST",
				url: "<?=$URLSITE?>/ajax/insertNewsletter.ajax.php",
				data: dataString,
				cache: false,
				success: function(result){

					alert(result);
					
				}
			});
		}
		return false;
	
	});
	
});	

	// Facebook
	$(function() { 
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=118893334857916";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	});
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '496461870407185',
			cookie     : true, 			                        
			xfbml      : true,  
			version    : 'v2.5'
		});
	};

</script>

<script src="<?=$URLSITE?>/js/condor.js"></script>

<script>
	$(function(){
		$(document).ready(function(){
			if ( $( "#ContainerNatal" ).length ) {
		 		$('body').css('overflow', 'hidden');
			}



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
				$('body').css('overflow-y', 'auto');
			})

			setTimeout(function(){
				$('#ContainerNatal').addClass('is-closed');
				$('body').css('overflow-y', 'auto');
			}, 10000);
		});
	})
</script>

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
				gradient.addColorStop(this.stop, 'rgba(234,220,20,'+(newo*.6)+')');
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
	
	</script>