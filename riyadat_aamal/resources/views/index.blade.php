@extends('layouts.app')



@section('title')Massen @endsection

@section('css')

    <link rel="stylesheet" href="{{ asset('/css/index.css') }}">

    <link rel="stylesheet" href="{{ asset('css/recommandation.css') }}">

    <link rel="stylesheet" href="{{ asset('css/events.css') }}">

@endsection



@section('content')



{{-- Message error et session --}}

@if (!($errors->isEmpty()))

<div class="boucle_alerts">

    @foreach ($errors->all() as $message)

        <div class="form-alerts toasts" style="position: static">

            <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">

                <div class="d-flex align-items-center">

                    <i class="fa fa-cube" style="color: white;font-size: 30px"></i>

                    <p><b class="d-flex">{{ $message }}.</b></p>

                </div>

            </div>

        </div>

    @endforeach

</div>

@endif

@if (session('message'))

<div class="boucle_alerts">

  <div class="form-alerts toasts" style="position: static">

    <div role="alert" class="fade form-warning alert alert-primary alert-dismissible show">

      <div class="d-flex align-items-center">

          <i class="fa fa-cube" style="color: white;font-size: 30px"></i>

          <p><b class="d-flex">{{ session('message') }}. <i class="fa fa-check-circle" aria-hidden="true" style="color:white;margin-left:10px;font-size:23px"></i></b></p>

      </div>

    </div>

  </div>

</div>

@endif



<div class="div_lang">

    <div class="lang">

        <a href="{{ route('lang','fr') }}"><img class="img_lang" src="{{ asset('img/fr.png') }}" alt=""></a>

    </div>

    <div class="lang">

        <a href="{{ route('lang','ang') }}"><img class="img_lang" src="{{ asset('img/ang.jpg') }}" alt=""></a>

    </div>

    <div class="lang">

        <a href="{{ route('lang','ar') }}"><img class="img_lang" src="{{ asset('img/ar.png') }}" alt=""></a>

    </div>

</div>



@if (!session('lang'))



{{-- Jumbotron --}}

    <section class="section_banner">

        <h1 class="h1_banner">The Moroccan Association

        <div>of Entrepreneurs</div>

        </h1>

        <p class="p_banner"> The association was established in December 2019

            in Tangiers at the initiative of a group of

            entrepreneurs</p>

        {{-- <div class="cta">

        <button >Get started</button>

        </div> --}}

    </section>



{{-- our service --}}

<section class="we-offer-area text-center bg-gray wow fadeIn" id="services" data-wow-duration="1.5s">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="site-heading text-center">

                    <h2 style="color: black">Our <span>Services</span></h2>

                </div>

            </div>

        </div>

            <div class="row our-offer-items less-carousel">

                <!-- Single Item -->

                <div class="col-md-4 col-sm-6 equal-height">

                    <div class="item">

                        <i class="fa fa-pencil-square" aria-hidden="true"></i>

                        <h4>Entrepreneurship</h4>

                        <p>

                            Contributing to improving the business climate and promoting entrepreneurship.

                        </p>

                    </div>

                </div>

                <!-- End Single Item -->



                <!-- Single Item -->

                <div class="col-md-4 col-sm-6 equal-height">

                    <div class="item">

                        <i class="fa fa-diamond" aria-hidden="true"></i>

                        <h4>ASupporting companies</h4>

                        <p>

                            Supporting companies through training and mentorship

                        </p>

                    </div>

                </div>

                <!-- End Single Item -->



                <!-- Single Item -->

                <div class="col-md-4 col-sm-6 equal-height">

                    <div class="item">

                        <i class="fa fa-tasks"></i>

                        <h4>Enabling entrepreneurs</h4>

                        <p>

                            Enabling entrepreneurs and professionals to be aware of developments in the field of entrepreneurship

                        </p>

                    </div>

                </div>

                <!-- End Single Item -->



                <!-- Single Item -->

                <div class="col-md-4 col-sm-6 equal-height">

                    <div class="item">

                        <i class="fa fa-tachometer" aria-hidden="true"></i>

                        <h4>Social development</h4>

                        <p>

                            Contributing to the economic and social development

                        </p>

                    </div>

                </div>

                <!-- End Single Item -->



                <!-- Single Item -->

                <div class="col-md-4 col-sm-6 equal-height">

                    <div class="item">

                        <i class="fa fa-recycle" aria-hidden="true"></i>

                        <h4>Developing networks</h4>

                        <p>

                            Developing networks between the members of the association and with incubators and project funders

                        </p>

                    </div>

                </div>

                <!-- End Single Item -->



                <!-- Single Item -->

                <div class="col-md-4 col-sm-6 equal-height">

                    <div class="item">

                        <i class="fa fa-handshake-o" aria-hidden="true"></i>

                        <h4>self-employment</h4>

                        <p>

                            Encouraging self-employment and entrepreneurial thinking.

                        </p>

                    </div>

                </div>

                <!-- End Single Item -->

            </div>

    </div>

</section>



{{-- About us --}}

<div class="container-fluid about_us wow fadeIn" id="about" data-wow-duration="1.5s">

    <div class="row d-sm-flex align-items-center justify-content-between">

        <div class="col-lg-6 order-2 order-sm-1 p-3 p-sm-5">

            <div class="p-0 p-sm-5">

                {{-- <small class="text-uppercase" style="color: #9B5DE5;">BrandName</small> --}}

                <h1 class="mb-4 display-4" style="font-weight: 600;">à propos <span style="color: #2d1166;">de nous</span></h1>

                <p class="text-secondary" style="line-height: 2;">Moroccan Association For Entrepreneurs est une

                    association nationale indépendante qui se consacre

                    à la diffusion de la culture et à la promotion des

                    activités et des pratiques entrepreneuriales, de la

                    créativité, de l'innovation et de l'excellence aussi bien

                    au niveau local, national qu'international.

                    L'association a été créée à Tanger en décembre 2019

                    à l'initiative d'un groupe d'entrepreneurs de la

                    région du Nord  <br>

                    Afin de concrétiser ces objectifs, l'association

                    a élaboré le plan stratégique 2020 ~ 2023, qui

                    définit un cadre d’action et met en évidence

                    les grands axes de travail au cours de ces

                    trois années

                </p>

            </div>

        </div>

        <div class="col-lg-6 order-1 order-sm-2">

            <img src="{{ asset('img/about_us.png') }}" width="100%" style="border-radius: 35px;box-shadow: 5px 5px 20px 0px;" alt="">

        </div>

    </div>

</div>





<section class="page-section" id="about">

    <div class="container">

        <div class="site-heading text-center">

            <h2 style="color: black"> <span>Comité</span></h2>

        </div>

        <ul class="timeline">

            <li>

                <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img/co1.jpg" alt="...""></div>

                <div class="timeline-panel">

                    <div class="timeline-heading">

                        <h4 class="subheading">La commission d'étude et de recherche qui est

                            chargée de:</h4>

                    </div>

                    <div class="timeline-body">

                        <p class="text-muted">Mener des études et des recherches dans le

                            domaine de l'entrepreneuriat. <br> Échanger toutes ces recherches et études sur

                            l'entrepreneuriat à travers l'organisation des

                            séminaires, conférences, débats et visites.  <br> Renforcer le rôle de l’association dans la

                            soumission de propositions et l’analyse des

                            problématiques des entreprises dans différents

                            domaines <br> Contribuer au renforcement du pouvoir

                            propositionnel des entreprises et des associations

                            professionnelles afin d'améliorer le climat des

                            affaires au niveau régional et national. </p>

                    </div>

                </div>

            </li>

            <li class="timeline-inverted">

                <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img/co2.jfif" alt="..."></div>

                <div class="timeline-panel">

                    <div class="timeline-heading">

                        <h4 class="subheading">La commission d'encadrement et de formation est

                            chargée de :</h4>

                    </div>

                    <div class="timeline-body"><p class="text-muted">La Préparation et concrétisation d'un

                        programme de formation <br> La relation et Communication avec les

                        institutions spécialisées dans la formation

                        pour conclure des accords de partenariat et

                        organiser des activités conjointes <br> La préparation de guides de formation sur

                        des sujets et thèmes liés aux besoins des

                        entreprises.</p></div>

                </div>

            </li>

            <li>

                <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img//co3.png" alt="..."></div>

                <div class="timeline-panel">

                    <div class="timeline-heading">

                        <h4 class="subheading">La Commission de la communication et des relations

                            publiques qui pour rôle de:</h4>

                    </div>

                    <div class="timeline-body"><p class="text-muted">Établir et mettre en œuvre un plan annuel de

                        communication et de relations publiques. <br> Communiquer avec les associations

                        professionnelles et les institutions compétentes

                        an de conclure des accords de partenariat <br> Développer l'identité visuelle de l'association

                        et la diuser sur tous les supports de

                        communication <br> Préparer et assurer tous les moyens de

                        communication de l'association <br> L'association cherche à lier des relations

                        professionnelles avec tous les acteurs opérant

                        dans le domaine de l'entrepreneuriat et ce à

                        tous les niveaux régional, national

                        et international </p></div>

                </div>

            </li>



            <li class="timeline-inverted">

                <div class="timeline-image">

                    <h4>

                        Faites partie

                        <br>

                        de notre

                        <br>

                        comité!

                    </h4>

                </div>

            </li>

        </ul>

    </div>

</section>



{{-- contact --}}

<section class="text-center contact about wow fadeIn" id="contact" data-wow-duration="1.5s">

    <div class="overley"></div>

    <div style="padding-top: 2pc;padding-bottom: 17px;">



      <div class="container">

        <div class="row">

          <div class="div_form_contact">

              <form action="{{ route('contact_us') }}" method="POST">

                @csrf

                  <div class="form-group mb-4">

                    <label for="exampleInputEmail1" style="color: black;float: left;">nom complet :</label>

                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="entrer nom complet" name="full_name" required="">

                  </div>

                  <div class="form-group mb-4">

                    <label for="exampleInputEmail1" style="color: black;float: left;">Email :</label>

                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="entrer email" name="email" required="">

                  </div>

                  <div class="form-group mb-4">

                    <label for="exampleInputPassword1" style="color: black;float: left;">objet :</label>

                    <input type="text" class="form-control" name="subject" id="exampleInputPassword1" placeholder="entrer objet" required="">

                  </div>

                  <div class="form-group mb-4">

                    <label for="exampleInputPassword1" style="color: black;float: left;">Message :</label>

                    <textarea class="form-control" name="message" id="exampleFormControlTextarea1" placeholder="entrer Message" rows="3" required=""></textarea>

                  </div>

                  <button class="btn btn-primary btn-lg btn_contact" style="width:224px" type="submit">Contact</button>

            </form>

          </div>



        </div>



      </div>



    </div>

</section>



@endif



@if (session('lang')=='fr')



{{-- Jumbotron --}}

<section class="section_banner">

    <h1 class="h1_banner">Moroccan Association

    <div>For Entrepreneurs</div>

    </h1>

    <p class="p_banner"> L'association a été créée à Tanger en décembre 2019

        à l'initiative d'un groupe d'entrepreneurs</p>

</section>



{{-- our service --}}

<section class="we-offer-area text-center bg-gray wow fadeIn" id="services" data-wow-duration="1.5s">

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="site-heading text-center">

                <h2 style="color: black">Nos <span> services</span></h2>

            </div>

        </div>

    </div>

        <div class="row our-offer-items less-carousel">

            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-pencil-square" aria-hidden="true"></i>

                    <h4> l'esprit d'entreprise</h4>

                    <p>

                        Contribuer à l'amélioration du climat des affaires

                        et à la promotion de l'esprit d'entreprise.

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-diamond" aria-hidden="true"></i>

                    <h4>Accompagner les entrepreneurs</h4>

                    <p>

                        Accompagner les entrepreneurs dans les aspects

formation, encadrement et qualification

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-tasks"></i>

                    <h4>Permetire aux entrepreneurs </h4>

                    <p>

                        Permetire aux entrepreneurs et aux professionnels

de suivre toutes les nouveautés dans le domaine

de l'entrepreneuriat

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-tachometer" aria-hidden="true"></i>

                    <h4>Développement Social </h4>

                    <p>

                        Participer et contribuer au développement

économique et social

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-recycle" aria-hidden="true"></i>

                    <h4>Organiser des débats</h4>

                    <p>

                        Organiser des débats, séminaires et conférences

pour développer les capacités et la communication

avec les institutions économiques

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-handshake-o" aria-hidden="true"></i>

                    <h4>des recherches et études</h4>

                    <p>

                        Soutenir et faire des recherches et études dans les

différents secteurs professionnels et scientifiques

qui ont pour objectif le développement durable.

                    </p>

                </div>

            </div>

            <!-- End Single Item -->

        </div>

</div>

</section>



{{-- About us --}}

<div class="container-fluid about_us wow fadeIn" id="about" data-wow-duration="1.5s">

<div class="row d-sm-flex align-items-center justify-content-between">

    <div class="col-lg-6 order-2 order-sm-1 p-3 p-sm-5">

        <div class="p-0 p-sm-5">

            {{-- <small class="text-uppercase" style="color: #9B5DE5;">BrandName</small> --}}

            <h1 class="mb-4 display-4" style="font-weight: 600;">About <span style="color: #2d1166;">Us</span></h1>

            <p class="text-secondary" style="line-height: 2;">The Moroccan Association of Entrepreneurs is an

                independent national association concerned with

                disseminating the culture and promotion of

                entrepreneurship activities and practices and the

                culture of creativity, innovation and excellence at

                the local and international levels.

                 The association was established in December 2019

                in Tangiers at the initiative of a group of

                entrepreneurs in the Northern region . <br>

                In order to achieve these goals, MASSEN

developed its strategic plan 2020 ~ 2023,

which defines a framework for action and

highlights the major axes of its work during

these three years

            </p>

        </div>

    </div>

    <div class="col-lg-6 order-1 order-sm-2">

        <img src="{{ asset('img/about_us.png') }}" width="100%" style="border-radius: 35px;box-shadow: 5px 5px 20px 0px;" alt="">

    </div>

</div>

</div>





<section class="page-section" id="about">

<div class="container">

    <div class="site-heading text-center">

        <h2 style="color: black"> <span>Committee</span></h2>

    </div>

    <ul class="timeline">

        <li>

            <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img/co1.jpg" alt="...""></div>

            <div class="timeline-panel">

                <div class="timeline-heading">

                    <h4 class="subheading">The Study and Research Commitiee which is charge of:</h4>

                </div>

                <div class="timeline-body">

                    <p class="text-muted">Conducting studies and research in areas

                        of business. <br> Dissemination of studies on entrepreneurship

                        through seminars, conference etc <br> Strengthening the association’s role in

                        submiting proposals and analyzing the

                        problems facing companies in various fields </p>

                </div>

            </div>

        </li>

        <li class="timeline-inverted">

            <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img/co2.jfif" alt="..."></div>

            <div class="timeline-panel">

                <div class="timeline-heading">

                    <h4 class="subheading">The mentorship and Training Commitiee is responsible for:</h4>

                </div>

                <div class="timeline-body"><p class="text-muted">Preparing and providing training programs

                    for companies, especially SMEs <br> Communicating with the institutions

                    specialized in training to sign partnership

                    agreements and organize joint activities <br> Preparing training guides on topics relevant

                    to the needs of companies.</p></div>

            </div>

        </li>

        <li>

            <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img//co3.png" alt="..."></div>

            <div class="timeline-panel">

                <div class="timeline-heading">

                    <h4 class="subheading">Communication and Public Relations Commitiee

                        and its mandate is to:</h4>

                </div>

                <div class="timeline-body"><p class="text-muted">Establish and implement an annual

                    communication and public relations plan. <br> Communicate with companies and

                    institutions in order to conclude partnership

                    agreements <br> Develop the association's visual identity and

                    implement it on all communication tools <br> Prepare and distribute communication

                    messages and tools about the association.</p></div>

            </div>

        </li>



        <li class="timeline-inverted">

            <div class="timeline-image">

                <h4>

                    Be Part

                    <br>

                    Of Our

                    <br>

                    Committee!

                </h4>

            </div>

        </li>

    </ul>

</div>

</section>



{{-- contact --}}

<section class="text-center contact about wow fadeIn" id="contact" data-wow-duration="1.5s">

<div class="overley"></div>

<div style="padding-top: 2pc;padding-bottom: 17px;">



  <div class="container">

    <div class="row">

      <div class="div_form_contact">

          <form action="{{ route('contact_us') }}" method="POST">

            @csrf

              <div class="form-group mb-4">

                <label for="exampleInputEmail1" style="color: black;float: left;">Full Name :</label>

                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Full Name" name="full_name" required="">

              </div>

              <div class="form-group mb-4">

                <label for="exampleInputEmail1" style="color: black;float: left;">Email :</label>

                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required="">

              </div>

              <div class="form-group mb-4">

                <label for="exampleInputPassword1" style="color: black;float: left;">Subject :</label>

                <input type="text" class="form-control" name="subject" id="exampleInputPassword1" placeholder="Enter Subject" required="">

              </div>

              <div class="form-group mb-4">

                <label for="exampleInputPassword1" style="color: black;float: left;">Message :</label>

                <textarea class="form-control" name="message" id="exampleFormControlTextarea1" placeholder="Enter Message" rows="3" required=""></textarea>

              </div>

              <button class="btn btn-primary btn-lg btn_contact" style="width:224px" type="submit">Contact</button>

        </form>

      </div>



    </div>



  </div>



</div>

</section>



@endif



@if (session('lang')=='ar')



{{-- Jumbotron --}}

<section class="section_banner">

    <h1 class="h1_banner">الجمعية المغربية

    <div> لرواد الاعمال</div>

    </h1>

    <p class="p_banner"> تأسست الجمعية في دجنبر من سنة 2019 بمدينة طنجة بمبادرة

        من مجموعة من المقاولين بجهة الشمال</p>

</section>



{{-- our service --}}

<section class="we-offer-area text-center bg-gray wow fadeIn" id="services" data-wow-duration="1.5s">

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="site-heading text-center">

                <h2 style="color: black"> <span> الخدمات</span></h2>

            </div>

        </div>

    </div>

        <div class="row our-offer-items less-carousel">

            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-pencil-square" aria-hidden="true"></i>

                    <h4> المساهمة</h4>

                    <p>

                        المساهمة في تحسين مناخ الاعمال والدفع والنهوض بريادة

الاعمال

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-diamond" aria-hidden="true"></i>

                    <h4>نسج علاقات</h4>

                    <p>

                        نسج علاقات بين المنتمين للجمعية فيما بينهم من جهة وبين

المنتمين للجمعية والمتدخلين في مجال ريادة الاعمال

و خصوصا الجهات الحاضنة والممولة للمشاريع

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-tasks"></i>

                    <h4>العمل الحر </h4>

                    <p>

                        تشجيع أفراد المجتمع على ممارسة العمل الحر وتبني الفكر

الريادي

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-tachometer" aria-hidden="true"></i>

                    <h4>تنظيمات </h4>

                    <p>

                        تنظيم دورات وندوات ومؤتمرات لتطوير القدرات والتواصل

مع المؤسسات الاقتصادية

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-recycle" aria-hidden="true"></i>

                    <h4>التنمية المستدامة</h4>

                    <p>

                        دعم وإنجاز الابحاث والدراسات المهنية والعلمية التي تحقق

التنمية المستدامة

                    </p>

                </div>

            </div>

            <!-- End Single Item -->



            <!-- Single Item -->

            <div class="col-md-4 col-sm-6 equal-height">

                <div class="item">

                    <i class="fa fa-handshake-o" aria-hidden="true"></i>

                    <h4>تمكين رواد الاعمال</h4>

                    <p>

                        تمكين رواد الاعمال والمختصين من مسايرة المستجدات في

مجال ريادة الاعمال

                    </p>

                </div>

            </div>

            <!-- End Single Item -->

        </div>

</div>

</section>



{{-- About us --}}

<div class="container-fluid about_us wow fadeIn" id="about" data-wow-duration="1.5s">

<div class="row d-sm-flex align-items-center justify-content-between">

    <div class="col-lg-6 order-2 order-sm-1 p-3 p-sm-5">

        <div class="p-0 p-sm-5">

            {{-- <small class="text-uppercase" style="color: #9B5DE5;">BrandName</small> --}}

            <h1 class="mb-4 display-4" style="font-weight: 600;text-align: right">معلومات  <span style="color: #2d1166;">عنا</span></h1>

            <p class="text-secondary" style="line-height: 2;text-align: right">الجمعية المغربية لرواد الاعمال هي جمعية وطنية مستقلة تعنى

                بنلا ثقافة وتعزيز نشاطات وممارسات ريادة الاعمال وثقافة

                الابداع والابتكار والتميز في مختلف المستويات المحلية والعالمية

                تأسست الجمعية في دجنبر من سنة 2019 بمدينة طنجة بمبادرة

                <br> من مجموعة من المقاولين بجهة الشمال .



                ومن اجل تنزيل هذه الاهداف على ارض الواقع،

                وضعت الجمعية المخطط الاستراتيجي 2023~2020

                الذي يحدد اطارا للعمل و يبرز المحاور الكربى لعمل

                الجمعية خلال هذه السنوات الثلاثة

            </p>

        </div>

    </div>

    <div class="col-lg-6 order-1 order-sm-2">

        <img src="{{ asset('img/about_us.png') }}" width="100%" style="border-radius: 35px;box-shadow: 5px 5px 20px 0px;" alt="">

    </div>

</div>

</div>





<section class="page-section" id="about">

<div class="container">

    <div class="site-heading text-center">

        <h2 style="color: black"> <span>لجنة</span></h2>

    </div>

    <ul class="timeline">

        <li>

            <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img/co1.jpg" alt="...""></div>

            <div class="timeline-panel" style="text-align: right" style="text-align: right">

                <div class="timeline-heading">

                    <h4 class="subheading">:لجنة الدراسات والابحاث مهمتها</h4>

                </div>

                <div class="timeline-body">

                    <p class="text-muted">.انجاز دراسات وأبحاث في مجالات تهم مجال الاعمال <br> تبادل الانتاج العلمي والبحثي في موضوع ريادة

                        الاعمال عن طريق عقد الندوات والمؤتمرات العلمية

                        وتبادل الزيارات العلمية والمجالات <br> تقوية دور الجمعية في تقديم مقترحات و تحليل

                        الاشكالات التي تواجه المقاولات في مجالات متعددة <br> المساهمة في تقوية القوة الاقتراحية للمقاولات

                        الجمعيات المهنية من أجل تحسين مناخ الاعمال

                        على المستوى الجهوي و الوطني </p>

                </div>

            </div>

        </li>

        <li class="timeline-inverted">

            <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img/co2.jfif" alt="..."></div>

            <div class="timeline-panel" style="text-align: right">

                <div class="timeline-heading">

                    <h4 class="subheading">:لجنة التأطير والتكوين والتي عهد اليها</h4>

                </div>

                <div class="timeline-body"><p class="text-muted">.إعداد وتنزيل برنامج تكوين لفائدة المقاولات <br> التواصل مع المؤسسات المختصة في التكوين لعقد

                    اتفاقيات لااكة و تنظيم أنشطة مشترك <br>. إعداد دلائل تكوينية في مواضيع تهم حاجيات

                    المقاولات</p></div>

            </div>

        </li>

        <li>

            <div class="timeline-image"><img class="rounded-circle img-fluid" src="/img//co3.png" alt="..."></div>

            <div class="timeline-panel" style="text-align: right">

                <div class="timeline-heading">

                    <h4 class="subheading">لجنة التواصل والعلاقات العامة ومن اختصاصها </h4>

                </div>

                <div class="timeline-body"><p class="text-muted">وضع مخطط سنوي للتواصل والعلاقات العامة

                    و تنفيذه <br> التواصل مع الجمعيات المهنية والمؤسسات ذات

                    الصلة مع مجال اشتغال الجمعية من أجل عقد

                   اتفاقيات شراكة <br> تطوير الهوية البلاية للجمعية وتنزيلها على جميع

                    وسائط التواصل <br> إعداد وتوزيع وسائط تواصل الخاصة بالجمعية</p></div>

            </div>

        </li>



        <li class="timeline-inverted">

            <div class="timeline-image">

                <h4>

                    كن جزءًا

                    <br>

                    من

                    <br>

                    لجنتنا!

                </h4>

            </div>

        </li>

    </ul>

</div>

</section>



{{-- contact --}}

<section class="text-center contact about wow fadeIn" id="contact" data-wow-duration="1.5s">

<div class="overley"></div>

<div style="padding-top: 2pc;padding-bottom: 17px;">



  <div class="container">

    <div class="row">

      <div class="div_form_contact">

          <form action="{{ route('contact_us') }}" method="POST">

            @csrf

              <div class="form-group mb-4">

                <label for="exampleInputEmail1" style="color: black;float: right;">:الاسم الكامل </label>

                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="full_name" required="">

              </div>

              <div class="form-group mb-4">

                <label for="exampleInputEmail1" style="color: black;float: right;">:البريد الإلكتروني </label>

                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="email" required="">

              </div>

              <div class="form-group mb-4">

                <label for="exampleInputPassword1" style="color: black;float: right;">:الموضوع </label>

                <input type="text" class="form-control" name="subject" id="exampleInputPassword1" required="">

              </div>

              <div class="form-group mb-4">

                <label for="exampleInputPassword1" style="color: black;float: right;">:الرسالة </label>

                <textarea class="form-control" name="message" id="exampleFormControlTextarea1"  rows="3" required=""></textarea>

              </div>

              <button class="btn btn-primary btn-lg btn_contact" style="width:224px" type="submit">إرسال</button>

        </form>

      </div>



    </div>



  </div>



</div>

</section>



@endif





@endsection

@section('script')

    @if (!($errors->isEmpty()) || session('message'))

    <script type="text/javascript">

        setTimeout( function ( ) { $('.form-alerts').css('display','none'); }, 7000 );

    </script>

    @endif

@endsection

