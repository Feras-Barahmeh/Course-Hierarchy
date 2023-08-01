@extend('layout.header')@

<section class="vh-100 bg" >

    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;background-color: #eee;" >
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">

                            <?php
                            $messages = \App\Core\Session::flash("message");


                            if ($messages) {
                                foreach ($messages as $message) {
                                    $type = strtolower($message[1]);
                                    $message = $message[0];
                                    ?>
                                    <div class="alert alert-<?= $type ?> between-element plr-20 " kick-out="6000" role="alert">
                                        <span class="flex f-align-center"><?= $message ?></span>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4"><?= $title ?></p>

                                <form class="mx-1 mx-md-4 position-relative" method="POST">



                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="Email"><?= $your_email ?></label>
                                            <input type="email" id="Email" name="Email" value="feras@stu.ttu.edu.jo" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="Password"><?= $password ?></label>
                                            <input type="password" id="Password" name="Password" value="1234567" class="form-control" />

                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" name="login" class="btn main-btn btn-lg"><?= $title ?></button>
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                     class="img-fluid" alt="Sample image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@extend('layout.footer')@