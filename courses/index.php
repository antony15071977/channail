<?php
require_once('config.php');
$isFirst = true;
$a=1;
$sql = 'SELECT * FROM commentos  WHERE NOT moderation = 0 ORDER BY rand() LIMIT 7';
$res = mysqli_query($connect, $sql);
if ($res) {
    $comments = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($connect);
    print('Ошибка MySQL: '.$error);
}
?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <title>Школа маникюра ООО"ШАННЭЙЛ 4"</title>
    <meta property="og:type" content="website" >
    <meta property="og:url" content="https://courses.channail4.com" >
    <meta property="og:image" content="https://channail4.com/courses/img/favicon.jpg" >
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta property="og:site_name" content="Школа маникюра ШАННЭЙЛ 4">
    <meta property="og:description" content="Школа маникюра ШАННЭЙЛ 4. Авторская школа маникюра в Москве Кутикульное Царство. Очное и онлайн обучение маникюрному искусству.">
    <meta name="description" content="Авторская школа маникюра в Москве Кутикульное Царство. Очное и онлайн обучение маникюрному искусству.">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/flickity.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link href='css/style.css' rel='stylesheet' type='text/css'>
    <link href='index.php' rel='shortlink'>
    <link href="img/favicon.jpg" rel="icon">
    <link rel="canonical" href="https://courses.channail4.com/">
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
</head>
<body class="home">
<main>
    <section class="top">
        <a href="/" class="top_logo"><img height="159" width="178" alt="logo" src="img/logo.png"></a>
        <picture>
            <source class="top_background_mobile" srcset="img/top_fon_mobile.png" width="499" height="947" media="(max-width: 499px)">
            <source class="" srcset="img/top_fon_767.png" width="767" height="854" media="(max-width: 767px)">
            <img alt="back" src="img/top_fon2.png" width="1024" height="1476" class="top_background">
        </picture>
        <div class="top_info">
            <div class="top_info_name">
                <h2 class="top_h2">кутикульное<br>царство</h2>
                <h1 class="top_h1">Школа маникюра<br>Ирины Креминской</h1>
            </div>
            <p class="top_p">С 2000 года на рынке<br>
                лицензированный учебный<br>
                центр <span>№041083</span>,<br>
                более 10 000 выпускников по всему миру,<br>
                3 запатентованные технологии,<br>
                12 авторских прав, международные<br>
                курсы, франчайзинг
            </p>
            <a href="modals/modal-main.php" target="_blank" class="top_button open-modal" data-modal="#modal1" data-url="modals/modal-main.php">УЗНАТЬ БОЛЬШЕ</a>
            <p class="top_question">Хотите стать конкурентно
                <br class="hide_499">
                способным и уникальным
                <br class="hide_499">
                мастером на рынке NAIL?</p>
            <p class="top_answer">Школа CHANNАIL4 - лицензированный учебный центр
                с запатентованной технологией маникюра “Глубокая нить”.
                Наша уникальность - анатомический маникюр.
                “Глубокая нить” удовлетворяет все потребности кожи.
                Накопительный процесс от техники приводит
                к приостановке роста околоногтевой кожи,
                скорости 1 палец - 1 минута и тройной носибельности.
                В основе технологии лежит плёночная анатомия.</p>
            <picture>
                <source class="top_answer_499_img" srcset="img/patent374.png" width="374" height="242" alt="patent_mob" media="(max-width: 374px)">
                <img class="top_answer_499_img" src="img/patent767.png" width="315" height="200" alt="patent_mob" >
            </picture>
        </div>
        <div class="top_answer_767">
            <div class="top_answer_767_wrap">
                <p class="top_answer_767_text">Школа CHANNАIL4 - лицензированный учебный центр
                с запатентованной технологией маникюра “Глубокая нить”.
                Наша уникальность - анатомический маникюр.
                “Глубокая нить” удовлетворяет все потребности кожи.
                Накопительный процесс от техники приводит
                к приостановке роста околоногтевой кожи,
                скорости 1 палец - 1 минута и тройной носибельности.
                В основе технологии лежит плёночная анатомия.</p>
            </div>
            <img class="top_answer_767_img" src="img/patent767.png" alt="patent" width="360" height="230">
        </div>
    </section>
    <picture>
        <source class="studying" alt="studying" srcset="img/studying_mob.png" width="499" height="120"  media="(max-width: 374px)">
        <img class="studying" alt="studying" src="img/studying.png" width="1024" height="246">
    </picture>
    <section class="courses">
        <div class="courses_item">
            <div class="courses_item_info">
                <h3 class="courses_item_h3">“Основы<br>слайсинга”</h3>
                <p class="courses_item_p">+ педикюр</p>
                <h4 class="courses_item_h4">“Мокасиновая<br>стопа 1.0”</h4>
                <picture>
                    <source class="courses_item_img" srcset="img/course1_mob.png" width="325" height="89" alt="course1_mob" media="(max-width: 374px)">
                    <img class="courses_item_img" src="img/course1.png" alt="course1" width="1024" height="281">
                </picture>
            </div>
            <a class="courses_item_button open-modal" href="modals/modal-1.php" target="_blank" data-modal="#modal1" data-url="modals/modal-1.php">... ПОДРОБНЕЕ</a>
        </div>
         <div class="courses_item">
            <div class="courses_item_info">
                <h3 class="courses_item_h3">“1 форма<br><span>анатомической<br>фрезы”</span></h3>
                <p class="courses_item_text">Все виды<br>сухого маникюра</p>
                <picture>
                    <source class="courses_item_img" srcset="img/course2_mob.png" width="325" height="89" alt="course2_mob" media="(max-width: 374px)">
                    <img class="courses_item_img" src="img/course2.png" alt="course1" width="1024" height="281">
                </picture>
            </div>
            <a class="courses_item_button open-modal" href="modals/modal-2.php" target="_blank" data-modal="#modal1" data-url="modals/modal-2.php">... ПОДРОБНЕЕ</a>
        </div>
         <div class="courses_item">
            <div class="courses_item_info">
                <h3 class="courses_item_h3">
                    <span class="courses_item_nail">МАНИКЮР</span><br>
                    “Марафон<br>
                    <span class="courses_item_perfect">перфекциониста”</span>
                    <p class="courses_item_text">Все виды сухого<br>и мокрого<br>маникюра</p>
                </h3>
                <picture>
                    <source class="courses_item_img" srcset="img/course3_mob.png" width="325" height="89" alt="course3_mob" media="(max-width: 374px)">
                    <img class="courses_item_img" src="img/course3.png" alt="course1" width="1024" height="281">
                </picture>
            </div>
            <a class="courses_item_button" href="https://marafon-channail4.ru/" target="_blank">... ПОДРОБНЕЕ</a>
        </div>
         <div class="courses_item">
            <div class="courses_item_info">
                <h4 class="courses_item_h4">
                    <span class="courses_item_nail">ПЕДИКЮР</span><br>
                    “Мокасиновая<br>
                    стопа 2.0”</h4>
                <picture>
                    <source class="courses_item_img" srcset="img/course4_mob.png" width="325" height="89" alt="course4_mob" media="(max-width: 374px)">
                    <img class="courses_item_img" src="img/course4.png" alt="course1" width="1024" height="281">
                </picture>
            </div>
             <a class="courses_item_button open-modal" href="modals/modal-5.php" target="_blank" data-modal="#modal1" data-url="modals/modal-5.php">... ПОДРОБНЕЕ</a>
        </div>
    </section>
    <a class="top_button open-modal" href="modals/indoor/modal-indoor.php" target="_blank" data-modal="#modal1" data-url="modals/time.php">РАСПИСАНИЕ ЗАНЯТИЙ</a>
    <section class="why">
        <p class="why_question">ПОЧЕМУ&nbsp;ВЫБИРАЮТ<br><span>CHANNAIL’4</span></p>
    </section>
    <section class="reasons">
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="30" height="73" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">КОНКУРЕНТНОСПОСОБНАЯ УСЛУГА</h5>
            </div>
            <p class="reasons_text">“Глубокая нить” сделает из вас конкурентноспособного мастера. Вы сможете предложить клиенту услугу маникюра с приостановлением роста околоногтевой кожи. У вашего маникюра будет редкая отличительная особенность - долгая носибельность.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">21 ГОД АНАТОМИЧЕСКИХ ИССЛЕДОВАНИЙ</h5>
            </div>
            <p class="reasons_text">21 долгий год мы изучали анатомию, проводили исследования, патентовали свои изобретения. Весь этот долгий путь и приобретённый опыт мы вложили в свои курсы и делимся с вами.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">СОБСТВЕННОЕ ПРОИЗВОДСТВО АНАТОМИЧЕСКИХ ИНСТРУМЕНТОВ ПОД ТЕХНИКИ</h5>
            </div>
            <p class="reasons_text">Для работы в наших запатентованных техниках нужны такие же уникальные инструменты. Поэтому у нас собственное производство из титановой имплантовой нержавеющей стали. Каждый инструмент выполнен так, что не нарушает анатомии плёнок, а работает по ней. Маникюр инструментами “CHANNAIL’4” абсолютно атравматичен.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">РАЗРАБОТКА НОВОЙ АНАТОМИИ ГЛУБИНЫ</h5>
            </div>
            <p class="reasons_text">Долгие годы разработок и учений привели нас к новой анатомии глубины. В основе 3 пленки - кутикула, птеригий и эпонихий. Мы работаем, не нарушая природные процессы, подчиняясь анатомии, мы берем власть над кожей.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">АНАТОМИЧЕСКИЙ МАНИКЮР</h5>
            </div>
            <p class="reasons_text">Мы исключили всё, что может нанести вред околоногтевой коже и выявили методы, позволяющие добиться её приостановки и оздоровления.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">ПРИОСТАНОВЛЕНИЕ РОСТА <br class="show_499">ОКОЛОНОГТЕВОЙ КОЖИ</h5>
            </div>
            <p class="reasons_text">При работе в техниках “Глубокой нити” кожа оздаравливается, перестает травмироваться, рубцеваться и приостанавливает рост. Это революция на NAIL рынке. Мы говорим “нет” заусенцам, птеригию и кутикуле. Мы говорим “да” долгой носибельности и здоровому маникюру.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">СКОРОСТЬ:  1 ПАЛЕЦ  -  21 СЕКУНДА</h5>
            </div>
            <p class="reasons_text">Приручение кожи к анатомическому ороговению и выход на экспресс скорость: 1 палец - 21 секунда.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">НОСИБЕЛЬНОСТЬ</h5>
            </div>
            <p class="reasons_text">Наши техники накопительные, после 3-4 процедур маникюра, начинается приостановка роста околоногтевой кожи, за счет чего увеличивается носибельность. А наша авторская техника покрытия “Anderвстык” с птеригием позволяет ходить с гель-лаком от месяца, так как рост кутикулы опережает рост покрытия. Пленки уже ороговели, а гель-лак по-прежнему внутри.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">ТРЕНИНГ ПРОДАЖ</h5>
            </div>
            <p class="reasons_text">Мы учим правильно подать и продать новую услугу. Клиент больше никогда не будет искать вам замену.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">ПОВЫШЕНИЕ ПРАЙСА НА 100%</h5>
            </div>
            <p class="reasons_text">Мастера, владеющие техникой “ Глубокая нить” поднимают прайс минимум в 2 раза, не распугав при этом клиентов. Дело в том, что мы не повышаем цены без оснований. Вы даете клиенту право выбора: носить обычный маникюр или с эффектом приостановления роста кожи. Покрывать гель-лаком или техникой “Anderвстык”, которая носится в 2 раза дольше.</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">ПОДДЕРЖКА УЧЕНИКОВ</h5>
            </div>
            <p class="reasons_text">После окончания мы продолжаем поддерживать связь с учениками и интересоваться их успехами. У нас есть специальные чаты, где выпускники делятся лайфхаками, а инструктор консультирует и отвечает на вопросы. В течении полугода выпускники могут посещать открытые уроки (бесплатно) и практики (платно), где ещё раз можно отработать технику и получить обратную связь от инструктора. Мы растем сами и помогаем развиваться вам!</p>
        </div>
        <div class="reasons_item">
            <div class="reasons_box">
                <picture>
                    <source class="reasons_img" srcset="img/half_mob.png" width="49" height="95" alt="reasons_img" media="(max-width: 499px)">
                    <img class="reasons_img" src="img/half.png" alt="reasons_img" width="39" height="87">
                </picture>
                <h5 class="reasons_name">ДИЗАЙНЕРСКИЙ УЧЕБНЫЙ ЦЕНТР <br class="show_499">В МОСКВЕ</h5>
            </div>
            <p class="reasons_text">В “CHANNAIL’4” просторный дизайнерский класс. Выбор пал на желтый цвет. Именно в него ученые  и психологи советуют красить учебные студии, потому что именно этот оттенок оказывает стимулирующее воздействие на участки мозга, отвечающие за память.</p>
        </div>        
    </section>
    <a href="modals/modal-main.php" target="_blank" class="top_button open-modal" data-modal="#modal1" data-url="modals/modal-main.php">ЗАПИСАТЬСЯ НА АНАТОМИЧЕСКИЕ КУРСЫ</a>
    <section class="video">
        <h6 class="video_h6">ВИДЕО О ШКОЛЕ</h6>
        <p class="video_p">Окунитесь в интереснейший и захватывающий мир маникюрного искусства!</p>
        <div class="video_frame">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/TQk7qrvAdec" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" loading="lazy" allowfullscreen></iframe>
        </div>
    </section>
    <section class="regalies">
        <hr class="regalies_hr">
        <h6 class="video_h6">НАШИ ЗАСЛУГИ</h6>
        <div class="regalies-block">
            <a href="img/patent/0.jpg" class="regalies-block_item"><img src="img/patent/0.jpg" class="regalies-block_img"></a>
            <a href="img/patent/1a.jpg" class="regalies-block_item"><img src="img/patent/1.jpg" class="regalies-block_img"></a>
            <a href="img/patent/2a.jpg" class="regalies-block_item"><img src="img/patent/2.jpg" class="regalies-block_img"></a>
            <a href="img/patent/3a.jpg" class="regalies-block_item"><img src="img/patent/3.jpg" class="regalies-block_img"></a>
            <a href="img/patent/4a.jpg" class="regalies-block_item"><img src="img/patent/4.jpg" class="regalies-block_img"></a>
            <a href="img/patent/5a.jpg" class="regalies-block_item"><img src="img/patent/5.jpg" class="regalies-block_img"></a>
            <a href="img/patent/6a.jpg" class="regalies-block_item"><img src="img/patent/6.jpg" class="regalies-block_img"></a>
            <a href="img/patent/7a.jpg" class="regalies-block_item"><img src="img/patent/7.jpg" class="regalies-block_img"></a>
            <a href="img/patent/8a.jpg" class="regalies-block_item"><img src="img/patent/8.jpg" class="regalies-block_img"></a>
            <a href="img/patent/9a.jpg" class="regalies-block_item"><img src="img/patent/9.jpg" class="regalies-block_img"></a>
            <a href="img/patent/10a.jpg" class="regalies-block_item"><img src="img/patent/10.jpg" class="regalies-block_img"></a>
            <a href="img/patent/11a.jpg" class="regalies-block_item"><img src="img/patent/11.jpg" class="regalies-block_img"></a>
            <a href="img/patent/12a.jpg" class="regalies-block_item"><img src="img/patent/12.jpg" class="regalies-block_img"></a>
            <a href="img/patent/13a.jpg" class="regalies-block_item"><img src="img/patent/13.jpg" class="regalies-block_img"></a>
        </div>
    </section>
    <section class="faq">
        <div class="faq_lent">
            <h6 class="video_h6">ОТВЕТЫ НА ЧАСТЫЕ ВОПРОСЫ</h6>
        </div>
        <img class="accordeon_tumbler" alt="tumbler" width="42" height="34" src="img/arr.png">
        <div class="faq_accordeon">
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">СКОЛЬКО НУЖНО УЧИТЬСЯ, ЧТОБЫ СТАТЬ ПРОФЕССИОНАЛОМ?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <div class="panel-body">
                        <p>Занятия максимально приближены к индивидуальным. После их завершения вы уже становитесь универсальным мастером. Далее ваш уровень профессионализма зависит от домашней практики. Если не хотите дальше развиваться самостоятельно, то мы с радостью вам с этим поможем. В CHANNAIL’4 есть ступени профессионального роста от “Базы” до “Инструктора”. Это наш совет вам, каким путём пойти, чтобы достичь 100% успеха.</p>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">ПРАВДА ЛИ, ЧТО В ВАШЕЙ ШКОЛЕ ЕСТЬ СКИДКИ НА ОБУЧЕНИЕ?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Правда, у нас существует программа лояльности. Скидка будет зависеть от того, какой курс вы приобретаете и как скоро внесли предоплату.скидки и акции.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Можно ли пропускать занятия во время обучения?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Категорически нет, вы прерываете единую цепочку.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Что нужно брать с собой на занятия?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>В зависимости от того, на какой курс вы записаны. Подробнее уточните у менеджера.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Проводите ли вы пробные занятия?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Пробных занятий в CHANNAIL'4 нет. Но вы можете ознакомиться с нашим <a href="https://www.instagram.com/chan_nail4school/" style="color: #ff9800;">Instagram</a> (там много видео о, том, как проходит учебный процесс). Также все, что вас интересует, вы можете узнать у нашего менеджера. Если вы до сих пор сомневаетесь, то смело просите ее включить видеосвязь и провести вам онлайн экскурсию.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Какой сертификат вы выдаете после окончания обучения?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Учебный центр сертификаты, лицензии и дипломы установленного образца.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Нужно ли искать моделей для практических занятий?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Школа предоставляет разных моделей все дни обучения самостоятельно. Это делается для того, чтобы вы смогли отработать технику на разных типах кутикулы.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Я живу далеко, что будет, если я опоздаю?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Опоздания не приветствуются. Просим вас заранее планировать свое время.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Дает ли ваша школа гарантию трудоустройства?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>После прохождения даже одного базового курса, вас примут на работу в любой салон. Мастеров, владеющих техникой приостановки роста, единицы. Такой сотрудник очень ценен на рынке.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Есть ли доплаты за обучение?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Для безопасной работы на глубине в наших техниках нужен анатомический инструмент. Перед курсом его нужно будет приобрести у нас в школе. В прямой продаже его нет.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Как происходит запись на курс?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Нажмите на кнопку "Записаться" и оставьте ваши данные в предложенной форме. Либо оставьте ваши данные (достаточно номера телефона) у нас в директе в <a href="https://www.instagram.com/chan_nail4school/" style="color: #ff9800;">Instagram</a>. Далее с вами свяжется менеджер, чтобы индивидуально подобрать курс для вас, и предложит перевести предоплату на расчетный счет компании.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Если я из другого города, вы поможете найти жилье рядом с вами?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Мы поможем вам с поиском жилья, учитывая наше местоположения и ваши расценки.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Я новичок, у кого подробно все узнать?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Звоните, менеджер проконсультирует вас и под ваши знания подберет курс</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Я хочу быть инструктором, что для этого нужно?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Для того, чтобы сделать карьеру в «Глубокой нити», нужно пройти все ступени от «Базы» до «Инструктора», дойти до приостановки роста, получить лицензию и пройти собеседование с нашим инструктором.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Могу ли я обучать людей после курса?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Конечно же, нет. На все техники, методики, тексты и названия у нас есть патенты и авторские права.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Можно подобрать курс по моему бюджету? </a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Конечно. Есть различные варианты решения этого вопроса. Мы можем предложить вам курс бюджетнее или посоветовать пройти не всю программу, а лишь ту часть, которая вам необходима. Также есть вариант рассмотреть онлайн обучение. Главное начать работать в нашей методике.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Почему у вас нет индивидуального обучения?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Коллективная работа приносит больше знаний и опыта в системе «Глубокой нити». Каждая модель - новый эксперимент с кожей. Находясь в группе ученицы получают больше информации и практического опыта. </p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Почему так мало дней обучения?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>«Глубокая нить» подразумевает чёткий регламент срезов, движений и определенную их последовательность. Каждый из этапов прорабатывается на курсе достаточное количество времени. Важно лишь освоить схему и вы уже с первого раза получите идеально чистый валик. </p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Что такое «слайсинг»? </a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Слайсинг – новый мокрый вид маникюра. Вместо щипка – выталкивающие движения вверх тупыми щипцами. Вместо среза – сепарация целостной пленки. В основе метода слайсинга лежит пленочная анатомия. «Слайсинг» выполняется анатомическими щипчиками геометрической формы полотна, притупленными на фетре для скоростного скольжения по подкутикулью. Существует три вида слайсинга: кутикульный, птеригийный и синусный.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Что такое «анатомическая фреза»?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>«Анатомическая фреза» – новая трапецивидная форма фрезы с плоским донышком и абразивной боковой поверхностью. Работает отдельно с каждой пленкой на низких оборотах (15000 оборотов/мин). Горлышко шлифует внутреннюю поверхность кутикулы, донышко измельчает ороговевший слой птеригия, превратив его в мелкую тырсу, не повредив при этом эпонихий.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Что такое 3-я глубина?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Глубина – расстояние от кутикулы до внутреннего подкутикулья,измеряемое в миллиметрах. 3-ая- самая глубокая. До неё нельзя добиться обычными инструментами - это может быть опасно. Анатомические инструменты CHANNAIL4 позволяют работать с 3-ей глубиной абсолютно атравматично.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Что значит скорость 1 палец - 21 секунда?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Время обработки одного пальца анатомической фрезой составляет 21 секунду. Метод выведен в ходе экспериментов с кожей. Речь идёт не о поверхностной обработки, а об чистом маникюре в 3-ей глубине.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <a href="#">Что такое «сепарация»?</a>
                </div>
                <div class="panel-collapse" style="display: none;">
                    <p>Сепарация - атравматичный манёвр в технике «слайсинг». Замена травматичному «щипку» в классическом маникюре. Синоним к слову сепарация - разделение. Маневр отделяет точечные чешуйки с основного валика, формируя целостную плёнку кутикулы. Благодаря сепарации, через 3-4 встречи формируется целостная плёнка, которую мы слайсингуем одним легким движением. </p>
                </div>
            </div>
        </div>
    </section>
    <section class="reviews">
        <div class="reviews-block">
            <h3 class="reviews-block_heading">ОТЗЫВЫ</h3>
            <div class="reviews-block_control-container">
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"><svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 0 50 L 20 0 H 27 L 8 47 L 85 47 L 85 53 L 8 53 L 27 100 H 20 Z" class="arrow"></path></svg></span>
                    <span class="sr-only">Previous</span>
                </a>
                
                <p id="number" class="carousel-caption_number">1</p>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"><svg class="flickity-button-icon" viewBox="0 0 100 100"><path d="M 0 50 L 20 0 H 27 L 8 47 L 85 47 L 85 53 L 8 53 L 27 100 H 20 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="reviews-block_slider-container">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="li active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1" class="li"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2" class="li"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3" class="li"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="4" class="li"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="5" class="li"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="6" class="li"></li>
                    </ol>

                    <div class="carousel-inner">

                        <?php foreach ($comments as $comment): ?>
                            <div data-index-number="<?= $a++; ?>" class="carousel-item <?= $isFirst ? 'active' : '' ?>">
                                <p class="comment_text"><?= $comment['comment_text']; ?></p>
                                <p class="comment_name"><?= $comment['name'] ?></p>
                            </div>
                        <?php $isFirst = false; ?>
                        <?php endforeach; ?>

                    </div> 
                </div>
            </div>
        </div>
        <a href="modals/modal-review.php" target="_blank" class="top_button open-modal" data-modal="#modal1" data-url="modals/modal-review.php">ОСТАВИТЬ ОТЗЫВ</a>
    </section>
    <section class="instruments">
        <div class="pre-instrument">
            <div class="pre-instrument_lent">
                <h6 class="pre-instrument_instr">ИНСТРУМЕНТЫ</h6>
            </div>
            <p class="pre-instrument_channail">“СНАNNAIL4”</p>
            <hr class="pre-instrument_hr">
            <p class="pre-instrument_p">В нашем лицензированном учебном центре есть собственная линия анатомических инструментов под технику «Глубокая нить». Основной компонент – титан. Гипоаллергенные, лёгкие, удобные в использовании из титановой имплантовой стали.  70% работы они сделают за вас.</p>
        </div>
        <div class="carusel">
            <div class="carousel" data-flickity='{ "contain": true, "prevNextButtons": true,  "wrapAround": true, "cellAlign": "left", "arrowShape": "M 0 50 L 20 0 H 27 L 8 47 L 85 47 L 85 53 L 8 53 L 27 100 H 20 Z", "autoPlay": 4500 }'>
              <div class="carousel-cell">
                <div class="carousel-cell_container">
                    <picture>
                        <source loading="lazy" class="carousel-cell_img" data-flickity-lazyload="img/ship_mob.png" srcset="img/ship_mob.png" width="197" height="278" media="(max-width: 499px)">
                        <img loading="lazy" alt="ship" width="256" height="363" src="img/ship.png" class="carousel-cell_img" data-flickity-lazyload="img/ship.png"> 
                    </picture>
                    <p class="carousel-cell_name">щипчики<br>для слайсинга</p>
                    <p class="carousel-cell_description">Без острых кончиков, притупленные на фетре, полностью исключают вероятность травмирования.</p>
                </div>
              </div>
              <div class="carousel-cell">
                <div class="carousel-cell_container">
                    <picture>
                        <source loading="lazy" class="carousel-cell_img" data-flickity-lazyload="img/blade_mob.png" srcset="img/blade_mob.png" width="197" height="278" media="(max-width: 499px)">
                        <img loading="lazy" alt="blade" width="256" height="363" src="img/blade.png" class="carousel-cell_img" data-flickity-lazyload="img/blade.png">  
                    </picture>
                    <p class="carousel-cell_name">titanium<br>BLADE</p>
                    <p class="carousel-cell_description">Очищает пластину от птеригия и подготавливает ее к обработке, не создавая пропилов.</p>
                </div>
              </div>
              <div class="carousel-cell">
                <div class="carousel-cell_container">
                    <picture>
                        <source loading="lazy" class="carousel-cell_img" data-flickity-lazyload="img/kist_mob.png" srcset="img/kist_mob.png" width="197" height="278" media="(max-width: 499px)">
                        <img loading="lazy" alt="kist" width="256" height="363" src="img/kist.png" class="carousel-cell_img" data-flickity-lazyload="img/kist.png"> 
                    </picture>
                    <p class="carousel-cell_name">титановая кисть<br>со съемным<br>наконечником</p>
                    <p class="carousel-cell_description">Сделана из синтетического ворса, не пачкает кутикулу.</p>
                </div>
              </div>
              <div class="carousel-cell">
                <div class="carousel-cell_container">
                    <picture>
                        <source loading="lazy" class="carousel-cell_img" data-flickity-lazyload="img/pilka_mob.png" srcset="img/pilka_mob.png" width="197" height="278" media="(max-width: 499px)">
                        <img loading="lazy" alt="pilka" width="256" height="363" src="img/pilka.png" class="carousel-cell_img" data-flickity-lazyload="img/pilka.png">  
                    </picture>
                    <p class="carousel-cell_name">титановая<br>пилка из<br> имплантовой<br>стали</p>
                    <p class="carousel-cell_description">Основа для сменных файлов. Хорошо заходит в подногтевой карман.</p>
                </div>
              </div>
              <div class="carousel-cell">
                <div class="carousel-cell_container">
                    <picture>
                        <source loading="lazy" class="carousel-cell_img" data-flickity-lazyload="img/lopat_mob.png" srcset="img/lopat_mob.png" width="197" height="278" media="(max-width: 499px)">
                        <img loading="lazy" alt="lopat" width="256" height="363" src="img/lopat.png" class="carousel-cell_img" data-flickity-lazyload="img/lopat.png">  
                    </picture>
                    <p class="carousel-cell_name">титановая<br>лопатка для<br>педикюра</p>
                    <p class="carousel-cell_description">Основа для сменных файлов. Покрыта карбоновым напылением.</p>
                </div>
              </div>
              <div class="carousel-cell">
                <div class="carousel-cell_container">
                    <picture>
                        <source loading="lazy" class="carousel-cell_img" data-flickity-lazyload="img/anat_mob.png" srcset="img/anat_mob.png" width="197" height="278" media="(max-width: 499px)">
                        <img loading="lazy" alt="anat" width="256" height="363" src="img/anat.png" class="carousel-cell_img" data-flickity-lazyload="img/anat.png"> 
                    </picture>
                    <p class="carousel-cell_name">Двусторонняя<br>анатомическая<br>лопатка</p>
                    <p class="carousel-cell_description">Чистит ногтевую пластину от птеригия.</p>
                </div>
              </div>
              <div class="carousel-cell">
                <div class="carousel-cell_container">
                    <picture>
                        <source loading="lazy" class="carousel-cell_img" data-flickity-lazyload="img/freza_mob.png" srcset="img/freza_mob.png" width="197" height="278" media="(max-width: 499px)">
                        <img loading="lazy" alt="anat" width="256" height="363" src="img/freza.png" class="carousel-cell_img" data-flickity-lazyload="img/freza.png">
                    </picture>
                    <p class="carousel-cell_name">Анатомическая<br>фреза</p>
                    <p class="carousel-cell_description">Не пропиливает ноготь, не прижигает околоногтевую кожу.</p>
                </div>
              </div>
            </div>
        </div>
    </section>
    <section class="interview">
        <h6 class="pre-instrument_channail">ИНТЕРВЬЮ</h6>
        <div class="interview_container">
            <div class="interview_lent"></div>
            <div class="interview_inner_container">
                <p class="interview_general_p">Генеральный директор проекта «CHANNAIL4»</p>
                <div>
                    <picture>
                        <source class="interview_img" alt="interview" srcset="img/irina_mob.png" width="499" height="120"  media="(max-width: 499px)">
                        <img class="interview_img" alt="interview" src="img/irina.png" width="512" height="683">
                    </picture>
                </div>
                <div>
                    <p class="interview_p">Ирина Креминская прошла путь от мастера маникюра до генерального директора проекта «CHANNAIL4». Ирина является востребованным международным тренером с 20-ти летним опытом и маркетологом компании «CHANNAIL4». За её плечами сотни мастер-классов в городах России и Украины и тысячи успешных мастеров.</p>
                </div>
            </div>
            <picture>
                <source class="interview_fon" alt="interview_fon" srcset="img/interview_fon_mob.png" width="499" height="120"  media="(max-width: 499px)">
                <img class="interview_fon" alt="interview_fon" src="img/interview_fon.png" width="113" height="429">
            </picture>
        </div>
        <div class="interview_text">
            <p class="interview_text_question">Ирина, здравствуйте. Сейчас вы генеральный директор школы CHANNAIL, но насколько нам известно, раньше вы были мастером маникюра. Расскажите, с чего начался ваш карьерный рост?</p>
            <p class="interview_text_answer">Я прошла долгий путь, чтобы добиться того, что имею сейчас. Каждый день я думаю о том, что нужно сделать, чтобы завтра было лучше. Все началось с того, что мама купила мне щипчики, оплатила курс по маникюру и сказала дальше идти самостоятельно.<br>С этих щипчиков и началась история создания школы. Курсы давались трудно, я многое не понимала, но в итоге выучилась и стала принимать клиентов на дому.
            </p>
            <p class="interview_text_question">
                Какие были ваши первые цели на тот момент?
            </p>
            <p class="interview_text_answer">Я постоянно ставила себе цели и работала целыми днями, чтобы их достичь. Одной из них была шуба. Я очень ее хотела, поэтому рассчитала сколько клиентов в день должна принимать, чтобы ее купить. В итоге мечта была осуществлена, но за ней последовали и другие.</p>
            <div class="interview_text_hidden" style="display: none;">
                <p class="interview_text_question">Когда вас стала интересовать анатомия околоногтевой кожи?</p>
                <p class="interview_text_answer">Я трудилась и наблюдала. Говорила с кожей, не отвлекаясь на беседы с клиентом. Мне стало интересно что она скрывает, и я углубилась в анатомию.</p>
                <p class="interview_text_question">Откуда взялась идея отрабатывать технику на лимонах?</p>
                <p class="interview_text_answer">Посещая разные курсы для профессионального роста, я поняла, что у меня блок, боязнь работать щипцами, страх причинить боль клиенту. Так родилась идея с лимонами. Я стала отрабатывать «щипковую» технику на них.</p>
                <p class="interview_text_question">Как происходил ваш внутренний личностный рост?</p>
                <p class="interview_text_answer">Окружив себя успешными людьми, которые в основным были моими клиентами, я поняла, что нужно двигаться дальше. Я стала ходить на тренинги личностного роста, откуда в последствии у меня сложилась картина мира.<br>Курсы по маникюру я больше не посещала. Мне достаточно было одного раза понять, что везде одно и тоже, и ответы на свои вопросы придется искать самостоятельно. Тогда пришло осознание, что нужно всегда полагаться только на себя.</p>
                <p class="interview_text_question">Откуда истоки создания «Глубокой нити»?</p>
                <p class="interview_text_answer">Одна из моих клиенток доцент кафедры менеджмента и маркетенга была моим научным руководителем и предложила писать дипломную работу на тему «Конкурентноспособное предприятие». Я стала задавать себе вопросы: «Чем я лучше других? Почему должны выбрать именно меня?». Не найдя ответа и собственной уникальности, я твердо решила создать то, что будет отличаться от всех на рынке. Так я начала работать над научной работой «Глубокой нитью».<br>Готовясь к чемпионату с моделью, я поняла, что произошла приостановка роста и выход на скорость 1 палец – 1 минута. Это было первое доказательство того, что моя новая анатомия глубины, действительно, работает. Так я открыла школу в Днепропетровске. Но не сразу, а постепенно, собирая ее по кирпичикам и выверяя каждую деталь.<br>Я строила систему, основываясь на своем личном примере. Люди верили мне, потому что я давала им то, через что прошла сама.</p>
                <p class="interview_text_question">Расскажите о своей работе в Украине</p>
                <p class="interview_text_answer">Там мне удалось добиться ошеломляющего успеха. Я получила патент на новизну и ездила по всей стране с курсами, в школу была запись на полгода вперед.</p>
                <p class="interview_text_question">Почему же вы решили переехать в Москву, если были так успешны?</p>
                <p class="interview_text_answer">Вскоре, я поняла, что достигла потолка и просто задыхаюсь от нехватки возможностей и перспектив. Я хотела расти, собрать собственную команду, вывести школу на новый уровень, открыть франшизу, упаковаться красиво. Но мне нужен был какой-то толчок, так как я находилась в нагретой зоне комфорта. И в январе 2018 года пришли два явных знака свыше. Я получила патент на изобретение в РФ, который ждала 8 лет, тогда окончательно и решила переехать в Москву.<br>В этот момент я вынашивала два дитя: проект школы и дочку под сердцем. Переезд дался непросто. Полгода беременная я ездила по курсам в Украине, работая и откладывая на мечту.<br>В июне переехала. С августа проводила курсы, собирая по 12 человек, в сентябре все столы уже были забиты, а в октябре 30 числа родила дочку.<br>И вот я здесь, продолжаю свой путь. Много целей уже выполнила, поставила новые, которые постепенно открываю для вас. 20 лет, работая в красивом бизнесе, мы не останавливаемся, а продолжаем расти с каждым днем.</p>
                <p class="interview_text_question">Вас пугает кризис?</p>
                <p class="interview_text_answer">Нет. Любой кризис – катализатор будущего. Нужно быть устойчивым в любых обстоятельствах. Я воспринимаю его как возможность остановиться, перевести дыхание и положить начало абсолютно новому пути.</p>
                <p class="interview_text_question">Ирина, что вы можете посоветовать мастерам?</p>
                <p class="interview_text_answer">Менять технологии, думать в других форматах, найти свои слабые места и отработать их.<br>Даже, работая в маленьком красивом бизнесе, можно добиться многого, главное замечать знаки.</p>
                <p class="interview_text_question">Ирина, о чем вы сейчас мечтаете? Какие перспективы рассматриваете?</p>
                <p class="interview_text_answer">Я мечтаю, чтобы как можно больше мастеров и школ узнали о существовании моей техники, могли не только овладеть ей, но и преподавать, построить бизнес вместе с нами, стать часть команды перфекционистов. Сейчас у всех уже есть такая возможность. Мы разработали уникальное предложение по фрайчазингу. Скоро все узнают о маникюре будущего в запатентованной технике «Глубокая нить».</p>
            </div>
            <div class="interview_text_points interview_text_question">...</div>
        </div>
    </section>    
    <section class="bottom">
        <hr class="hr_pre">
        <p class="contacts">ПРИСОЕДИНЯЙТЕСЬ К УСПЕШНОЙ КОМАНДЕ ВЫПУСКНИКОВ&nbsp;CHANNAIL’4</p>
        <div class="contact_icons">
            <div class="contact_icons_img"><a href="tel:+79855861415"></a></div>
            <div class="contact_icons_img"><a href="https://www.instagram.com/chan_nail4school/" rel="nofollow" target="_blank"></a></div>
            <div class="contact_icons_img"><a
                    href="https://wa.me/79855861415?text=Здравствуйте%2C%20хотела%20бы%20узнать%20" rel="nofollow"
                    target="_blank"></a></div>
        </div>
    </section>
    <section class="footer">
        <div class="footer_agree-container">
            <p class="pre-instrument-info"><strong>ФАКТИЧЕСКИЙ АДРЕС:</strong></p>
            <a class="footer_agree" href="https://goo.gl/maps/JGh8HRBvWjLcQhPm6" rel="nofollow" target="_blank">Москва, Краснопресненская набережная д.12, Центр Международной Торговли, 6 подъезд.<br>Вход со стороны Мантулинской улицы. Офис 422, 4 этаж. м.Деловой центр</a>
        </div>
        <div class="footer_info_container">
            <div class="footer_info_block">
                <p class="pre-instrument-info"><strong>ИП КРЕМИНСКАЯ И.Ю.</strong></p>
                <p class="pre-instrument-info">Адрес: г.Москва, поселок Толстопальцево, ул.Ленина, д.28, кв.1</p>
                <p class="pre-instrument-info">ИНН 972703148973</p>
                <p class="pre-instrument-info">ОКПО:2000553389</p>
                <p class="pre-instrument-info">ОГРНИП: 319774600726296</p>
                <p class="pre-instrument-info">Расчетный счет: 40802810738000074331</p>
                <p class="pre-instrument-info">Банк: ПАО Сбербанк</p>
                <p class="pre-instrument-info">БИК: 044525225</p>
                <p class="pre-instrument-info">Корр. счет: 30101810400000000225</p>
                <p class="pre-instrument-info">Телефон: (898551715449), 89855861415</p>
                <p class="pre-instrument-info">Email: <a href="mailto:Channail4office@yandex.ua" class="elementor-heading-title elementor-size-default">Channail4office@yandex.ua</a>
                </p>
            </div>
            <div class="footer_info_block">
                <p class="pre-instrument-info"><strong>ООО «ШАННЭЙЛ 4 НЭЙЛ КУТЮР»&nbsp; </strong></p>
                <p class="pre-instrument-info">Юр. адрес: 123112, г. Москва,&nbsp; набережная Пресненская&nbsp; д.8,
                    стр.1, комн.2, ч.пом.513м, э.51</p>
                <p class="pre-instrument-info">ИНН 9703001389</p>
                <p class="pre-instrument-info">КПП 770301001</p>
                <p class="pre-instrument-info">ОГРН 1197746551540</p>
                <p class="pre-instrument-info">Телефон: +7 (985) 586-14-15</p>
                <p class="pre-instrument-info">Email: <a href="mailto:Channail4office@yandex.ua" class="elementor-heading-title elementor-size-default">Channail4office@yandex.ua</a>
                </p>
                <p class="pre-instrument-info"><strong>Генеральный директор Креминская Ирина Юрьевна</strong></p>
            </div>
        </div>
        <div class="footer_agree-container">
            <a href="agreement.html" target="_blank" class="footer_agree">Согласие на обработку персональных данных</a>
            <a href="oferta.html" target="_blank" class="footer_agree">Договор оферты</a>
            <a href="privacy.html" target="_blank" class="footer_agree">Политика защиты персональной информации</a>
        </div>
        <div class="modal" id="modal1">
            <a class="close-modal" data-modal="#modal1" href="#" style="display: none;">
                <img src="img/close.png" width="30" class="modal_close"></a>
            <div class="modal__content">
            </div>
        </div>
    </section>
</main>
<script src="js/jquery.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/slider.js"></script>
<script src="js/magnific-popup.js"></script>
<script src="js/popup.js"></script>
<script src="js/flickity.pkgd.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.regalies-block').magnificPopup({
          delegate: 'a',
          type: 'image',
          tLoading: 'Loading image #%curr%...',
          mainClass: 'mfp-img-mobile',
          gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] 
          },
          image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            }
        });
    });
</script>
</body>
</html>