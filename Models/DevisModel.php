<?php

class DevisModel extends Model
{

    /**
     * Get one Devis from the DB
     * 
     * @param int $devisID
     * @return array $devis
     */
    public function getDevis($devisID)
    {
        $request = $this->connexion->prepare("SELECT d.*, l.id_article, 
            a.nom as nom_article, a.qty, a.prix_u, 
            c.nom_societe as nom_client, c.id as id_client, c.adresse_postale, c.adresse_electronique, 
            c.n_tva, c.siret, c.notes 
            FROM `devis` as d 
            JOIN liste_article as l ON d.id = l.id 
            JOIN client as c ON d.`id_client` = c.id 
            JOIN article as a ON a.id = l.id_article 
            WHERE d.id = :id");

        $request->bindParam(':id', $devisID);

        $result = $request->execute();
        $result = $request->fetchAll(PDO::FETCH_ASSOC);
        $devisList = [];

        foreach ($result as $line) {
            $devisList['devis']['id'] = $line['id'];
            $devisList['devis']['remise_com'] = $line['remise_com'];
            $devisList['devis']['taux_retard'] = $line['taux_retard'];
            $devisList['devis']['num_facture'] = $line['num_facture'];
            $devisList['devis']['date_echeance'] = $line['date_echeance'];
            $devisList['devis']['date_creation'] = $line['date_creation'];
            $devisList['devis']['date_validation'] = $line['date_validation'];
            $devisList['devis']['statut_valider'] = $line['statut_valider'];

            $devisList['client']['id_client'] = $line['id_client'];
            $devisList['client']['nom_client'] = $line['nom_client'];
            $devisList['client']['adresse_postale'] = $line['adresse_postale'];
            $devisList['client']['adresse_electronique'] = $line['adresse_electronique'];
            $devisList['client']['n_tva'] = $line['n_tva'];
            $devisList['client']['siret'] = $line['siret'];
            $devisList['client']['notes'] = $line['notes'];

            $devisList['liste_articles'][$line['nom_article']] = [
                "name" => $line['nom_article'],
                "qty" => $line['qty'],
                "prix_u" => $line['prix_u']
            ];
        }

        return $devisList;
    }


    /**
     * Deletes devis form the database
     *
     * @param int $devisID
     * @return void
     */
    public function deleteDevis($devisID)
    {
        // Deletes from association table
        $request = $this->connexion->prepare("DELETE FROM liste_article WHERE id=:id");
        $request->bindParam(':id', $devisID);
        $result = $request->execute();
        
        // Deletes from devis table
        $request = $this->connexion->prepare("DELETE FROM devis WHERE id=:id");
        $request->bindParam(':id', $devisID);
        $result = $request->execute();

    }

    /**
     * Adds a the list of articles to each devis
     *
     * @param array $devisList
     * @param array $articleList
     * @param array $associationTable
     * @return void
     */
    public function parseArticleListToDevis($devisList, $articleList, $associationTable)
    {
        foreach ($devisList as $devis) {
            $devis['articleList'] = array();

            foreach ($associationTable as $key => $link) {
                foreach ($articleList as $article) {
                    if ($article["id"] == $link['id_article']) {
                        var_dump($article["nom"]);
                        $devis['articleList'] = $article;
                    }
                }
            }
        }
    }

    public function addToDB()
    {
        if (isset($_POST)) {
            $id_client = $_POST["client"];
            if (!empty($_POST["remise_comm"])) {
                $remise_com = $_POST["remise_comm"];
            } else {
                $remise_com = 0;
            }

            if (!empty($_POST["taux_retard"])) {
                $taux_retard = $_POST["taux_retard"];
            } else {
                $taux_retard = 0;
            }

            $date_echeance = $_POST["date_echeance"];
            $date_creation = date("Y-m-d");
            $date_validation = "0000-00-00";
            $statut_valider = 0;
            $num_facture = 0;


            $request = $this->connexion->prepare("INSERT INTO `devis` 
            (`id`, `remise_com`, `taux_retard`, `date_echeance`, `num_facture`, `date_creation`, `statut_valider`, `date_validation`, `id_client` ) 
            VALUES 
            (NULL, :remise_com, :taux_retard, :date_echeance, :num_facture, :date_creation, :statut_valider, :date_validation, :id_client)");
            $request->bindParam(':remise_com', $remise_com);
            $request->bindParam(':taux_retard', $taux_retard);
            $request->bindParam(':date_echeance', $date_echeance);
            $request->bindParam(':num_facture', $num_facture);
            $request->bindParam(':date_creation', $date_creation);
            $request->bindParam(':statut_valider', $statut_valider);
            $request->bindParam(':date_validation', $date_validation);
            $request->bindParam(':id_client', $id_client);

            $result = $request->execute();

            $new_devis_id = $this->connexion->lastInsertId();
            $articles = $_POST["articles"];
            $request = $this->connexion->prepare("INSERT INTO `liste_article` (`id`, `id_article`) VALUES (:id, :id_article)");
            $request->bindParam(':id', $new_devis_id);
            $request->bindParam(':id_article', $id_article);

            foreach ($articles as $article) {
                $id_article = $article;
                $result = $request->execute();
            } 
            return $new_devis_id;
        }
    }


    public function updateStatus()
    {
        $id = $_POST['id'];
        $request = $this->connexion->prepare("UPDATE devis SET statut_valider=1 WHERE id=:id");
        $request->bindParam(':id', $id);
        $request->execute();
    }

    public function createDevisHTML($devisID)
    {
        $devis = $this->getDevis($devisID);
        $text_Devis = file_get_contents("pages/forms/Devis.html");

        $text_Devis = str_replace("{nom_societe}", $devis['client']['nom_client'], $text_Devis);
        $text_Devis = str_replace("{adresse_postale}", $devis['client']['adresse_postale'], $text_Devis);
        $text_Devis = str_replace("{id_devis}", $devis['devis']['id'], $text_Devis);
        $text_Devis = str_replace("{date_creation}", $devis['devis']['date_creation'], $text_Devis);
        
        $text_articles = "";
        foreach ($devis['liste_articles'] as $article) {

            $text_articles .= "<tr>";
            $text_articles .= "<td>";
            $text_articles .= $article['qty'];
            $text_articles .= "</td>";
            $text_articles .= "<td>";
            $text_articles .= $article['name'];
            $text_articles .= "</td>";
            $text_articles .= "<td>";
            $text_articles .= $article['prix_u'];
            $text_articles .= "</td>";
            $text_articles .= "</tr>";
        }
        $text_Devis = str_replace("{liste_produit}", $text_articles, $text_Devis);
        
        // Compute subtotal price
        $sub_total = 0;
        foreach ($devis["liste_articles"] as $article) {
            $sub_total += $article['qty'] * $article['prix_u'];
        }
        $text_Devis = str_replace("{sub_total_price}", $sub_total, $text_Devis);
        
        // Compute TVA
        $tva_amount = $sub_total*0.2;
        $text_Devis = str_replace("{tva}", $tva_amount, $text_Devis);
        
        // Remise en %
        $remise = $devis['devis']['remise_com'];
        $text_Devis = str_replace("{remise_com}", $remise, $text_Devis);
        
        $total_price = ($sub_total*1.2) - ($sub_total*1.2)*$remise/100;
        // Compute Total Price
        $text_Devis = str_replace("{total_price}", $total_price, $text_Devis);
        
        $text_Devis = str_replace("{date_echeance}", $devis['devis']['date_echeance'], $text_Devis);
        $text_Devis = str_replace("{penalite}", $devis['devis']['taux_retard'], $text_Devis);

        $file_name = "devis/devis_n_" . $devis['devis']['id'] . ".html"; 
        file_put_contents($file_name, $text_Devis);
        
        return $text_Devis;
    }

}
