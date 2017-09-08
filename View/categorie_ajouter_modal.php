 <link rel="stylesheet" href="View/assets/rmodal/css/animate.css" type="text/css" />
<link rel="stylesheet" href="View/assets/rmodal/css/rmodal.css" type="text/css" />
 <div id="modal" class="modal">
        <div class="modal-dialog animated">
            <div class="modal-content">
                <form  id="formAddCategorie">
                    <div class="modal-header">
                        <strong>Ajouter une catégorie</strong>
                    </div>

                    <div class="modal-body">
                            <div class="form-group">
                                <div>
                                <label for="libelle" class="control-label col-xs-2">Libellé* :</label>
                                    <div class="input-group col-xs-7">
                                        <input type="text" id="ajoutCategorieLibelle" name="libelle" class="form-control" />
                                    </div>
                                </div>
                                <div style="margin-top:3%;">
                                    <label for="Parent" class="control-label col-xs-2">Parent :</label>
                                    <div class="input-group col-xs-7">
                                        <select name="id_pere" class="form-control" id="edited_parent_categorie">
                                                <option value=""></option>
                                                <?php foreach($categories as $categorie) {?>
                                                    <option value="<?php echo $categorie->getId(); ?>"><?php echo $categorie->getLibelle();?></option>
                                                <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button class="btn btn-default cancelModal" type="button">Annuler</button>
                        <button id="SaveCategorie" class="btn btn-primary" >Ajouter</button>
                    </div>
            </div>
        </div>
</div>
<script src="View/assets/rmodal/js/rmodal.js"></script>
 <script type="text/javascript">
 window.onload = function() {
            var modal = new RModal(document.getElementById('modal'), {
                //content: 'Abracadabra'
                beforeOpen: function(next) {
                    console.log('beforeOpen');
                    next();
                }
                , afterOpen: function() {
                    console.log('opened');
                }

                , beforeClose: function(next) {
                    console.log('beforeClose');
                    next();
                }
                , afterClose: function() {
                    console.log('closed');
                }
            });
            $(".cancelModal").on("click",function(){
                modal.close();
            });
            $("#add_categorie").on("click",function(){
                var node = $('#arbre_categorie').tree('getSelectedNode');
                if(node)
                {
                    $("#edited_parent_categorie").val(node.id);
                } 
                else{
                    $("#edited_parent_categorie").val("");
                }
                modal.open();
            });
            $("#SaveCategorie").on("click",function(){
                var libelle = $("#ajoutCategorieLibelle").val();
                var id_pere = $("#edited_parent_categorie").val();
                if(libelle=="") {
                    alert('Veuillez remplir le champ obligatoire');
                    return;
                }
                donnees = {"libelle":libelle,"id_pere":id_pere};
                modal.close();
                $.ajax({
                    url: 'index.php?action=ajoutercategorie',
                    type: 'POST',
                    dataType: 'json',
                    data:{"donnees" : donnees},

                    success : function(result, status){
                        location.reload();
                   },

                   error : function(result, status, err){
                        location.reload();
                   }
                });

            });
    }

    </script>