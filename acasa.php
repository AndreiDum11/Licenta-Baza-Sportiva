<?php

include("admin\database.php");

session_start();

$user_id = $_SESSION['user_id'] ?? '';



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DC SPORT</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' >
        <link rel="stylesheet" href="css/style1.css">
        <link rel="icon" type="image/png" href="images/fotbal_icon.png"/>
    </head>
   
    
   
    <body >
    
        <section class="header" >
            <a href="acasa.php" class="logo"> <i class='bx bx-basketball'></i>DC Sports</a>
            <nav class="navbar">
                <a class="nav-link click-scroll" href="#section_1">Acasa</a>
                <a class="nav-link click-scroll" href="#section_2">Despre Noi</a>
                <a class="nav-link click-scroll" href="#section_3">Facilități</a>
                <a class="nav-link click-scroll" href="#section_4">Evenimente</a>
                <?php if ($user_id): ?>
                     <a href="contact.php?user_id=<?= $user_id; ?>">Contact</a>
                     <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="Page_Log_In.php">Autentificare</a>
                <?php endif; ?>
                

            </nav>
            <div id="btn-meniu" class="fas fa-bars"></div>    
        </section>
        <section class="home" id="section_1">
            <div class="swiper home-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide slide" style="background:url(images/home-slide-1.jpg) no-repeat">
                        <div class="content">
                            <span>Bine ai venit la DCSports!</span>
                            <h3>Sportul reprezintă vigoarea vitală a umanităţii.</h3>
                            <a href="#section_2" class="btn">Descoperă mai multe</a>
                        </div>
                    </div>
                    <div class="swiper-slide slide" style="background:url(images/home-slide-2.jpg) no-repeat">
                        <div class="content">
                            <span>Alege dintre ofertele noastre!</span>
                            <h3>Baza noastră sportivă oferă o gamă variată de activități, inclusiv fotbal, baschet, înot și tenis, 
                                pentru a satisface toate preferințele și nivelurile de abilități.</h3>
                            <a href="#section_3" class="btn">Descoperă mai multe</a>
                        </div>
                    </div>
                    <div class="swiper-slide slide" style="background:url(images/home-slide-3.jpg) no-repeat">
                        <div class="content">
                            <span>Vezi o listă de evenimente!</span>
                            <h3>Baza noastră sportivă găzduiește o varietate de evenimente, de la competiții locale și turnee.</h3>
                            <a href="#section_4" class="btn">Descoperă mai multe</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
        <section class="despre_noi" id="section_2">
           
                <div class="image">
                    <img src="images/despre_noi.jpg" alt="">
                </div>
                <div class="content">
                    <h3>Despre noi</h3>
                    <p>Calitatea vieții locuitorilor unui oraș este puternic legată de accesul 
                    pe care îl au la facilități pentru petrecerea timpului liber. 
                    DCSports le oferă piteștenilor atât un spațiu unde copiii lor să se inițieze în diferite
                    discipline sportive, pe care să le poată practica cu plăcere,
                    cât și oportunitatea de a petrece mai mult timp liber în natură,
                    împreună cu familia, făcând mișcare în cele mai bune condiții.
                    Accesul în perimetrul Bazei Sportive DCSports se face pe bază
                    de rezervare în funcție de acitivitatea aleasă. Creează-ți un cont cu un click AICI sau vino în incinta bazei sportive
                    unde te vor ajuta colegii noștri.</p>
                    <a href="#section_3" class="btn">Rezervă acum!</a>
                </div>
            
        </section>
        <section class="facilitati" id="section_3">
            <h1 class="heading-title">Facilități</h1>
            <div class="box-container">
                <div class="box">
                    <?php if($user_id):?>
                          <a href="Facilitati\Fotbal_Page.php"><img src="images/fotbal_icon.png" alt=""></a>
                    <?php else:?>
                        <img src="images/fotbal_icon.png" alt="" onclick="alert('Trebuie sa ti faci cont!'); window.location.href = '\Page_Log_In.php';">
                    <?php endif;?>
                    <h3>Fotbal</h3>
                </div>
                <div class="box">
                    <?php if($user_id):?>
                        <a href="Facilitati\Basket_Page.php"><img src="images/basket_icon.png" alt=""></a>
                    <?php else:?>
                        <img src="images/basket_icon.png" alt="" onclick="alert('Trebuie sa ti faci cont!'); window.location.href = '\Page_Log_In.php';">
                    <?php endif;?>
                    <h3>Baschet</h3>
                </div>
                <div class="box">
                    <?php if($user_id):?>
                        <a href="Facilitati\Bazin_Page.php"><img src="images/bazin_icon.png" alt=""></a>
                    <?php else:?>
                        <img src="images/bazin_icon.png" alt="" onclick="alert('Trebuie sa ti faci cont!'); window.location.href = '\Page_Log_In.php';">
                    <?php endif;?>
                    <h3>Bazin</h3>
                </div>
                <div class="box">
                    <?php if($user_id):?>
                        <a href="Facilitati\Tenis_Page.php"><img src="images/tenis_icon.png" alt=""></a>
                    <?php else:?>
                        <img src="images/tenis_icon.png" alt="" onclick="alert('Trebuie sa ti faci cont!'); window.location.href = '\Page_Log_In.php';">
                    <?php endif;?>
                    <h3>Tenis</h3>
                </div>
            </div>

        </section>
        <section class="evenimente" id="section_4">
                <h1 class="heading-title">Evenimente</h1>
                <div class="box-container">
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_1.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Fotbal</h3>
                            <p>Cupa Tymbark</p>
                    
                                <button onclick="openModal();currentSlide(1)" class="btn">Detalii despre eveniment!</button>
                            
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_2.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Fotbal</h3>
                            <p>Turneul pentru Juniori</p>
                           
                                <button onclick="openModal();currentSlide(2)" class="btn">Detalii despre eveniment!</button>
                            
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_3.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Baschet</h3>
                            <p>Campionatul DCSports de Baschet</p>
                            <button onclick="openModal();currentSlide(3)" class="btn">Detalii despre eveniment!</button>
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_4.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Baschet</h3>
                            <p>Turneul de Baschet pentru Copii DCSports</p>
                            <button onclick="openModal();currentSlide(4)" class="btn">Detalii despre eveniment!</button>
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_5.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Natație</h3>
                            <p>Competiția Națională de Înot DCSports</p>
                            <button onclick="openModal();currentSlide(5)" class="btn">Detalii despre eveniment!</button>
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_6.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Natație</h3>
                            <p>Turneul de Înot DCSports pentru Juniori</p>
                            <button onclick="openModal();currentSlide(6)" class="btn">Detalii despre eveniment!</button>
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_7.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Tenis de câmp</h3>
                            <p>Campionatul de Tenis DCSports</p>
                            <button onclick="openModal();currentSlide(7)" class="btn">Detalii despre eveniment!</button>
                            
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_8.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Tenis de câmp</h3>
                            <p>Turneul de Tenis pentru Copii DCSports</p>
                            <button onclick="openModal();currentSlide(8)" class="btn">Detalii despre eveniment!</button>
                            
                        </div>
                    </div>
                    <div class="box">
                        <div class="image">
                            <img src="images_evenimente/eveniment_9.jpg" alt="">
                        </div>
                        <div class="content">
                            <h3>Tenis de câmp</h3>
                            <p>Competiția de Tenis DCSports pentru Juniori</p>
                            <button onclick="openModal();currentSlide(9)" class="btn">Detalii despre eveniment!</button>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="load-more">
                    <span class="btn">Mai multe evenimente</span>
                </div>
                <div id="myModal" class="modal">
                    <span class="close cursor" onclick="closeModal()">&times;</span>
                    <div class="modal-content">
                        <div class="mySlides">
                            <div class="numbertext">1 / 9</div>
                            <img src="images_evenimente/eveniment_1.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Cupa Tymbark Junior</h2>
                                <p>Campionatul de fotbal Cupa Tymbark are o experiență de 17 ani, fiind organizat în România de către baza sportivă DCSports.
                                     Din 2007, sponsorul principal al turneului este brandul Tymbark, parte a Grupului Maspex Wadowice. 
                                     Turneul se desfășoară în România sub denumirea „Cupa Tymbark. Din curtea școlii pe stadion!” și este,
                                      practic, cel mai mare campionat de fotbal pentru copii din Europa, cu peste 1,5 milioane de copii participanți din toată țara,
                                       cu vârste cuprinse între 6 și 12 ani. La cea mai recentă ediție a turneului,
                                 finalizată în luna mai 2016, au participat peste 320.000 de elevi din clasele primare (fete și băieți) din toată România.
                                În România, baza sportivă DCSports organizează Cupa Tymbark Junior, ediția 2017, care a înregistrat la start un număr record
                                de 122.692 de copii înscriși în competiție, însumând peste 12.500 de echipe, fete și băieți.</p>
                            </div>
                        </div>

                       <div class="mySlides">
                            <div class="numbertext">2 / 9</div>
                            <img src="images_evenimente/eveniment_2.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Turneul DCSports de Fotbal pentru Juniori</h2>
                                <p>Baza sportivă DCSports a organizat Turneul de Fotbal pentru Juniori, 
                                    un eveniment dedicat copiilor cu vârste cuprinse între 6 și 12 ani. 
                                    Cu peste 1.000 de participanți din întreaga țară, acest turneu promovează 
                                    talentul tinerilor fotbaliști și spiritul de echipă.</p>
                            </div>
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">3 / 9</div>
                            <img src="images_evenimente/eveniment_3.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Campionatul DCSports de Baschet</h2>
                                <p>Baza sportivă DCSports a organizat Campionatul de Baschet,
                                     atrăgând echipe de tineri jucători din întreaga țară. Evenimentul a fost un succes, 
                                     cu meciuri captivante și performanțe impresionante din partea participanților.</p>
                            </div>
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">4 / 9</div>
                            <img src="images_evenimente/eveniment_4.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Turneul de Baschet pentru Copii DCSports</h2>
                                <p>În cadrul bazei sportive DCSports, Turneul de Baschet pentru Copii 
                                    a adus împreună echipe de băieți și fete, oferind o platformă excelentă
                                     pentru dezvoltarea abilităților sportive și fair-play-ului.</p>
                            </div>
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">5 / 9</div>
                            <img src="images_evenimente/eveniment_5.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Competiția Națională de Înot DCSports</h2>
                                <p>La baza sportivă DCSports, Competiția Națională de Înot a reunit tineri înotători din toată România,
                                     oferind o scenă pentru performanțe remarcabile și promovarea sportului acvatic.</p>
                            </div>
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">6 / 9</div>
                            <img src="images_evenimente/eveniment_6.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Turneul de Înot DCSports pentru Juniori</h2>
                                <p>DCSports a organizat Turneul de Înot pentru Juniori, un eveniment care a
                                     promovat sănătatea și dezvoltarea fizică a tinerilor participanți,
                                      încurajându-i să își depășească limitele.</p>
                            </div>
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">7 / 9</div>
                            <img src="images_evenimente/eveniment_7.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Campionatul de Tenis DCSports</h2>
                                <p>Baza sportivă DCSports a găzduit Campionatul de Tenis, oferind tinerilor
                                     jucători oportunitatea de a-și demonstra abilitățile pe teren și de a concura la un nivel înalt.</p>
                            </div>
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">8 / 9</div>
                            <img src="images_evenimente/eveniment_8.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Turneul de Tenis pentru Copii DCSports</h2>
                                <p>În cadrul bazei sportive DCSports, Turneul de Tenis pentru Copii a 
                                    adunat tineri entuziaști ai acestui sport, oferindu-le șansa de a-și dezvolta talentul
                                     și de a concura într-un mediu prietenos și competitiv.</p>
                            </div>
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">9 / 9</div>
                            <img src="images_evenimente/eveniment_9.jpg" style="width:100%">
                            <div class="content-info">
                                <h2>Competiția de Tenis DCSports pentru Juniori</h2>
                                <p>Competiția de Tenis DCSports pentru Juniori a reunit tineri jucători 
                                    din toată țara, oferindu-le o platformă pentru a-și demonstra abilitățile 
                                    și a învăța din experiența competițională.</p>
                            </div>
                        </div>
                     
    
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>

                        <div class="caption-container">
                            <p id="caption"></p>
                        </div>
                    </div>
                </div>

        </section>
        <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h2>Link uri utile</h2>
                    <a href="#section_1"><i class="fas fa-angle-right"></i>Acasa</a>
                    <a href="#section_2"><i class="fas fa-angle-right"></i>Despre Noi</a>
                    <a href="#section_3"><i class="fas fa-angle-right"></i>Facilități</a>
                    <a href="#section_4"><i class="fas fa-angle-right"></i>Evenimente</a>
                    <a href="Contact.php"><i class="fas fa-angle-right"></i>Contact</a>
                </div>
                <div class="box">
                    <h2>Aici ne poți găsi:</h2>
                    <h2>Pitești, Str.Nicolae Dobrin Nr.10 </h2>
                    <h2>0791-154-371</h2>
                    <h2>dcsport@gmail.com</h2>
                    
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2828.765270190551!2d24.865127727766136!3d44.84671344297892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b2bc99cc500bd7%3A0xc0022c3c132fd5ac!2sBaza%20Sportiv%C4%83%20Constantin%20C%C3%A2rstea!5e0!3m2!1sro!2sro!4v1714753967635!5m2!1sro!2sro" width="" height="" style="border:1;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                   
                </div>
                <div class="box">
                    <h2>Urmărește-ne pe social media:</h2>
                    <a href="https://ro-ro.facebook.com" ><i class='bx bxl-facebook-circle'></i>DC Sports Facebook</a>
                    <a href="https://ro.pinterest.com/pin/225320787578795949"><i class='bx bxl-pinterest' ></i>DC Sports Pinterest</a>
                    <a href="https://twitter.com/?lang=ro"><i class="fab fa-twitter"></i>DC Sports X</a>
                    <a href="https://www.youtube.com" ><i class='bx bxl-youtube'></i>DC Sports Youtube</a>
                </div>

            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/click-scroll.js"></script>
    </body>
</html>