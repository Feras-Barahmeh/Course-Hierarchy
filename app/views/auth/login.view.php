@extend('layout.header')@



<section class="main">
    <div class="container-page">

        <section class="part form flex-column">
            <figure class="w-100 flex justify-content-center p-10">
                <img src="<?= IMG . 'logo.png' ?>"
                     class="img-fluid" alt="login image">
            </figure>

            <form class="m-10 position-relative" method="POST">
                @extend('layout.messages')@
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

@extend('layout.footer')@