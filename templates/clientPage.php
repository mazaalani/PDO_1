<main>
<?php
//DEBUG
echo '<pre>';
//print_r($clientSelected);
//print_r($clientCommandes);
echo '</pre>';
?>
<div class='main-content'>   
<h2>Bienvenue <?= $clientSelected['client_prenom'].' '.$clientSelected['client_nom'] ?></h2> 
    <div>
        <fieldset>
            <legend>Profile</legend>
            <form method="POST" class='order-form'>
                <input type="hidden" name="client_id" value="<?= $client_id; ?>" <?= $disabled; ?>>
                <label for=""> Prenom : </label>                
                <input type="text" name="client_prenom" value = "<?= $client_prenom; ?>" maxlength="45" required/>
                <label for=""> Nom : </label>           
                <input type="text" name="client_nom" value = "<?= $client_nom; ?>" maxlength="45"/>
                <label for=""> Email : </label>              
                <input type="email" name="client_email" value = "<?= $client_email; ?>" maxlength="45"/>
                <label for=""> Phone :</label>
                <input type="text" name="client_phone" value = "<?= $client_phone; ?>" maxlength="20" />
                <label for=""> Addresse : </label>
                <input type="text" name="client_address" value = "<?= $client_address; ?>" maxlength="45" />
                <label for=""> User name : </label>
                <input type="text" name="client_username" value = "<?= $client_username; ?>" maxlength="45" />
                <label for=""> Mot de passe : </label>
                <input type="text" name="client_pass" value = "<?= $client_pass; ?>" maxlength="45" />

                <input type="submit" value="Save">                
                <input type="hidden" name="url" value="modifClient"/>
            </form>
        </fieldset>
        <fieldset>
            <legend>Commandes</legend>
            <table>
            <?php if($clientCommandes) {?>
            <tr>
                <th>No Commande</th>
                <th>Date</th>
                <th>Date Retour</th>
                <th>Status</th>
            </tr>
                <?php foreach ($clientCommandes as $command) {
                        foreach ($command as $key => $value) {
                            $$key = $value;
                        }?>
                            <tr>
                                <td><?= $commande_id ?></td>
                                <td><?= $date ?></td>
                                <td><?= $date_retour ?></td>
                                <td><?= $commande->setStatus($commande_id) ?></td>
                            </tr>
                <?php }
            } else echo 'Aucune commande' ?>
            </table>
        </fieldset>
    </div>
</div>
</main>

