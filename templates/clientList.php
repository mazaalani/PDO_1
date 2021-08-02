<?php

//DEBUG
echo '<pre>';
//print_r($clientsList);
echo '</pre>';

?>
<div class="main-content">
<h1><?=$pageTitle?></h1>
    <div>
        <fieldset>
            <legend>Veuillez choisir un client:</legend>
                <form>
                    <?php
                        foreach ($clientsList as $client) { ?>
                    <button name="client_id" value=<?= $client['client_id'] ?>><?= $client['client_prenom']." ". $client['client_nom'] ?></button>
                    <?php } ?>
                    <input type="hidden" name="url" value="findClient">
                </form>
        </fieldset>
    </div>
</div>