@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">

    <h1 class="main-title">
        <i class="fa-solid fa-edit"></i>
        <span class="">
            Edit <?= $collage->CollegeName ?> Collage
        </span>
    </h1>

    @extend('layout.messages')@
    <div class="container mt-20">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/colleges/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i> To Colleges</button>
                </a>
            </div>
        </div>

        <div class="container-form">
            <form class="row g-3" method="POST" >
                <div class="col-md-12">
                    <label for="CollegeName" class="form-label mb-1">Collage Name</label>
                    <input type="text"
                           class="form-control"
                           id="CollegeName"
                           between="4,100"
                           name="CollegeName"
                           value="<?= $collage->CollegeName ?>"
                           required autocomplete="none"
                    >

                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Collage Name must between 5 and 100 character
                    </div>
                </div>

                <div class="col-12">
                    <button class="main-btn" name="edit" type="submit">Edit Collage</button>
                </div>
            </form>
        </div>

    </div>
</main>

@extend('layout.footer')@