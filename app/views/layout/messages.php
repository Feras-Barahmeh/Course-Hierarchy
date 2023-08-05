<div class="container">
    <?php

    use App\Core\Session;

    $messages =  Session::flash("message");
    if ($messages) {
        foreach ($messages as $message) {
            $type = strtolower($message[1]);
            $message = $message[0];
            ?>
            <div class="alert alert-<?= $type ?> between-element plr-20 ptb-10 " kick-out="5000" role="alert">
                <span class="flex f-align-center"><?= $message ?></span>
            </div>
            <?php
        }
    }
    ?>
</div>
