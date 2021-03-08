<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mesón Turístico Restaurant</title>

        <!-- Fonts -->
       <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">-->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet">
        <link href="{{ asset('css/templatemo-style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">

        <!-- Styles -->

        </style>
    </head>
    <body>


     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">

               <span class="spinner-rotate"></span>

          </div>
     </section>

      <!-- MENU -->
      <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="nav-item dropdown">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                   <!-- <a href="index.html" class="navbar-brand">Comedor <span>.</span> Turistico</a>-->
                   <a href="#home"><div class="navbar-brand"></a></div>
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse wow fadeInDown" data-wow-delay="0.6s">
                    <ul class="nav navbar-nav navbar-nav-first">
                         <li><a href="#home" class="smoothScroll">Inicio</a></li>
                         <li><a href="#about" class="smoothScroll">Nosotros</a></li>
                         <li><a href="#footer" class="smoothScroll">Contactos</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                         <li><a href="{{ route('login') }}">Ingresar</a></li>
                         <li><a href="{{ route('register') }}">Registro</a></li>
                    </ul>
               </div>

          </div>
     </section>

      <!-- HOME -->
      <section id="home" class="slider" data-stellar-background-ratio="0.5">
          <div class="row">

                    <div class="owl-carousel owl-theme">
                         <div class="item item-first">
                              <div class="caption">
                                   <div class="container">
                                            <div class="row">
                                                    <div class="col-md-3">

                                                        </div>
                                                            <div class="col-md-6 text-center fadeInDownA">
                                                            </div>
                                                            <div class="col-md-3">
                                                        </div>
                                            </div>
                                            <div class="row">
                                                    <div class="col-md-3">

                                                        </div>
                                                            <div class="col-md-6 text-center wow fadeInUp" data-wow-delay="0.2s">
                                                                <img src="{{URL::asset('images/logoini.png')}}"  />
                                                            </div>
                                                            <div class="col-md-3">
                                                        </div>
                                            </div>
                                            <div class="row justify-content-right">
                                                     <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-10 text-center wow flash2" data-wow-delay="0.4s">
                                                    <h7 >Una experiencia para tu paladar...</h7>
                                                    </div>
                                                    <div class="col-md-1">
                                                   </div>
                                            </div>
                                    </div>
                                </div>
                         </div>
                    </div>
            </div>
     </section>

       <!-- ABOUT -->
       <section id="about" class="sliderAbout" data-stellar-background-ratio="0.5">
          <div class="row">
                         <div class="itemA item-firstA">
                              <div class="captionA">
                                   <div class="container">
                                            <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="about-info">
                                                            <div class="section-title wow fadeInUp" data-wow-delay="0.2s">
                                                                <h11>Nosotros</h11>
                                                            </div>
                                                                <div class="row-md-12">
                                                                    <div class="product">
                                                                        <div class="card_v col-md-6 wow fadeInUp card-mision" data-wow-delay="0.4s">
                                                                            <h10>Misión</h10>
                                                                                <p class="justify">Satisfacer las necesidades gastronómicas de nuestros clientes, ofreciendo alimentos y servicios con la más alta calidad, donde se sobrepasen las expectativas de nuestros clientes.</p>
                                                                                <p>&nbsp;</p>

                                                                        </div>
                                                                    </div>
                                                                    <div class="product">
                                                                        <div class="card_v col-md-6 wow fadeInUp card-vision" data-wow-delay="0.4s">
                                                                            <h10>Visión</h10>
                                                                                <p class="justify">Ser uno de los mejores restaurantes de comida nacional, capaz de desarrollar en cada uno de nuestros colaboradores su capacidad creativa a favor del cliente. Lograr una empresa altamente productiva, innovadora, competitiva y dedicada,  para la satisfacción plena de nuestros clientes.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

     </section>

     <footer id="footer" data-stellar-background-ratio="0.5">
          <div class="container">
               <div class="row">

                    <div class="col-md-4 col-sm-8">
                         <div class="footer-info footer-open-contact">
                              <div class="section-title">
                                   <h12 class="wow fadeInUp" data-wow-delay="0.2s">Contacto</h12>
                              </div>
                              <address class="wow fadeInUp" data-wow-delay="0.4s">
                                   <p>+507 6615 5471</p>
                              </address>
                         </div>
                    </div>
                    <div class="col-md-4 col-sm-8">
                         <div class="footer-info footer-open-hour">
                              <div class="section-title">
                                   <h12 class="wow fadeInUp" data-wow-delay="0.2s">Abierto todos los días</h12>
                              </div>
                              <div class="wow fadeInUp" data-wow-delay="0.4s">
                                   <div>
                                        <p>Desde las 8:00 AM - 4:30 PM</p>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-8">
                        <div class="footer-info footer-open-media">
                              <div class="section-title">
                                   <h12 class="wow fadeInUp" data-wow-delay="0.2s" style="color:white">Redes Sociales</h12>
                                   <ul class="wow fadeInUp social-icon" data-wow-delay="0.4s">
                                    <li><a href="https://www.instagram.com/restaurant_meson_turistico/"  class="fa fa-instagram" target="_blank"></a></li>
                                    <p>Mesón Turístico Restaurant &copy; 2020 </p>
                                   </ul>
                              </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-8">
                         <div class="footer-info footer-infomap">
                              <div class="section-title">
                                   <h12 class="wow fadeInUp" data-wow-delay="0.2s" style="color:white">Ubícanos</h12>
                              </div>
                            <div id="google-map" class="wow fadeInUp" data-wow-delay="0.4s">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3939.5274776435413!2d-79.3640070387716!3d9.10673642920704!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x9345fab9b8d4c158!2zTWVzw7NuIHR1csOtc3RpY28!5e0!3m2!1ses!2sve!4v1610297131017!5m2!1ses!2sve" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                         </div>
                    </div>
               </div>
          </div>
     </footer>

        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
        <script src="{{ asset('js/wow.min.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('js/smoothscroll.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>

    </body>
</html>
