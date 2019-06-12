### ---------------------------- première remarque --------------------------------------

## 1. installation de laravel data table :

--> suivre ce link :
https://yajrabox.com/docs/laravel-datatables/master#configuration

## 2. installation  de laravel-datatable-buttons

composer require yajra/laravel-datatables-buttons:^4.*


Service Provider (Optional on Laravel 5.5)
Yajra\DataTables\ButtonsServiceProvider::class

Configuration and Assets (Optional)
$ php artisan vendor:publish --tag=datatables-buttons --force

And that's it! Start building out some awesome DataTables!


##NB : les deux commandes suivant  ne fonctionne pas a cause d'une erreur au  niveau de la version 
 composer require yajra/laravel-datatables-buttons:^3.0
 composer require yajra/laravel-datatables-buttons:^4.0
--> donc pour corriger le pb il suffit de mettre 4.* au lieux de 4.0

### ---------------------------- end première remarque --------------------------------------
### ----------------------------  deuxiemme remarque --------------------------------------7
## 2. parametre de la langue FR

1. ajouter dans 'public\datatables\' le fichier 'fr.json'
2. dans chaque classe sous le repertoire 'App\DataTables' ajouter la conf suivantes : 
						( dans html function )
$htmlBuilder->parameters(
[ "language" => [ 
			// Fr language file in  local  folder 
            'url' => Url('datatables/fr.json'), 
            // CDN language file 
            'url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json'

		] 
])



----------------- Others way - second method  ---------

to set DataTable language Globaly add this section to 'ressources/views/layouts/datatables_js.blade.php'
NB: add this in the end of doc


<!-- Data table General -->
<script type="text/javascript">
	(function ($, DataTable) {

    // Datatable global configuration
    $.extend(true, DataTable.defaults, {
        language: {
	"sProcessing":     "Traitement en cours...",
	"sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
	"sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
	"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
	"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
	"sInfoPostFix":    "",
	"sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
	"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
	"oPaginate": {
		"sFirst":      "Premier",
		"sPrevious":   "Pr&eacute;c&eacute;dent",
		"sNext":       "Suivant",
		"sLast":       "Dernier"
	},
	"oAria": {
		"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
		"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
	},
	"select": {
        	"rows": {
         		"_": "%d lignes s&eacute;lectionn&eacute;es",
         		"0": "Aucune ligne s&eacute;lectionn&eacute;e",
        		"1": "1 ligne s&eacute;lectionn&eacute;e"
        	}  
	}
}
    });

})(jQuery, jQuery.fn.dataTable);
</script>
<!-- End data table General -->
### ---------------------------- end deuxiemme remarque --------------------------------------


composer require caouecs/laravel-lang:~3.0
link : https://github.com/caouecs/Laravel-lang
make language for laravel



###  Auth  log 
link  : https://packagist.org/packages/yadahan/laravel-authentication-log


### Gestion  des permissions sous laravel  avec  la package : Spatie Laravel Permission Package
link  : https://github.com/spatie/laravel-permission