<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="icon" href="<?= IMG . 'logo.png'  ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS . 'bootstrap.min.css'  ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS . 'bootstrap.min.css.map'  ?>">
    <link rel="stylesheet" href="<?= '/css/shortcut.css' ?>">
    <link rel="stylesheet" href="<?= '/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?= CSS . $lang . DS . "main.css" ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= CSS . $lang . DS . $file_css  . ".css"  ?>">
</head>
    <body>





<section class="main">
    <div class="container-page">

        <section class="part form flex-column">
            <figure class="w-100 flex justify-content-center p-10">
                <img src="<?= IMG . 'logo.png' ?>"
                     class="img-fluid" alt="login image">
            </figure>

            <form class="m-10 position-relative" method="POST">
                
<?php

use App\Core\Session;

$messages =  Session::flash("message");

if ($messages) {
    ?>
        <div class="container">
            <?php
                foreach ($messages as $message) {

                    $type = is_object($message[1]) ? strtolower($message[1]->name) : strtolower($message[1]);
                    $message = $message[0];
                    ?>
                    <div class="alert alert-<?= $type ?> between-element p-2 " kick-out="7000" role="alert">
                        <span class="flex f-align-center"><?= $message ?></span>
                    </div>
                    <?php
                }
            ?>
        </div>
    <?php


}
?>
                <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg main-color fa-fw"></i>
                    <div class="form-outline flex-fill mb-0 ">
                        <label class="form-label" for="Email"><?= $your_email ?></label>
                        <input type="email" id="Email" name="Email" value="feras@adm.ttu.edu.jo" class="form-control" />
                    </div>
                </div>

                <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg fa-fw main-color"></i>
                    <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="Password"><?= $password ?></label>
                        <input type="password" id="Password" name="Password" value="1234567" class="form-control" />
                    </div>
                </div>

                <div class=" w-full">
                    <button type="submit" name="login" class="btn m-auto main-btn btn-lg"><?= $title ?></button>
                </div>

            </form>
        </section>
        <section class="part description-section">
           <div class="layout pt-20 mt-20 between-element">
               <figure class="w-50 ">
                   <img src="<?= IMG . 'login.png' ?>"
                        class="img-fluid" alt="login image">
               </figure>

               <div class="w-50 hint">
                   <p class="">
                       <?= $hint ?>
                   </p>
               </div>
           </div>

            <div class="quotes">
                <div class="quote">
<!--                    <h4>--><?php //= $introduction ?><!--</h4>-->
                    <p>
                        <?= $introduction_content ?>
                    </p>
                </div>
                <div class="quote">
                    <h4><?= $purpose ?></h4>
                    <p>
                        <?= $purpose_content ?>
                    </p>
                </div>


            </div>
        </section>
    </div>
</section>




    <footer></footer>
    <script src="<?= JS . "main"      . ".js" ?>"></script>
    <script src="<?=  JS . "shortcut"  . ".js" ?>"></script>
    <script src="<?=  JS . "all.min"  . ".js" ?>"></script>
    <script src="<?=  BOOTSTRAP_JS . "bootstrap.bundle"  . ".js" ?>"></script>
    <script src="<?=  JS . $file_js  . ".js" ?>"></script>
    </body>
</html>