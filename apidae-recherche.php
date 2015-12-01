<?php
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=id-to-validate.csv');
	header('Pragma: no-cache');
	
	$param = array(
		"apiKey"		=>	"XXXXXX", //Votre clé d'API du projet global du site internet
		"projetId"		=>	0000, //Votre identifiant du projet global du site internet
		"count"			=> 100,
		"communeCodesInsee" => array("XXXX","XXXX"), //Liste des communes ciblées ou territoire
		"searchFields" => "NOM", // Recherche uniquement sur le nom
		"criteresQuery" => "type:EQUIPEMENT type:HEBERGEMENT_COLLECTIF type:HEBERGEMENT_LOCATIF type:HOTELLERIE type:HOTELLERIE_PLEIN_AIR type:RESTAURATION", //Recherche sur les éléments Trip (hébergement et restaurant) : ) compléter si besoin
		"responseFields"=> array("id","nom") // Recherche de l'id et du nom
	);
	
	$sep = "\r\n";
	$csv = 'ID_TRIP,NOM_TRIP,ID_SITRA,NOM_SITRA'.$sep;
	
	/* Le fichier CSV fourni par Trip devrait être de la forme :
	LocationId; Nom; Adresse; Ville
	Si ce n'est pas le cas, BIEN REOORDONNER LES COLONNES dans cet ordre*/
	if (($handle = fopen("/chemin/absolu/vers/le/fichier/csv/fourni/par/TripAdvisor.csv", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$idTrip = $data[0];
			$name = $data[1];
			$adresse = $data[2];
			$city = $data[3];
			
			$param["searchQuery"] = $name;
			$url = 'http://api.sitra-tourisme.com/api/v002/recherche/list-objets-touristiques/?query='.urlencode(json_encode($param));
			$obj_sitra = json_decode(file_get_contents($url));			
			
			if ($obj_sitra->numFound > 0) {
				foreach ($obj_sitra->objetsTouristiques as $obj){
					$csv.=$idTrip.',"'.str_replace('"','\"',$name).'",'.$obj->id.',"'.str_replace('"','\"',$obj->nom->libelleFr).'"'.$sep;
				}				
			}
		}
		fclose($handle);
	}
	
	echo $csv;
?>