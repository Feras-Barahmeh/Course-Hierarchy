@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <?php
        $messages = \App\Core\Session::flash("message");

        if ($messages) {
            foreach ($messages as $message) {
                $type = strtolower($message[1]->name);
                $message = $message[0];
                ?>
                <div class="alert alert-<?= $type ?> between-element plr-20 " kick-out="5000" role="alert">
                    <span class="flex f-align-center"><?= $message ?></span>
                </div>
                <?php
            }
        }
    ?>
</main>

@extend('layout.footer')@