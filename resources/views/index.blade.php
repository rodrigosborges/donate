<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no maximum-scale=1.0, user-scalable=0">
    	<meta name="description" content="Genesis é uma empresa de renome no litoral norte especializada em todo tipo de solução visual para a sua empresa">

    	<title>Donate</title>

    	<!-- <link rel="shortcut icon" href="#" /> -->

		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    	<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    	<link rel="stylesheet" type="text/css" href="{{asset('css/ekko-lightbox.css')}}">
	</head>
		<body id="page-top">
			<!-- MENU LATERAL RESPONSIVO -->
	        <div id="mySidenav" class="sidenav text-center">
				<a class="fonte-branca link-limpo closebtn" href="javascript:void(0)" onclick="closeNav()">&times;</a>
				<hr class="linha-branca">
				<br>
	        	<form id="form-login" method="POST" action="{{ route('login') }}">
	        	@csrf
	        	{{Auth::user()}}
				  <div class="form-group text-center">
				    <label for="formGroupExampleInput" class="fonte-branca">{{ __('E-Mail') }}</label>
				    <input type="text" class="form-control" name="email" id="formGroupExampleInput" placeholder="Informe o seu e-mail">
				    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
				  </div>
				  <div class="form-group text-center">
				    <label for="formGroupExampleInput2" class="fonte-branca">{{ __('Senha') }}</label>
				    <input type="password" class="form-control" name="password" id="formGroupExampleInput2" placeholder="Informe a sua senha">
				    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
				  </div>
				  <div class="form-group row text-center">
                        <div class="form-check text-center">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label fonte-branca" for="remember">
                                {{ __('Lembrar') }}
                            </label>
                        </div>
                   </div>
				  <div class="form-group text-center">
				    <input type="submit" class="form-control btn btn-success" value="Entrar">
				    <a href="{{ route('password.request') }}"> {{ __('Esqueci minha senha') }}</a>
				  </div>
				</form>
			</div>
			<!-- ######################## -->
			<div id="wrapper">
			<!-- #### BARRA DE NAVEGAÇÃO #### -->
				<nav class="navbar navbar-expand-lg bg-transparent text-uppercase" id="mainNav">
			      	<div class="container">
				        <span id="logo" class="js-scroll-trigger" href="#page-top">Donate</span>
				        <img onclick="openNav()" id="botao-menu-mobile" src="img/icones/menu-branco.png" class="navbar-toggler navbar-toggler-right text-uppercase rounded" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
				        <div class="collapse navbar-collapse" id="navbar-horizontal">
				          <ul class="navbar-nav ml-auto">
				            <li class="nav-item mx-0 mx-lg-1">
				              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('register') }}">Registrar</a>
				            </li>
				            <li class="nav-item mx-0 mx-lg-1">
				              <a onclick="openNav()" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#">Login</a>
				            </li>
				          </ul>
				        </div>
			      	</div>
		    	</nav>
			    <!-- ############################### -->
		    	<!-- #### HEADER #### -->
			    <header>
			      	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				        <div class="carousel-inner" role="listbox">
				          <div class="carousel-item active" style="background-image: url('img/slides/01.jpg')">
				          	<div class="carousel-caption">
				              	<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>
				              	<p>This is a description for the first slide.</p>
				            </div>
				          </div>
				      	</div>
			     	</div>
			    </header>
			    <!-- ################### -->

			    <!-- #### SOBRE #### -->
			   <!--  <section id="sobre">
			      <div class="container">
					<div class="mb-0 text-center">
						<h2 class="text-center text-uppercase margem-titulo">Sobre a nossa empresa</h2>
						<div class="row">
						  	<div class="col-md-12">
								<p class="fonte-grande">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					  		</div>
					  	</div>
				  		<div class="row">
							  <div class="col-md-12">
								<p class="text-justify espacamento-lateral espacamento-inferior">Fusce ultrices ultricies tempor. Aenean semper arcu vitae lectus ornare posuere. Nulla vehicula tellus vitae ligula aliquet tempus non ac diam. Ut feugiat tempor velit, eget accumsan augue rutrum a. Vivamus tempor faucibus arcu, in fermentum ante suscipit vitae. Aenean iaculis cursus enim, a laoreet mauris sagittis ultricies. Fusce ultrices ultricies tempor. Aenean semper arcu vitae lectus ornare posuere. Nulla vehicula tellus vitae ligula aliquet tempus non ac diam. Ut feugiat tempor velit, eget accumsan augue rutrum a. Vivamus tempor faucibus arcu, in fermentum ante suscipit vitae. Aenean iaculis cursus enim, a laoreet mauris sagittis e.</p>
							  </div>
				  		</div>
				  	</div>
				  </div>
			    </section> -->
			    <!-- ######################### -->

			    <!-- #### SOBRE #### -->
			    <section id="servicos">
			    	<hr class="linha-branca">
			      	<div class="container">
			      		<div class="mb-0 text-center">
							<h2 class="text-center text-uppercase fonte-branca margem-titulo">Lorem Ipsum</h2>
							<div class="row espacamento-inferior">
								<div class="col-md-3 espacamento-lateral bloco-servico margem-direita">
									<img class="espacamento-inferior" src="img/icones/settings.png">
									<h3 class="fonte-branca"><b>Lorem Ipsum</b></h3>
									<p class="fonte-branca text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="col-md-3 espacamento-lateral bloco-servico margem-direita">
									<img class="espacamento-inferior" src="img/icones/users.png">
									<h3 class="fonte-branca"><b>Lorem Ipsum</b></h3>
									<p class="fonte-branca text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="col-md-3 espacamento-lateral bloco-servico">
									<img class="espacamento-inferior" src="img/icones/bar-chart.png">
									<h3 class="fonte-branca"><b>Lorem Ipsum</b></h3>
									<p class="fonte-branca text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
							</div>
							<!-- <div class="row espacamento-inferior">
								<div class="col-md-3 espacamento-lateral bloco-servico margem-direita">
									<img class="espacamento-inferior" src="img/icones/settings.png">
									<h3 class="fonte-branca"><b>Lorem Ipsum</b></h3>
									<p class="fonte-branca text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="col-md-3 espacamento-lateral bloco-servico margem-direita">
									<img class="espacamento-inferior" src="img/icones/users.png">
									<h3 class="fonte-branca"><b>Lorem Ipsum</b></h3>
									<p class="fonte-branca text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="col-md-3 espacamento-lateral bloco-servico">
									<img class="espacamento-inferior" src="img/icones/bar-chart.png">
									<h3 class="fonte-branca"><b>Lorem Ipsum</b></h3>
									<p class="fonte-branca text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
							</div> -->
				  		</div>
					</div>
			    </section>
			    <!-- ######################### -->

			    <!-- #### SOBRE #### -->
			    <section id="galeria">
			    	<hr class="linha-branca">
	                <div class="row margem-padding-0">
	                    <a href="img/galeria/01.jpg?image=01" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4 margem-padding-0"  data-max-width="900">
	                        <img src="img/galeria/01.jpg?image=01" class="img-fluid">
	                    </a>
	                    <a href="img/galeria/02.jpg?image=02" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4 margem-padding-0" data-max-width="900">
	                        <img src="img/galeria/02.jpg?image=02" class="img-fluid">
	                    </a>
	                    <a href="img/galeria/03.jpg?image=03" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4 margem-padding-0" data-max-width="900">
	                        <img src="img/galeria/03.jpg?image=03" class="img-fluid">
	                    </a>
	                </div>
	                <!-- <div class="row margem-padding-0">
	                    <a href="img/galeria/04.jpg?image=01" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4 margem-padding-0" data-max-width="900">
	                        <img src="img/galeria/04.jpg?image=04" class="img-fluid">
	                    </a>
	                    <a href="img/galeria/05.jpg?image=05" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4 margem-padding-0" data-max-width="900">
	                        <img src="img/galeria/05.jpg?image=05" class="img-fluid">
	                    </a>
	                    <a href="img/galeria/06.jpg?image=06" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4 margem-padding-0" data-max-width="900">
	                        <img src="img/galeria/06.jpg?image=06" class="img-fluid">
	                    </a>
	                </div>   --> 
			    </section>

			      	
			    <!-- ######################### -->

			    <!-- CONTATO -->
			 <!--    <section id="contato">
			      <div class="container"> -->
			        <!-- <h2 class="text-center text-uppercase margem-titulo">Fale Conosco</h2>
			        <div class="row">
			          <div class="col-lg-8 mx-auto"> -->
			            <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
			            <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
			           <!--  <form name="sentMessage" id="contactForm">
			              <div class="form-group">
			                <input required type="text" name="name" id="name" class="form-control form-control-lg entrada-formulario" placeholder="Nome...">
			              </div>
			              <div class="form-group">
			                <input required type="email" name="email" id="email" class="form-control form-control-lg entrada-formulario" placeholder="E-mail...">
			              </div>
			              <div class="form-group">
			                <input required type="text" name="phone" id="phone" class="form-control form-control-lg entrada-formulario" placeholder="Telefone...">
			              </div>
			              <div class="form-group">
			                <textarea required class="form-control form-control-lg entrada-formulario" name="message" id="message" placeholder="Deixe uma mensagem para nós..." rows="5px"></textarea>
			              </div>
			              <div id="success"></div>
			              <div class="form-group text-center">
			                <input type="submit" id="sendMessageButton" class="btn btn-primary" value="ENVIAR">
			              </div>
			            </form>
			          </div>
			        </div>
	 -->
			       <!--  <div class="text-center" id="redes-sociais"> -->
			        	<!-- <h2 class="text-center text-uppercase margem-titulo">Redes Sociais</h2> -->
			           <!--  <ul class="list-inline">
			              	<li class="list-inline-item">
				                <a target="blank" class="text-center" href="https://www.facebook.com/genesispainel">
				                  <img class="icones-redes-sociais" src="img/icones/facebook.png"/>
				                </a>
			              	</li>
			              	<li class="list-inline-item espacamento-lateral">
				                <a target="blank" class="text-center" href="https://www.instagram.com/genesispainel">
				                   <img class="icones-redes-sociais" src="img/icones/instagram.png"/>
				                </a>
			              	</li>
						   	<li class="list-inline-item">
				                <a target="blank" class="text-center" href="https://api.whatsapp.com/send?phone=5512981155066&text=">
				                   <img class="icones-redes-sociais" src="img/icones/whatsapp.png"/>
				                </a>
			              	</li>
			            </ul>    
					</div>

					</div> -->

			  <!--   </section> -->
				<!-- ######################### -->

				<!-- MAPA -->
				<div id="mapa">
					<hr class="linha-branca">
					<iframe 
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7310.817040816829!2d-45.423754974972944!3d-23.62553663860407!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94cd63740700fb0b%3A0x1432082b4e1098d5!2sGenesis!5e0!3m2!1spt-BR!2sbr!4v1527705188093" width="100%" height="510px" frameborder="0" allowfullscreen>		
					</iframe>
					<hr class="linha-branca">
				</div>
	        	<!-- ######################### -->
	    

			    <!-- Footer -->
			    <footer id="footer" class="footer">
			      <div class="container">
			      	<div class="row">
					</div>
			      </div>
			    </footer>

			    <div id="desenvolvedor" class="text-center">
			    	<div class="container">
			    		<span class="texto-pequeno fonte-branca text-left">&copy; <span class="fonte-branca" id="ano"></span> - Donate -Todos os direitos reservados</span>
			    	</div>
			    </div>

			    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
			    <a id="subirTopo" href="#page-top">
					<img src="img/icones/arrow-up.png">
				</a>
			</div>

		<!-- #### JS #### -->
		<!-- Bootstrap core JavaScript -->
	    <script src="{{asset('js/jquery.min.js')}}"></script>
	    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
	    <script src="{{asset('js/popper.min.js')}}"></script>
	    
	    <!--Plugin JavaScript -->
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/ekko-lightbox.min.js')}}"></script>
            
	    <!-- Custom scripts for this template -->       
	    <script src="{{asset('js/custom.js')}}"></script>

		<!-- ############ -->

		</body>
</html>