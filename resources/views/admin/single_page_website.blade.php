<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>

    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link rel="icon" type="image/png" href="favicon.ico?v=1" />

    <title>Home</title>

    <!-- Page Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{ asset("single_page/css/style.css") }}" />
    <style>
        #news-slider {
            margin-top: 20px;
        }

        .post-slide {
            background: #fff;
            margin: 20px 15px 20px;
            border-radius: 15px;
            padding-top: 1px;
            box-shadow: 0px 14px 22px -9px #bbcbd8;
            /*border: 1px solid rgb(184, 184, 184);*/
        }

        .post-slide .post-img {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin: 12px 15px 8px 15px;
            margin-left: 10px;
        }

        .post-slide .over-layer i {
            position: relative;
            top: 45%;
            text-align: center;
            display: block;
            color: #fff;
            font-size: 25px;
        }

        .post-slide .post-content {
            background: #fff;
            padding: 2px 20px 40px;
            border-radius: 15px;
        }

        .post-slide .post-title {
            font-weight: bold;
            color: #333;
            display: inline-block;
        }

        .post-slide a {
            text-decoration: none;
            color: #3498db;
        }

        .post-slide .post-description {
            /*line-height:24px;*/
            color: black;
            /*margin-bottom:25px;*/
        }

        .post-slide .post-date {
            color: #a9a9a9;
            font-size: 14px;
        }

        .post-slide .post-date i {
            font-size: 20px;
            margin-right: 8px;
            color: #CFDACE;
        }

        .post-slide .read-more {
            padding: 7px 20px;
            float: right;
            font-size: 12px;
            background: #2196F3;
            color: #ffffff;
            box-shadow: 0px 10px 20px -10px #1376c5;
            border-radius: 25px;
            text-transform: uppercase;
        }

        .post-slide .read-more:hover {
            background: #3498db;
            text-decoration: none;
            color: #fff;
        }

        .owl-controls .owl-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .owl-controls .owl-buttons .owl-prev {
            background: #fff;
            position: absolute;
            top: -13%;
            left: 15px;
            padding: 0 18px 0 15px;
            border-radius: 50px;
            box-shadow: 3px 14px 25px -10px #92b4d0;
            transition: background 0.5s ease 0s;
        }

        .owl-controls .owl-buttons .owl-next {
            background: #fff;
            position: absolute;
            top: -13%;
            right: 15px;
            padding: 0 15px 0 18px;
            border-radius: 50px;
            box-shadow: -3px 14px 25px -10px #92b4d0;
            transition: background 0.5s ease 0s;
        }

        .owl-controls .owl-buttons .owl-prev:after,
        .owl-controls .owl-buttons .owl-next:after {
            content: "\f104";
            font-family: FontAwesome;
            color: #333;
            font-size: 30px;
        }

        .owl-controls .owl-buttons .owl-next:after {
            content: "\f105";
        }

        @media only screen and (max-width:1280px) {
            .post-slide .post-content {
                padding: 0px 15px 15px 15px;
            }
        }

        .borderradius {
            border-radius: 8px 10px 12px 14px;
        }

        .blog-bg,
        .feature-bg {
            background: #F7F7F7 0% 0% no-repeat padding-box;

        }

        .bg-img {
            background-image: url('image/site/Final/Repeat_Grid_1.png');
            background-repeat: no-repeat;
            opacity: 0.9;
        }

        .feature-img-size {
            width: 100%
        }

        .footer-color {
            background: #D5E3FF !important;
            color: #000 !important;
        }

        .h16 {
            height: 16px;
        }

        .set-height-comm {
            min-height: 274px;
            max-height: 279px;
        }

        .footer a {
            text-decoration: none !important;
            color: #000 !important;
        }
    </style>

</head>


<body>
    <header class="bg-img">
        <div class="col-md-12 container">
            <div class="row">
                <div class="col-md-6">
                    <div id="carouselExampleIndicators" class="carousel" data-bs-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset("single_page/image/vidukathai/screenshots/Home.png") }}" class="d-block img-size img-fluid"
                                    alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset("single_page/image/vidukathai/screenshots/Home.png") }}" class="d-block img-size img-fluid"
                                    alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset("single_page/image/vidukathai/screenshots/Home.png") }}" class="d-block img-size img-fluid"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="logo">
                        <img src="{{ asset("single_page/image/vidukathai/logo/Logo.png")}}" alt="logo">
                    </div>
                    <div class="apptitle">
                        <h1><b>Vidukathaigal</b></h1>
                        <p>
                            Welcome to the world of Tamil Vidukathai! This app is filled with fun, brainy moments that challenge your thinking and brighten your day. Enjoy riddles that make you think and smile, solve puzzles, learn new things, and stay mentally sharp. From kids to elders, there's something here for everyone to enjoy. Let the riddle adventure begin now!
                        </p>
                        <h4>By SkyRaan Technologies</h4>
                        <div class="download">
                            <a href="https://apps.apple.com/us/app/"><img src="{{ asset("single_page/image/store/appstore.png")}}" alt="app_store"
                                    class="img-fluid btn ml-4 mb-3"></a>
                            <a href="https://play.google.com/store/apps/details?id=com.skyraan.manasu"><img src="{{ asset("single_page/image/store/googleplay.png")}}" alt="play_store"
                                    class="img-fluid btn ml-4 mb-3"></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>
    <!-- header-->
    <section class="my-5">
        <div class="col-md-12 container my-4">

            <div class="text-center">
                <h2 class="mt-3 fw-bold" style="text-align: center;">Features</h2>
            </div>

        </div>

        <div class="container text-center feature-bg p-4">
            <div class="row justify-content-center">
                <div class="col-md-3 py-3">
                    <div class="card mx-2 p-2">
                        <img src="{{ asset("single_page/image/vidukathai/features/Level Difficulty.png")}}"
                            class="img-fluid img-fluid feature-img-size mb-2">
                        <h5 class="fw-bold text-truncate">Level Difficulty</h5>
                    </div>
                </div>
                <div class="col-md-3 py-3">
                    <div class="card mx-2 p-2">
                        <img src="{{ asset("single_page/image/vidukathai/features/Tamil Riddles.jpg")}}"
                            class="img-fluid img-fluid feature-img-size mb-2">
                        <h5 class="fw-bold text-truncate">Tamil Riddles</h5>
                    </div>
                </div>
                <div class="col-md-3 py-3">
                    <div class="card mx-2 p-2">
                        <img src="{{ asset("single_page/image/vidukathai/features/Hint.jpg")}}"
                            class="img-fluid img-fluid feature-img-size mb-2">
                        <h5 class="fw-bold text-truncate">Hint</h5>
                    </div>
                </div>
                <div class="col-md-3 py-3">
                    <div class="card mx-2 p-2">
                        <img src="{{ asset("single_page/image/vidukathai/features/Favorite.jpg") }}"
                            class="img-fluid img-fluid feature-img-size mb-2">
                        <h5 class="fw-bold text-truncate">Favorite</h5>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12 container mt-5" id="1">
            <div class="row">
                <div class="col-md-6">
                    <div class="screenshot image1">
                        <img src="{{ asset("single_page/image/vidukathai/screenshots/Level Difficulty.png")}}" alt="img" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6 screenshottext_2 align-self-center">
                    <div class="col-md-9">
                        <h3><b>Level Difficulty : </b></h3>
                    </div>
                    <div class="col-md-9">
                        <p>Choose your challenge with ease—play at your own pace, whether you're in the mood for something quick and simple or a real brain workout. With easy, medium, and hard levels available, every riddle fits your thinking style and helps you grow as a solver.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 container mt-5" id="2">
            <div class="row">
                <div class="col-md-6 screenshottext_2 align-self-center">
                    <div class="col-md-9">
                        <h3><b>Tamil Riddles:</b></h3>

                    </div>
                    <div class="col-md-9 ">
                        <p>Discover the Fun of Tamil Riddles!
                            Dive into a world of fun and clever Tamil Vidukathaigal that celebrate our language and culture. Each riddle is a mini brain adventure—full of surprises, laughter, and smart thinking. Perfect for all ages, whether you're playing solo or with friends!
                            Train your brain, spark your creativity, and enjoy hours of wholesome entertainment. Get ready to smile, think, and solve like never before!
                        </p>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="screenshot image2">
                        <img src="{{ asset("single_page/image/vidukathai/screenshots/Riddles.png")}}" alt="img" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 container mt-5" id="3">
            <div class="row">
                <div class="col-md-6">
                    <div class="screenshot image3">
                        <img src="{{ asset("single_page/image/vidukathai/screenshots/Hint.png")}}" alt="img" class="img-fluid">

                    </div>
                </div>
                <div class="col-md-6 screenshottext_2 align-self-center">
                    <div class="col-md-9">
                        <h3><b>Hint:</b></h3>
                    </div>
                    <div class="col-md-9">
                        <p>Stuck on a tricky riddle? Tap the Hint button to get a gentle push in the right direction without spoiling the answer. Hints are designed to keep you thinking, helping you enjoy the process even more when you're almost there but need a small clue.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 container mt-5" id="4">
            <div class="row">
                <div class="col-md-6 screenshottext_2 align-self-center">
                    <div class="col-md-9 mt-5">
                        <h3><b>Favorite : </b></h3>
                    </div>
                    <div class="col-md-9 ">
                        <p>Love a riddle? Mark it as Fav to save it for later and never lose the ones you enjoyed most. Whether you're revisiting clever puzzles or sharing them with friends and family, your favorites are always just a tap away. Start building your personal riddle collection today!</p>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="screenshot image4">
                        <img src="{{ asset("single_page/image/vidukathai/screenshots/Favorite.png")}}" alt="img" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!--blogs-->


    <!--blogs ends-->


    <section>


        <section class="mt-5 footer-color text-white p-4">

            <div class="row">
                <div class="col-md-7" style="border-right:1px solid white">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <img src="{{ asset("single_page/image/vidukathai/logo/Footer.png")}}" class="img-fluid">
                        </div>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="mt-3 me-5">
                                Get ready to play, think, and enjoy every moment with this joyful Tamil Vidukathai app. Whether you're taking a short break or diving deep into puzzle-solving, this app brings smiles, learning, and endless curiosity together. Your next favorite riddle is waiting—let’s get solving!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 p-4">
                    <div class="mb-4 footer">
                        <h5>Quick Links</h5>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <small class="d-flex "><img src="{{ asset("single_page/image/allicons/Arrow.png")}}" class="img-fluid me-2 h16">
                                    <a href="{{ asset('privacypolicy.html') }}">Privacy Policy</a></small>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <small class="d-flex "><img src="{{ asset("single_page/image/allicons/Arrow.png")}}" class="img-fluid me-2 h16">
                                    <a href="{{ asset('termsandconditions.html') }}">Terms & Conditions</a></small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5>Contact Us</h5>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="d-flex">
                                    <a href="mailto:contact@skyraanapps.com" class="text-black"><img
                                            src="{{ asset("single_page/image/allicons/Message.png")}}" class="img-fluid me-3">
                                        contact@skyraanapps.com</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex align-items-start justify-content-center">
                                    <img src="{{ asset("single_page/image/allicons/Location.png")}}" class="img-fluid h-25 me-3">
                                    No.17, Sri Venkateshwara Towers, FCI Rd, opp. Fire Station, Gandhimaa Nagar,
                                    Peelamedu, Coimbatore, Tamil Nadu 641004
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="">
                        <h5>Download Vidukathaigal App now</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="">
                                    <a href="https://apps.apple.com/us/app/id6449382810"><img
                                            src="{{ asset("single_page/image/store/appstore.png")}}" alt="app_store"
                                            class=" btn ml-4 img-fluid w-75"></a>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <a href="https://play.google.com/store/apps/details?id=com.skyraan.manasu"><img
                                            src="{{ asset("single_page/image/store/googleplay.png")}}" alt="play_store"
                                            class=" btn ml-4 img-fluid w-75"></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </section>

        <script src="{{ asset("single_page/js/script.js")}}"></script>
        <script src="{{ asset("single_page/js/jquery-3.6.1.min.js")}}"></script>
        <script src="{{ asset("single_page/bootstrap/js/popper.min.js")}}"></script>
        <script src="{{ asset("single_page/bootstrap/js/bootstrap.min.js")}}"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
        <script>

            $(document).ready(function () {
                $("#news-slider").owlCarousel({
                    items: 3,
                    itemsDesktop: [1199, 3],
                    itemsDesktopSmall: [980, 2],
                    itemsMobile: [600, 1],
                    navigation: false,
                    navigationText: ["", ""],
                    pagination: true,
                    autoPlay: true
                });
            });
        </script>

</body>

</html>