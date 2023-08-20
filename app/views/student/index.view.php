@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.AsideStudent')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-graduation-cap"></i>
        <span class="name-student">
            <span class=""><?= $user->FirstName . ' ' . $user->LastName ?></span>
        </span>
    </h1>

    @extend('layout.messages')@

</main>

@extend('layout.footer')@