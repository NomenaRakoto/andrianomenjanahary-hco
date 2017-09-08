 <div id="modalModifFiche" class="modal">
        <div class="modal-dialog animated">
            <div class="modal-content">
                <form  id="formModifFiche">
                    <div class="modal-header">
                        <strong>Modifier une fiche</strong>
                    </div>
                    <div class="row">
                    <div class="modal-body">
                                <div class="form-group col-xs-8">
                                    <input type="hidden" id="id_fiche" name=""/>
                                    <label for="libelle">Libéllé* : </label>
                                    <input type="text" name="libelle" id="libelleFicheModif" class="form-control" />
                                </div>
                                <div class="form-group col-xs-8">
                                    <label for="description">Description* : </label>
                                    <input type="text" name="description" id="descriptionFicheModif" class="form-control" />
                                </div>
                                <div class="form-group col-xs-8">
                                       <label for="">Catégorie* : </label>
                                      <select class="selectpicker selectpicker1" id="selectModif" multiple>
                                          <?php foreach($categories as $categorie) {?>
                                                <option value="<?php echo $categorie->getId(); ?>"><?php echo $categorie->getLibelle();?></option>
                                          <?php }?>
                                      </select>
                                </div>
                    </div>
                    </div>
                    </form>
                    <div class="row">
                    <div class="modal-footer" style="margin-right: 3%;">
                        <button class="btn btn-default" id="cancelmodalModiffiche" type="button">Annuler</button>
                        <button id="SaveModifFiche" class="btn btn-primary" >Modifier</button>
                    </div>
                    </div>
            </div>
        </div>
</div>
 <script type="text/javascript">
            var modalModifFiche = new RModal(document.getElementById('modalModifFiche'), {
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
             $(".edit_fiche").on("click",function(){
                var parent = $(this).parent();
                var id = parent.attr("id");
                $("#id_fiche").val(id);
                var libelle = $("#fiche" + id + " td:nth-child(1)").html();
                var description = $("#fiche" + id + " td:nth-child(2)").html();
                 $('#descriptionFicheModif').val(description);
                $("#libelleFicheModif").val(libelle);
                getCategorieFiche($(this),function(result){
                     $("#selectModif").selectpicker('val', result);
                     modalModifFiche.open();
                });
            });
             $("#cancelmodalModiffiche").on("click",function(){
                modalModifFiche.close();
            });
          $("#SaveModifFiche").on("click",function(){
            var id =  $("#id_fiche").val();
            var categories = $("#selectModif").val();
            var libelle = $("#libelleFicheModif").val();
            var description = $('#descriptionFicheModif').val();
             if(libelle=="" || description=="" || categories.length==0) {
                alert('Veuillez remplir le champ obligatoire');
                return;
            }
            donnees = {"id_fiche":id,"libelle":libelle,"description":description,"categories" : categories};
            $.ajax({
                url: 'index.php?action=modifierFiche',
                type: 'POST',
                dataType: 'json',
                data:{"donnees" : donnees},

                success : function(result, status){
                    modalModifFiche.close();
                    location.reload();

               },
               error : function(result, status, err){
                   modalModifFiche.close();
                   location.reload();
               }
            });

        });
          function getCategorieFiche(ligne,callback){
            var parent = ligne.parent();
            var id = parent.attr("id");
             $.ajax({
                url: 'index.php?action=getFicheCategories',
                type: 'POST',
                dataType: 'json',
                data:{"id_fiche" : id},

                success : function(result, status){
                    callback(result);
               },
               error : function(result, status, err){
                   callback(result);
               }
            });

          }
    </script>