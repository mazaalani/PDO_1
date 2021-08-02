<?php
//DEBUG
echo '<pre>';
//print_r($selectedEmployee);
//print_r($selectedOrder);
//print_r($status);
//print_r($orderBookList);
echo '</pre>';
?>
<div class='main-content'>
<h2>Bureau de <?= $employe_prenom.' '.$employe_nom ?></h2>
    <div>
        <fieldset>
            <legend>Details</legend>
        
            <form method="POST" class='order-form'>
                <label for="commande_id">commande_id :</label>
                <input type="text" id="commande_id" name="commande_id" value="<?= $commande_id ?? ''; ?>" placeholder='#' disabled>
                <label for="date">Date :</label>
                <input type="text" id="date" name="date" placeholder='AAAA-MM-JJ' value="<?= $date ?? ''; ?>" required/>
                <label for="date_retour">Date de retour: </label>
                <input type="text" id="date_retour" name="date_retour" value="<?= $date_retour ?? ''; ?>" placeholder='AAAA-MM-JJ' required/>
                <label for="commande_status_id">Status :</label>
                <select name="commande_status_id" id="commande_status_id">
                    <?php
                        foreach ($status as $stat) {
                            foreach ($stat as $key => $value) {
                                $$key = $value;
                            }                           
                    ?>
                        <option value="<?= $status_id  ?>" <?php if($status_id  == $commande_status_id) echo 'selected' ?>>
                        <?= $nom_status ?> </option>
                    <?php } ?>
                </select>
                <label for="commande_client_id">Client: </label>
                <select  id="commande_client_id" name="commande_client_id">
                    <?php
                        foreach ($clientsList as $client) {
                            foreach ($client as $key => $value) {
                                $$key = $value;
                            }
                    
                    ?>
                        <option value="<?= $client_id?>" 
                        <?php if($selectedOrder) if($client_id == $commande_client_id ){ echo "selected";} ?>>
                        <?= $client_prenom.' '.$client_nom?></option>
                    <?php }  ?>
                </select>                
                <label for="commande_createur_id">Créer Par: </label>
                <input  id="commande_createur_id" name="commande_createur_id" value="<?= $commande_createur_id ?? $employe_id ?>" disabled>
                <label <?= $noHide ?> for="livre_id"><strong> Choisissez un livre à rajouter :</strong></label>                
                <select <?= $noHide ?> class='green' name="livre_id" id="livre_id">
                <option value=""><?= ' -- ' ?> </option>
                    <?php
                        foreach ($booksList as $book) {
                            foreach ($book as $key => $value) {
                                $$key = $value;
                            } ?>
                        <option value="<?= $livre_id ?>"><?= $livre_titre ?> </option>
                        <button></button>
                    <?php } ?>
                </select>
              
                <input type="submit" name="save" value="Sauvegarder"/>
                <input type="<?= isset($commande_id) ? 'submit' : "hidden" ; ?>" name="delete" value="Supprimer" />
                <input type="hidden" name="url" value="insertOrder"/>                
            </form>
            <small>*Rajout de livres à la commande disponible aprés la creation de la commande en cliquant sur 'Modifier'</small><br>
            <small style='color:red'>ATTENTION: Vous ne pouvez modifier / supprimer que les commandes crées par vous même!</small>
        </fieldset>
        
        <fieldset <?= $hide ?>>
            <legend>Commandes</legend>
            <table>
                <tr>
                    <th>No Commande</th>
                    <th>Date</th>
                    <th>Date Retour</th>
                    <th>Commande Status</th>
                    <th>Commande Agent</th>
                    <th>Action</th>
                </tr>
                <?php
                       foreach ($ordersList as $ord) {
                           foreach ($ord as $key => $value) {
                               $$key = $value;
                           }
                    
                    ?>
                <tr>
                    <td><?= $commande_id ?></td>
                    <td><?= $date  ?></td>
                    <td><?= $date_retour  ?></td>
                    <td><?= $order->setStatus($commande_id )  ?></td>
                    <td><?= $commande_createur_id == $employe_id ? 'MOI' :  $commande_createur_id; ?></td>
                    <?php if ($commande_createur_id == $employe_id) { ?>
                    <td> <a href="index.php?commande_createur_id=<?= $employe_id ?>&url=form&commande_id=<?= $commande_id ?>">Modifier</a></td> 
                    <?php } else { ?>
                        <td> - </td>
                    <?php } 
                        }?>                   
                </tr>
                
            </table>
        </fieldset>

        <fieldset <?= $noHide ?>>
            <legend>Livres</legend>
            <form method="POST" class='order-form'>
                
            </form>
            <table>
            <tr>
                <th>No Livre</th>
                <th>Titre</th>
                <th>Nb Pages</th>
                <th>Auteur</th>
                <th>Catégorie(s)</th>
            </tr>
        
            <?php
                foreach ($orderBookList as $b) {
                    foreach ($b as $key => $value) {
                        $$key = $value;
                    } ?>
            <tr>
                <td><?= $livre_id ?></td>
                <td><?= $livre_titre ?></td>
                <td><?= $livre_pages ?></td>
                <td><?= $livre_auteur ?></td>
                <td><?= $theBook->getCategories($livre_id) ?></td>
            </tr>
            <?php } ?>
            </table>
        </fieldset>
    </div>
</div>