<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestion d'annuaire</title>
	<link rel="stylesheet" type="text/css" href="View/assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="View/assets/style.css">
	<link rel="stylesheet" type="text/css" href="View/assets/jqTree/css/jqtree.css">
	<link rel="stylesheet" href="View/assets/bootstrap-select.min.css">
</head>
<body>
	<div id="page_title">Mini Annuaire</div>


	<div class="col-sm-1"></div>
		<div id="categorie_container" class="col-sm-10 form-group container">
			<div class="col-sm-4">
				<div class="subtitle"><h3>Catégories</h3></div>
				<div>
					<button type="button" id="add_categorie" class="btn btn-primary btn-lg" ><span class="glyphicon glyphicon-plus"></span>Ajouter</button>
					<button type="button" id="edit_categorie" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-edit"></span>Modifier</button>
					<button type="button" id="delete_categorie" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-trash"></span>Supprimer</button>
				</div>
				<div id="arbre_categorie" style="margin: 2%;font-style: italic;">
					
				</div>
			</div>
			<div class="col-sm-8 container_fiche" style="background-color: white;">
				<div class="subtitle"><h3>Fiches</h3></div>
				<div>
					<button type="button" id="add_fiche" class="btn btn-primary btn-lg" >
					<span class="glyphicon glyphicon-plus"></span>
					Ajouter
					</button>
				</div>
				<div id="table_mere">
				 <table class="table table-hover">
				    <thead>
				      <tr>
				        <th>Libellé</th>
				        <th>Description</th>
				        <th>Catégorie</th>
				        <th>Action</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($fiches as $fiche) {
				    	?>
				    		 <tr id='fiche<?php echo $fiche->getId(); ?>'>
						        <td><?php echo $fiche->getLibelle();?></td>
						        <td><?php echo $fiche->getDescription();?></td>
						        <td><?php echo $fiche->concatCategorie(); ?></td>
						        <td id="<?php echo $fiche->getId();?>"><a href="#" class="edit_fiche"><span class="glyphicon glyphicon-edit"></span></a><a href="#" class="delete_fiche"><span class="glyphicon glyphicon-trash"></span></a></td>
						      </tr>
				    	<?php } ?>
				    </tbody>
				  </table>
				  </div>
		</div>
		</div>
		<div class="col-sm-1"></div>

	</div>


	<script src="View/assets/jquery-3.2.1.min.js"></script>
	<script src="View/assets/jqTree/js/tree.jquery.js"></script>
	<script src="View/assets/bootstrap/js/bootstrap.js"></script>
	<script src="View/assets/bootstrap-select.min.js"></script>
	<script type="text/javascript">
		//load categories
		///**Loading all categories
		function loadCategorie(){
			$.ajax({
			  method: "POST",
			  url: "index.php?action=getallcategories",
			  data: { name: "John", location: "Boston" },
			   success : function(result, status){
			   		$('#arbre_categorie').tree('destroy');
                    data = jQuery.parseJSON(result);
				    $('#arbre_categorie').tree({
					    data: data,
					    autoOpen: true,
					    dragAndDrop: true
					});
               },

               error : function(result, status, err){
               		$('#arbre_categorie').tree('destroy');
                    data = jQuery.parseJSON(result);
                    alert(data);
				    $('#arbre_categorie').tree({
					    data: data,
					    autoOpen: true,
					    dragAndDrop: true
					});
               }
			});
		}
		loadCategorie();

	    //delete categorie
		$("#delete_categorie").on("click",function(){

			var node = $('#arbre_categorie').tree('getSelectedNode');
			delete_categorie(node);
		});
		function delete_categorie(node)
		{
			if (confirm('Etes-vous sûr de vouloir supprimer? ')) {
				$.ajax({
					url: 'index.php?action=supprimercategorie',
					type: 'POST',
					dataType: 'json',
					data:{"id_categorie" : node.id},

					success : function(result, status){
			            location.reload();

		           },

		           error : function(result, status, err){
			           location.reload();
		           }
				});
			}
		}
		$(".delete_fiche").on("click",function(){
			delete_fiche($(this));
		});
		function delete_fiche(ligne)
		{
			if (confirm('Etes-vous sûr de vouloir supprimer? ')) {
				var parent = ligne.parent();
				id_fiche = parent.attr("id");
				$.ajax({
					url: 'index.php?action=supprimerFiche',
					type: 'POST',
					dataType: 'json',
					data:{"id_fiche" : id_fiche},

					success : function(result, status){
			            parent.parent().remove();

		           },

		           error : function(result, status, err){
			            parent.parent().remove();
		           }
				});
			}
		}
	</script>
<?php
	require_once 'categorie_ajouter_modal.php';

	require_once 'categorie_modif_modal.php';

	require_once 'fiche_ajout_modal.php';

	require_once 'fiche_modif_modal.php';
 ?>



</body>
</html>