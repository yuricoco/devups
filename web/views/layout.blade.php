
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Foundation &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700|Anton" rel="stylesheet">


    <link rel="stylesheet" href="{{__env}}web/assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/jquery-ui.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{__env}}web/assets/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="{{__env}}web/assets/fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/aos.css">

    <link rel="stylesheet" href="{{__env}}web/assets/css/style.css">

</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

<div class="site-wrap"  id="home-section">

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>


    <header class="site-navbar js-sticky-header site-navbar-target" role="banner">

        <div class="container">
            <div class="row align-items-center position-relative">


                <div class="site-logo">
                    <a href="index.html" class="text-black"><span class="text-primary">Foundation</a>
                </div>

                <nav class="site-navigation text-center ml-auto" role="navigation">

                    <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
                        <li><a href="#home-section" class="nav-link">Home</a></li>
                        <li><a href="#about-section" class="nav-link">About</a></li>
                        <li><a href="#discover-section" class="nav-link">Discover</a></li>
                        <li><a href="#donate-section" class="nav-link">Donate</a></li>
                        <li><a href="#blog-section" class="nav-link">Blog</a></li>
                        <li><a href="#contact-section" class="nav-link">Contact</a></li>
                    </ul>
                </nav>



                <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

            </div>
        </div>

    </header>

    <div class="owl-carousel slide-one-item">
        <a href="#"><img src="{{__env}}web/assets/images/hero_1.jpg" alt="Image" class="img-fluid"></a>
        <a href="#"><img src="{{__env}}web/assets/images/hero_2.jpg" alt="Image" class="img-fluid"></a>
    </div>

    <div class="d-block d-md-flex intro-engage">
        <div class="">
            <?= ProductTable::init($lazyloading)->buildfronttable()->render() ?>
        </div>
        <div class="">
            <h2>Rescue An Orphan</h2>
            <p>Accusantium dignissimos voluptas rem consequatur blanditiis error ratione illo sit quasi ut praesentium magnam</p>
        </div>
        <div>
            <h2>Feed The Hungry</h2>
            <p>Accusantium dignissimos voluptas rem consequatur blanditiis error ratione illo sit quasi ut praesentium magnam</p>
        </div>
        <div>
            <h2>Free Education</h2>
            <p>Accusantium dignissimos voluptas rem consequatur blanditiis error ratione illo sit quasi ut praesentium magnam</p>
        </div>
    </div>

    <div class="site-section bg-image overlay counter" style="background-image: url('images/hero_1_no-text.jpg');" id="about-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mb-4">
                    <figure class="block-img-video-1" data-aos="fade">
                        <a href="https://vimeo.com/45830194" class="popup-vimeo">
                            <span class="icon"><span class="icon-play"></span></span>
                            <img src="{{__env}}web/assets/images/hero_1_no-text.jpg" alt="Image" class="img-fluid">
                        </a>
                    </figure>
                </div>
                <div class="col-lg-5 ml-auto align-self-lg-center">
                    <h2 class="text-black mb-4 text-uppercase section-title">Our Mission</h2>
                    <p class="text-black">Accusantium dignissimos voluptas rem consequatur blanditiis error ratione illo sit quasi ut, praesentium magnam, pariatur quae, necessitatibus</p>
                    <p class="text-black">Dolor, eligendi voluptate ducimus itaque esse autem perspiciatis sint! Recusandae dolor aliquid inventore sit,</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 col-lg-0 col-lg-3">
                    <div class="block-counter-1">
                        <span class="number"><span data-number="15">0</span></span>
                        <span class="caption text-black">Number of Orphanage</span>
                    </div>
                </div>
                <div class="col-md-6 mb-4 col-lg-0 col-lg-3">
                    <div class="block-counter-1">
                        <span class="number"><span data-number="392">0</span></span>
                        <span class="caption text-black">Number of Donations</span>
                    </div>
                </div>
                <div class="col-md-6 mb-4 col-lg-0 col-lg-3">
                    <div class="block-counter-1">
                        <span class="number"><span data-number="3293">0</span></span>
                        <span class="caption text-black">Number of Volunteers</span>
                    </div>
                </div>
                <div class="col-md-6 mb-4 col-lg-0 col-lg-3">
                    <div class="block-counter-1">
                        <span class="number"><span data-number="1212">0</span></span>
                        <span class="caption text-black">Number of Orphans</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section bg-light counter" id="discover-section">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-md-7 text-center">
                    <div class="block-heading-1">
                        <h2 class="text-black text-uppercase">Discover</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto aperiam unde natus voluptates placeat accusamus vel laborum cupiditate. Reiciendis commodi perferendis dignissimos, amet quis.</p>
                    </div>
                </div>
            </div>
            <div class="row mb-5">

                <div class="col-lg-6 mb-5">
                    <img src="{{__env}}web/assets/images/hero_1_no-text.jpg" alt="Image" class="img-fluid">
                </div>
                <div class="col-lg-5 ml-auto align-self-center">
                    <h3 class="text-black text-uppercase mb-4">Build Schools in Africa</h3>
                    <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam quis, nemo explicabo cupiditate vero fugiat sit eius sequi.</p>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="block-counter-1 block-counter-1-sm">
                                <span class="number"><span data-number="15">0</span></span>
                                <span class="caption text-black">Schools</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="block-counter-1 block-counter-1-sm">
                                <span class="number"><span data-number="1039">0</span></span>
                                <span class="caption text-black">Students</span>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

            <div class="row mb-5">

                <div class="col-lg-6 mb-5 order-lg-2">
                    <img src="{{__env}}web/assets/images/hero_2_no-text.jpg" alt="Image" class="img-fluid">
                </div>
                <div class="col-lg-5 mr-auto align-self-center order-lg-1">
                    <h3 class="text-black text-uppercase mb-4">Feeding Children in Africa</h3>
                    <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam quis, nemo explicabo cupiditate vero fugiat sit eius sequi.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="block-counter-1 block-counter-1-sm">
                                <span class="number"><span data-number="3298">0</span></span>
                                <span class="caption text-black">Children</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="block-counter-1 block-counter-1-sm">
                                <span class="number"><span data-number="38">0</span></span>
                                <span class="caption text-black">Orphanage</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="site-section bg-image overlay" style="background-image: url('images/hero_1_no-text.jpg');" id="donate-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 text-center">
                    <h2 class="text-white mb-4">Make A Donation Now! You May Change Lives Forever</h2>
                    <p><a href="#" class="btn btn-primary px-4 py-3 btn-block">Donate Now</a></p>
                </div>
            </div>
        </div>
    </div>



    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4 text-center">
                    <span class="flaticon-piggy-bank d-block mb-3 display-3 text-secondary"></span>
                    <h3 class="text-primary h4 mb-2">Make Donation</h3>
                    <p>Accusantium dignissimos voluptas rem consequatur ratione illo sit quasi.</p>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 text-center">
                    <span class="flaticon-blood d-block mb-3 display-3 text-secondary"></span>
                    <h3 class="text-primary h4 mb-2">Medical Health</h3>
                    <p>Praesentium magnam pariatur quae necessitatibus eligendi voluptate ducimus.</p>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 text-center">
                    <span class="flaticon-food d-block mb-3 display-3 text-secondary"></span>
                    <h3 class="text-primary h4 mb-2">Food for the Poor</h3>
                    <p>Accusantium dignissimos voluptas rem consequatur ratione illo sit quasi.</p>
                </div>

                <div class="col-md-6 col-lg-4 mb-4 text-center">
                    <span class="flaticon-donation d-block mb-3 display-3 text-secondary"></span>
                    <h3 class="text-primary h4 mb-2">Help &amp; Love</h3>
                    <p>Accusantium dignissimos voluptas rem consequatur ratione illo sit quasi.</p>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 text-center">
                    <span class="flaticon-dollar d-block mb-3 display-3 text-secondary"></span>
                    <h3 class="text-primary h4 mb-2">Give To The Needy</h3>
                    <p>Praesentium magnam pariatur quae necessitatibus eligendi voluptate ducimus.</p>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 text-center">
                    <span class="flaticon-unity d-block mb-3 display-3 text-secondary"></span>
                    <h3 class="text-primary h4 mb-2">Volunteer</h3>
                    <p>Accusantium dignissimos voluptas rem consequatur ratione illo sit quasi.</p>
                </div>

            </div>
        </div>
    </div>



    <div class="site-section" id="team-section">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="text-black text-uppercase section-title">Our Leadership</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut corporis, eius, eos consectetur consequuntur sit. Aut, perspiciatis, reprehenderit.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0" data-aos="fade-up">
                    <div class="block-team-member-1 text-center rounded">
                        <figure>
                            <img src="{{__env}}web/assets/images/person_1.jpg" alt="Image" class="img-fluid rounded-circle">
                        </figure>
                        <h3 class="font-size-20 text-white">Jean Smith</h3>
                        <span class="d-block font-gray-5 letter-spacing-1 text-uppercase font-size-12 mb-3">Mining Expert</span>
                        <p class="px-3 mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, repellat. At, soluta. Repellendus vero, consequuntur!</p>
                        <div class="block-social-1">
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-facebook"></span></a>
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-twitter"></span></a>
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-instagram"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                    <div class="block-team-member-1 text-center rounded">
                        <figure>
                            <img src="{{__env}}web/assets/images/person_2.jpg" alt="Image" class="img-fluid rounded-circle">
                        </figure>
                        <h3 class="font-size-20 text-white">Bob Carry</h3>
                        <span class="d-block font-gray-5 letter-spacing-1 text-uppercase font-size-12 mb-3">Project Manager</span>
                        <p class="px-3 mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil quia veritatis, nam quam obcaecati fuga.</p>
                        <div class="block-social-1">
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-facebook"></span></a>
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-twitter"></span></a>
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-instagram"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                    <div class="block-team-member-1 text-center rounded">
                        <figure>
                            <img src="{{__env}}web/assets/images/person_3.jpg" alt="Image" class="img-fluid rounded-circle">
                        </figure>
                        <h3 class="font-size-20 text-white">Ricky Fisher</h3>
                        <span class="d-block font-gray-5 letter-spacing-1 text-uppercase font-size-12 mb-3">Engineer</span>
                        <p class="px-3 mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas quidem, laudantium, illum minus numquam voluptas?</p>
                        <div class="block-social-1">
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-facebook"></span></a>
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-twitter"></span></a>
                            <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-instagram"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="site-section block-13 overlay bg-image" id="testimonials-section" data-aos="fade" style="background-image: url('images/hero_1_no-text.jpg');">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="text-white text-uppercase section-title">Testimonial</h2>
            </div>

            <div class="owl-carousel nonloop-block-13">
                <div>
                    <div class="block-testimony-1 text-center">

                        <blockquote class="mb-4">
                            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, fugit excepturi sapiente voluptatum nulla odio quaerat quibusdam tempore similique doloremque veritatis et cupiditate, maiores cumque repudiandae explicabo tempora deserunt consequuntur?&rdquo;</p>
                        </blockquote>

                        <figure>
                            <img src="{{__env}}web/assets/images/person_4.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                        </figure>
                        <h3 class="font-size-20 text-white">Ricky Fisher</h3>
                    </div>
                </div>

                <div>
                    <div class="block-testimony-1 text-center">
                        <blockquote class="mb-4">
                            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, fugit excepturi sapiente voluptatum nulla odio quaerat quibusdam tempore similique doloremque veritatis et cupiditate, maiores cumque repudiandae explicabo tempora deserunt consequuntur?&rdquo;</p>
                        </blockquote>

                        <figure>
                            <img src="{{__env}}web/assets/images/person_2.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                        </figure>
                        <h3 class="font-size-20 text-white">Ken Davis</h3>
                    </div>
                </div>

                <div>
                    <div class="block-testimony-1 text-center">
                        <blockquote class="mb-4">
                            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, fugit excepturi sapiente voluptatum nulla odio quaerat quibusdam tempore similique doloremque veritatis et cupiditate, maiores cumque repudiandae explicabo tempora deserunt consequuntur?&rdquo;</p>
                        </blockquote>

                        <figure>
                            <img src="{{__env}}web/assets/images/person_1.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                        </figure>
                        <h3 class="font-size-20 text-white">Mellisa Griffin</h3>
                    </div>
                </div>

                <div>
                    <div class="block-testimony-1 text-center">
                        <blockquote class="mb-4">
                            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, fugit excepturi sapiente voluptatum nulla odio quaerat quibusdam tempore similique doloremque veritatis et cupiditate, maiores cumque repudiandae explicabo tempora deserunt consequuntur?&rdquo;</p>
                        </blockquote>

                        <figure>
                            <img src="{{__env}}web/assets/images/person_3.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                        </figure>
                        <h3 class="font-size-20 text-white">Robert Steward</h3>
                    </div>
                </div>


            </div>

        </div>
    </div>




    <div class="site-section" id="blog-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-7 text-center mb-5 text-center">
                    <h2 class="text-black text-uppercase section-title">Our Blog</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati ab possimus fugiat, autem aliquid, commodi quod voluptatum consectetur.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div>
                        <a href="single.html" class="mb-4 d-block"><img src="{{__env}}web/assets/images/hero_1_no-text.jpg" alt="Image" class="img-fluid rounded"></a>
                        <h2><a href="single.html">How to Invest In Investing Company</a></h2>
                        <p class="text-muted mb-3 text-uppercase small"><span class="mr-2">January 18, 2019</span> By <a href="single.html" class="by">James Cooper</a></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat et suscipit iste libero neque. Vitae quidem ducimus voluptatibus nemo cum odio ab enim nisi, itaque, libero fuga veritatis culpa quis!</p>
                        <p><a href="single.html">Get Started</a></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div>
                        <a href="single.html" class="mb-4 d-block"><img src="{{__env}}web/assets/images/hero_2_no-text.jpg" alt="Image" class="img-fluid rounded"></a>
                        <h2><a href="single.html">How to Invest In Investing Company</a></h2>
                        <p class="text-muted mb-3 text-uppercase small"><span class="mr-2">January 18, 2019</span> By <a href="single.html" class="by">James Cooper</a></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat et suscipit iste libero neque. Vitae quidem ducimus voluptatibus nemo cum odio ab enim nisi, itaque, libero fuga veritatis culpa quis!</p>
                        <p><a href="single.html">Read More</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="site-section bg-light" id="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="text-black section-title text-uppercase">Contact Us</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 mb-5">
                    <form action="#" method="post">
                        <div class="form-group row">
                            <div class="col-md-6 mb-4 mb-lg-0">
                                <input type="text" class="form-control" placeholder="First name">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="First name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Email address">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea name="" id="" class="form-control" placeholder="Write your message." cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 ml-auto">
                                <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5" value="Send Message">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="footer-heading mb-4">About Us</h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque facere laudantium magnam voluptatum autem. Amet aliquid nesciunt veritatis aliquam.</p>
                        </div>
                        <div class="col-md-4 ml-auto">
                            <h2 class="footer-heading mb-4">Features</h2>
                            <ul class="list-unstyled">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Testimonials</a></li>
                                <li><a href="#">Terms of Service</a></li>
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 ml-auto">

                    <div class="mb-5">
                        <div class="mb-5">
                            <h2 class="footer-heading mb-4">Some Paragraph</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat nostrum libero iusto dolorum vero atque aliquid.</p>
                        </div>
                        <h2 class="footer-heading mb-4">Subscribe to Newsletter</h2>
                        <form action="#" method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Enter Email" aria-label="Enter Email" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary text-white" type="button" id="button-addon2">Subscribe</button>
                                </div>
                            </div>
                    </div>


                    <h2 class="footer-heading mb-4">Follow Us</h2>
                    <a href="#about-section" class="smoothscroll pl-0 pr-3"><span class="icon-facebook"></span></a>
                    <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                    <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                    <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
                    </form>
                </div>
            </div>
            <div class="row pt-5 mt-5 text-center">
                <div class="col-md-12">
                    <div class="border-top pt-5">
                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </footer>

</div>

<script src="{{__env}}web/assets/js/jquery-3.3.1.min.js"></script>
<script src="{{__env}}web/assets/js/jquery-ui.js"></script>
<script src="{{__env}}web/assets/js/popper.min.js"></script>
<script src="{{__env}}web/assets/js/bootstrap.min.js"></script>
<script src="{{__env}}web/assets/js/owl.carousel.min.js"></script>
<script src="{{__env}}web/assets/js/jquery.magnific-popup.min.js"></script>
<script src="{{__env}}web/assets/js/jquery.sticky.js"></script>
<script src="{{__env}}web/assets/js/jquery.waypoints.min.js"></script>
<script src="{{__env}}web/assets/js/jquery.animateNumber.min.js"></script>
<script src="{{__env}}web/assets/js/aos.js"></script>

<script src="{{__env}}web/assets/{{__env}}web/assets/js/main.js"></script>

</body>
</html>