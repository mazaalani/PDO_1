<?php

echo '<pre>';
//print_r($employesTable);
echo '</pre>';

?>
<div class='main-content'>
<h1><?=$pageTitle?></h1>
   <div>       
       <fieldset>
       <legend>Veuillez choisir un Employé:</legend>
            <form>
                <?php
                    foreach ($employesList as $employe) { ?>
                <button name="commande_createur_id" value=<?= $employe['employe_id'] ?>><?= $employe['employe_prenom']." ". $employe['employe_nom'] ?></button>
                <?php } ?>
                <input type="hidden" name="url" value="form">
            </form>
       </fieldset>
   </div>
</div>

