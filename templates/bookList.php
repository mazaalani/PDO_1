<?php
    //debug        
    echo '<pre>'; 
    //print_r($booksList );
    echo '</pre>'; 
?>

<div class="main-content">
<h1><?=$pageTitle?></h1>
    <div>
        <table>
            <tr>
                <th>No Livre</th>
                <th>Titre</th>
                <th>Nb Pages</th>
                <th>Auteur</th>
                <th>Catégorie(s)</th>
            </tr>
        
            <?php
                foreach ($booksList as $book) {
            ?>
            <tr>
                <td><?= $book['livre_id'] ?></td>
                <td><?= $book['livre_titre'] ?></td>
                <td><?= $book['livre_pages'] ?></td>
                <td><?= $book['livre_auteur'] ?></td>
                <td><?= $books->getCategories($book['livre_id']) ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
