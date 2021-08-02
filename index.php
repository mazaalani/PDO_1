<?php
    //Modele architecture inspiré du MVC (fait avant la seance 10)
    require_once ('./class/CRUD.php');
    require_once ('./class/Livre.php');    
    require_once ('./class/Commande.php');    
    require_once ('./class/Client.php');
    require_once ('./class/Employe.php');
    require_once ('./class/Status.php');
    require_once ('./class/CHL.php');
    
    //réception du paaramètre url, qui peut arriver en GET ou en POST (et donc nous utiliserons $_REQUEST)
    if(isset($_REQUEST["url"]))
    {
        $url = $_REQUEST["url"];
    }
    else
    {
        //assigner une url par défaut -- typiquement l'url qui mène à la page d'accueil
        $url = "home";
    }

    //redirection et traitement en fonction de la requete
    switch ($url) {
        case 'home':
            $pageTitle = 'Accueil';
            require_once("./templates/head.php");
            require_once("./templates/homePage.php");                
            require_once("./templates/footer.php");
            break;
        
        case 'book': //tout les livres
            $pageTitle = 'Collection';    
            $books = new Livre();
            $booksList = $books->select();
            require_once("./templates/head.php");
            require_once("./templates/bookList.php");                
            require_once("./templates/footer.php");
            break;        
                
        case 'client': // liste des clients
            $pageTitle = 'Liste Clients';
            $clients = new Client();
            $clientsList = $clients->select();
            require_once("./templates/head.php");
            require_once("./templates/clientList.php");                
            require_once("./templates/footer.php");
            break;
        
        case 'findClient': //espace client
            $pageTitle = 'Espace Client';
            if (isset($_REQUEST['client_id']) and !empty($_REQUEST['client_id'])) {
                $clients = new Client ();
                $clientSelected = $clients->selectId($_REQUEST['client_id']);
                $clientCommandes = $clients->getCommandes($_REQUEST['client_id']);    
                $commande = new Commande;            
                $disabled = null;
                foreach ($clientSelected as $key => $value) {
                 $$key = $value;
                }
                require_once("./templates/head.php");
                require_once("./templates/clientPage.php");                
                require_once("./templates/footer.php");
            } else {
                //action non traitée, commande invalide -- redirection
                header("Location: index.php");
            }
            break;

        case 'modifClient':
            $pageTitle = 'Moficiation Client'; 
            
            foreach ($_REQUEST as $key => $value) {
                $$key = $value;
            }
            //table avec les elements du tableau client uniquement
            $req = $_REQUEST;
            unset($req['url']);
            $client = new Client();

            $update = $client->update('client', $req, 'client_id', $client_id);
            $display = $update;
           

            require_once("./templates/head.php");
            require_once("./templates/insertOrder.php");                
            require_once("./templates/footer.php");            
            break;    
        
        case 'employe': //liste des employes
            $pageTitle = 'Employés';
            $employes = new Employe();
            $employesList = $employes->select();
            require_once("./templates/head.php");
            require_once("./templates/employeList.php");                
            require_once("./templates/footer.php");
            break;
        
        case 'form': //espace employe pour gestion commandes
            $pageTitle = 'Back Office';
            $commande_id = $date = $date_retour = $commande_status_id = $commande_client_id = $commande_createur_id = $selectedOrder = null;
            $disabled = "disabled";
            if (isset($_REQUEST['commande_createur_id']) and !empty($_REQUEST['commande_createur_id']) ) {
                $employes = new Employe();
                $selectedEmployee = $employes->selectId($_REQUEST['commande_createur_id']);   
                //data de l'employé pour l'interface personnalisée
                foreach ($selectedEmployee as $key => $value) {
                    $$key = $value;
                } 
                //data pour afficher les status des commandes
                $statusInstance = new Status();
                $status = $statusInstance->select();
                //data pour afficher les clients
                $clients = new Client();
                $clientsList = $clients->select();
                //data commandes 
                $order = new Commande;
                $ordersList = $order->select();
                if (isset($_REQUEST['commande_id']) and !empty($_REQUEST['commande_id'])) {
                    //data de la commande selectionnées dans la liste
                    $selectedOrder = $order->selectId($_REQUEST["commande_id"]);
                    foreach ($selectedOrder as $key => $value) {
                        $$key = $value;
                    } 
                    $orderBookList = $order->getLivres($commande_id);
                    //data des livres (pour rajout)
                    $theBook = new Livre();
                    $booksList = $theBook->select();
                    $hide = 'style =" display:none;"';
                    $noHide = '';
                } else {
                    $disabled = null;
                    $hide = '';
                    $noHide = 'style =" display:none;"';
                }
                require_once("./templates/head.php");
                require_once("./templates/employePage.php");                
                require_once("./templates/footer.php");
            } else {
                //action non traitée, commande invalide -- redirection
                header("Location: index.php");
            }
            break;
        
        case 'insertOrder':
            $pageTitle = 'État Demande'; 
            foreach ($_REQUEST as $key => $value) {
                $$key = $value;
            }
            //table avec les elements du tableau commande uniquement
            $req = $_REQUEST;
            unset($req['url'], $req['delete'], $req['livre_id'], $req['save']); 
            //si commande existante
            if(isset($commande_id) and !empty($commande_id)) {                             
                $order = new Commande();
                //si suppression
                if(isset($delete)) {
                    //chercher tout le slivres de la commande et effacer le lien commande_has_livre en 1er
                    $CommandeHasLivre = new CHL(); 
                    $orderBooks = $CommandeHasLivre->selectAll($commande_id);
                    if(count($orderBooks) > 0){
                        foreach ($orderBooks as $book) {
                            $CommandeHasLivre->delete('commande_has_livre', 'commande_livre_id', $book['commande_livre_id']);
                        }
                    }
                    //supprime la commande
                    $delete = $order->delete('commande', 'commande_id', $commande_id,'commande_createur_id', $commande_createur_id );
                    $display = $delete;
                //si non modification
                }else{
                    //si ajout livre rajouter commande has livre
                    if(isset($livre_id) and !empty($livre_id)) {
                        $CommandeHasLivre = new CHL(); 
                        $display = $CommandeHasLivre->insert("commande_has_livre", array( 'commande_commande_id' => $commande_id, 
                                                                        'commande_commande_createur_id' => $commande_createur_id,
                                                                        'commande_livre_id' => $livre_id,));
                    //si non mise a jour details commande
                    } else {
                        $update = $order->update('commande', $req, 'commande_id', $commande_id);
                        $display = $update;
                    }
                }
            //si nouvelle commande
            }else{   
                $CommandeHasLivre = new CHL();   
                $display = $CommandeHasLivre->insert("commande", $req);
            } 
            require_once("./templates/head.php");
            require_once("./templates/insertOrder.php");                
            require_once("./templates/footer.php");            
            break;      
        
        default: 
            //action non traitée, commande invalide -- redirection
            header("Location: index.php");
            break;
    }
?>