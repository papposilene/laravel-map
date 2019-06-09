<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App Language Lines
    |--------------------------------------------------------------------------
    |
    | 
    | 
    | 
    |
    */

    'appname' => 'The Bertin-Pierre Map',
    
    // Basic words
	'about' => 'A propos',
	'all' => 'tout',
	'addressesList' => 'liste des adresses',
    'admin' => 'administration',
	'add' => 'ajouter',
	'added' => 'ajouté',
	'address' => 'adresse',
	'by' => 'par',
	'categoriesList' => 'liste des catégories',
	'country' => 'pays',
    'countriesList' => 'liste des pays',
    'delete' => 'supprimer',
    'delAdd' => 'supprimer cette adresse',
    'delCat' => 'supprimer cette catégorie',
	'deleted' => 'supprimé',
	'description' => 'description',
	'edit' => 'éditer',
    'editAdd' => 'editer une adresse',
    'editCat' => 'editer une catégorie',
	'edited' => 'edité',
	'export' => 'exporter',
	'exported' => 'exporté',
	'expData' => 'exporter des données',
	'facultative' => 'facultatif',
	'home' => 'accueil',
	'import' => 'importer',
	'imported' => 'importé',
	'impData' => 'importer des données',
    'localized' => 'situé dans la zone',
	'name' => 'nom',
	'navigation' => 'navigation',
	'new' => 'nouveau',
	'newAdd' => 'ajouter une adresse',
    'newCat' => 'ajouter une catégorie',
    'newCou' => 'ajouter un pays',
	'no' => 'non',
    'none' => 'aucun',
    'nothing' => 'Aucun résultat !',
	'obligatory' => 'obligatoire',
    'officially' => 'officiellement',
	'old' => 'ancien',
	'restore' => 'récupérer',
	'restored' => 'restauré',
	'save' => 'enregistrer',
	'saved' => 'enregistré',
	'search' => 'rechercher',
	'title' => 'titre',
    'update' => 'mettre à jour',
	'updated' => 'mis à jour',
    'under' => 'sous',
	'user' => 'utilisateur',
    'website' => 'site internet',
	'with' => 'avec',
    'without' => 'sans',
	'yes' => 'oui',
	
	// Form
	'exportedColumns' => 'Les données exportées sont les suivantes',
    'supportedColumns' => 'Pour le traitement des données, sont acceptées, au choix, les colonnes suivantes',
	'form' => 'formulaire',
	'formAddress' => 'adresse',
	'formCategory' => 'catégorie',
	'formCca2' => 'code CCA2 (ex. US, FR, IR, JP, PF)',
	'formCca3' => 'code CCA3 (ex. USA, FRA, IRN, JPN, PYF)',
	'formCountry' => 'pays',
	'formDescription' => 'description',
	'formExportFile' => 'exporter un fichier',
	'formExportFrom' => 'fichier à exporter',
	'formExportType' => 'exformations à importer',
	'formImportFile' => 'importer un fichier',
	'formImportFrom' => 'fichier à importer',
	'formImportType' => 'informations à importer',
    'formIcon' => 'icône',
    'formColor' => 'couleur',
	'formName' => 'nom',
    'formPhone' => 'téléphone',
    'formSlug' => 'slug',
	'formTitle' => 'titre',
	'formUuid' => 'identifiant',
	'formUrl' => 'site internet',
	'formGeoloc' => 'géolocalisation',
    
    // Instructions
    'expInstruction' => 'Cette section vous permet d’exporter vos données personnelles, à savoir les pays dans lesquels vous avez enregistré des adresses,
        vos catégories personnelles et les adresses que vous avez ajoutées à votre carte.',
    'delInstruction' => 'pour supprimer cette information, .',
    'newAddInstruction' => 'veuillez commencer par trouver le lieu à ajouter à votre carte en lançant une recherche avec la carte ci-dessous. Une fois le lieu
        trouvé, il vous faudra ensuite vérifier les informations récupérées, les modifier voire les compléter dans les différents champs du formulaire.',
    'updAddInstruction' => 'vous pouvez mettre à jour le nom, l’adresse, les coordonnées (téléphone et site internet), la catégorie ainsi que la description de cette adresse.',
    'newCatInstruction' => 'pour créer une nouvelle catégorie, il vous suffit d’en choisir le nom et l’icône puis de renseigner une description.',
    'updCatInstruction' => 'vous pouvez mettre à jour le nom, l’icône et la description de cette catégorie.',
	
	// Results
	'addSuccess' => 'ajout des données réalisé avec succès !',
	'expSuccess' => 'exportation des données réalisée avec succès !',
	'impSuccess' => 'importation des données réalisée avec succès !',
	'updSuccess' => 'mise à jour des données réalisée avec succès !',
	'delSuccess' => 'suppression des données réalisée avec succès !',
	'resSuccess' => 'restauration des données réalisée avec succès !',
	'addFail' => 'echec de l’ajout des données !',
	'expFail' => 'echec de l’exportation des données !',
	'impFail' => 'echec de l’importation des données !',
	'updFail' => 'echec de la mise à jour des données !',
	'delFail' => 'echec de la suppression des données !',
	'resFail' => 'echec de la restauration des données !',
    
    // Map
    'africa' => 'Afrique',
	'americas' => 'Amériques',
	'asia' => 'Asie',
	'europa' => 'Europe',
	'oceania' => 'Océanie',
    'geoloc' => 'géolocalisation',
    'cooloc' => 'coordonnées',
	
    // Admin: databases
	'appTotalData' => 'l’ensemble des :data enregistrés dans notre base de données s’élève à :count.',
    'userNoData' => 'Par contre, vous n’avez encore enregistré :data.',
	'userTotalData' => 'quant au nombre de :data que vous avez sauvegardés dans notre base de données, il contient :count enregistrements.',
	'userMgmt' => 'gestion des utilisateurs',
    'databases' => 'bases des données',
	'dtbMgmt' => 'gestion des bases de données',
    'dataset' => 'jeu de données',
	'dtsMgmt' => 'gestion des jeu de données',
	
	// Pluralizations
	'addresses' => '{0} aucune adresse|{1} adresse|[2,*] adresses',
    'categories' => '{0} aucune catégorie|{1} catégorie|[2,*] catégories',
	'countries' => '{0} aucune pays|{1} pays|[2,*] pays',
	'datas' => '{0} aucune donnée|{1} donnée|[2,*] données',
	'lists' => '{0} aucune liste|{1} liste|[2,*] listes',
	'types' => '{0} aucun type|{1} type|[2,*] types',
	'users' => '{0} aucun utilisateur|{1} utilisateur|[2,*] utilisateurs',
	
	// Placeholders to complete
    'nbAddresses' => ':number adresses',
	'createdat' => 'Créé le :date',
	'updatedat' => 'Mis à jour le :date',
	'deletedat' => 'Supprimé le :date',
	
	// Social networks
    'facebook' => 'Facebook',
    'flickr' => 'Flickr',
	'github' => 'Github',
	'lastfm' => 'LastFM',
	'linkedin' => 'LinkedIn',
	'instagram' => 'Instagram',
	'snapchat' => 'Snapchat',
	'twitter' => 'Twitter',
	
];
