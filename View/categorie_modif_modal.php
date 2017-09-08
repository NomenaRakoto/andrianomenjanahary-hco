 <div id="modalModif" class="modal">
        <div class="modal-dialog animated">
            <div class="modal-content">
                <form  id="formModifCategorie">
                    <div class="modal-header">
                        <strong>Modifier une catégorie</strong>
                    </div>

                    <div class="modal-body">
                            <div class="form-group">
                                <div>
                                <label for="libelle" class="control-label col-xs-2">Libellé* :</label>
                                    <div class="input-group col-xs-7">
                                        <input type="text" name="libelle" id="libelleModif" class="form-control" />
                                    </div>
                                </div>
                                 <div style="margin-top:3%;">
                                    <label for="Parent" class="control-label col-xs-2">Parent* :</label>
                                    <div class="input-group col-xs-7">
                                        <select name="id_pere" id="id_pereModif" class="form-control" >
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
                        <button class="btn btn-default cancelModal" id="cancelmodalModif" type="button">Annuler</button>
                        <button id="SaveModifCategorie" class="btn btn-primary" >Modifier</button>
                    </div>
            </div>
        </div>
</div>
 <script type="text/javascript">
            var nodeModif;
            var modalmodif = new RModal(document.getElementById('modalModif'), {
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
             $("#edit_categorie").on("click",function(){
                nodeModif = $('#arbre_categorie').tree('getSelectedNode');
                if(!nodeModif) 
                {
                    alert("Selectionnez une catégorie s'il vous plaît");
                    return;
                }
                $("#libelleModif").val(nodeModif.name);
                $("#id_pereModif").val(nodeModif.parent.id);
                modalmodif.open();
            });
             $("#cancelmodalModif").on("click",function(){
                modalmodif.close();
            });
          $("#SaveModifCategorie").on("click",function(){
            var libelle = $("#libelleModif").val();
            var id_pere = $("#id_pereModif").val();
            if($("#libelleModif").val()=="") {
                alert('Veuillez remplir le champ obligatoire');
                return;
            }
            donnees = {"id":nodeModif.id,"libelle":libelle,"id_pere":id_pere};
            $.ajax({
                url: 'index.php?action=modifiercategorie',
                type: 'POST',
                dataType: 'json',
                data:{"donnees" : donnees},

                success : function(result, status){
                    modalmodif.close();
                    location.reload();

               },
               error : function(result, status, err){
                    modalmodif.close();
                    location.reload();
               }
            });

        });

    </script>