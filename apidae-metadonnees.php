<?php

	// Include Composer autoload
	include __DIR__."/../../../../vendor/autoload.php";

	$nodeId = 'XXXXX'; // Entrez le nom de votre noeud créé par OpenWide
	// Create the client
	$client = new \Sitra\ApiClient\Client([
		'projectId'     => 0000, //Votre identifiant du projet Métadonnée
		'baseUrl'       => 'http://api.sitra-tourisme.com/',
		'OAuthClientId' => 'XXXXXXXXXXXXXXXXXXXXXXX', //http://dev.sitra-tourisme.com/fr/documentation-technique/v2/oauth
		'OAuthSecret'   => 'XXXXXXXXXXXXXXXXXXXXXXX'
	]);

	/* Le fichier CSV validé doit être de la forme :
	ID_TRIP; NOM_TRIP; ID_SITRA; NOM_SITRA
	Si ce n'est pas le cas, BIEN REOORDONNER LES COLONNES dans cet ordre*/
	if (($handle = fopen("/chemin/absolu/vers/le/fichier/valide/par/l/OT.csv", "r")) !== FALSE) {
		$i = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			if ($i>0) { // S'il y a l'entête de colonne en première ligne, on ne la prend pas en compte
			
				$idTrip = intval($data[0]);
				$nameTrip = $data[1];
				$idSitra = intval($data[2]);
				$nameSitra = $data[3];
				
				try {
					$metadata = $client->putMetadata([
						'referenceId' => $idSitra,
						'nodeId' => $nodeId,
						'metadata' => [
							'general' => '{"locationId":"'.$idTrip.'","version":1}',
						]
					]);
					
				} catch (\Sitra\ApiClient\Exception\SitraException $e) {
					echo $e->getMessage();
					echo "\n";
					echo $e->getPrevious()->getMessage();
				}
				
			}
			
			$i++;
		}
		fclose($handle);
	}

	exit;
