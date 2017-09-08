 <div id="modalAjoutFiche" class="modal">
        <div class="modal-dialog animated">
            <div class="modal-content">
                <form  id="formAjoutFiche">
                    <div class="modal-header">
                        <strong>Ajouter une fiche</strong>
                    </div>
                      <div class="row">
                    <div class="modal-body">
                        <div class="form-group col-xs-8">
                          <label for="libelle">Libellé* : </label>
                          <input type="text" name="libelle" id="libelleFicheAjouter" class="form-control" />
                        </div>
                        <div class="form-group col-xs-8">
                          <label for="libelle">Description* : </label>
                          <input type="text" name="libelle" id="descriptionFicheAjouter" class="form-control" />
                        </div>
                        <div class="form-group col-xs-8">
                               <label for="selectfiche">Catégorie* : </label>
                              <select class="selectpicker selectpicker1" id="selectfiche" multiple>
                                  <?php foreach($categories as $categorie) {?>
                                        <option value="<?php echo $categorie->getId(); ?>"><?php echo $categorie->getLibelle();?></option>
                                    <?php }?>
                              </select>
                        </div>
                    </div>
                    </div>
                </form>
                 <div class="row">
                    <div class="modal-footer" style="margin-right:3%;">
                        <button class="btn btn-default" id="cancelmodalAjoutfiche" type="button">Annuler</button>
                        <button id="SaveAjoutFiche" class="btn btn-primary" >Ajouter</button>
                    </div>
                 </div>
            </div>
        </div>
</div>
 <script type="text/javascript">
            var modalAjoutFiche = new RModal(document.getElementById('modalAjoutFiche'), {
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
             $("#add_fiche").on("click",function(){
                modalAjoutFiche.open();
            });
             $("#cancelmodalAjoutfiche").on("click",function(){
                modalAjoutFiche.close();
            });
          $("#SaveAjoutFiche").on("click",function(){
            var categories = $("#selectfiche").val();
            var libelle = $("#libelleFicheAjouter").val();
            var description = $("#descriptionFicheAjouter").val();
             if(libelle=="" || description=="" || categories.length==0) {
                alert('Veuillez remplir le champ obligatoire');
                return;
            }
            donnees = {"libelle":libelle,"description":description,"categories" : categories};
            $.ajax({
                url: 'index.php?action=ajouterFiche',
                type: 'POST',
                dataType: 'json',
                data:{"donnees" : donnees},

                success : function(result, status){
                    modalAjoutFiche.close();
                    location.reload();

               },
               error : function(result, status, err){
                   modalAjoutFiche.close();
                   location.reload();
               }
            });

        });

    </script>