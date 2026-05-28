@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">CANDIDATURES > </span>  ACCEPTEES
    </h4>
    <div class="card">
        <div class="card-body">
                <div class="ms-auto d-flex justify-content-end">
                    <div class="btn-group ">
                        <label class="m-2" for="recherche">Recherche </label>
                        <input type="text" id="filterInput" placeholder="" class="mb-2 form-control">
                    </div>
                </div>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="dt-responsive table table-bordered"  id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th>N°</th>
                            <th>Mécano/Matricule</th>
                            <th>Nom & Prénom(s)</th>
                            <th>Fiche d'autorisation</th>
                            <th>Ouverture de compte</th>
                            <th>Dépôt de l'apport</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if($candidature_accepted->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">Aucune données trouvées.</td>
                            </tr>
                        @else
                            @foreach($candidature_accepted as $key => $item)
                                <tr>
                                    <td class="text-dark fw-bold fs-6">{{ $loop->index + 1 }}</td>
                                    <td class="fw-bold">{{ $item->user->mecano }}</td>
                                    <td class="fw-bold">{{ $item->user->fullName() }}</td>
                                    <td class="text-center">
                                        @if($item->fiche_autorisation != null)
                                            <a href="#" class="btn btn-sm btn-secondary btn-rounded" onclick="afficherFicheAutorisation('{{ $key }}')" data-tooltip='modal' data-position='top right'><i class="fas fa-eye"></i>&nbsp; Voir la Fiche</a>
                                        @else
                                            <span>Aucun fichier</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->open_account != null)
                                            <span class="badge bg-success">Oui</span>
                                        @else
                                            <span class="badge bg-danger">Non</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->depot_apport != null)
                                            <span class="badge bg-success">Oui</span>
                                        @else
                                            <span class="badge bg-danger">Non</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">Accepté
                                    </td>
                                    <td class="text-right">
                                        @if($item->fiche_autorisation == null)
                                        <a href="#" class="btn btn-sm btn-warning btn-rounded" onclick="ajouterFicheAutorisation('{{ $key }}')" data-tooltip='modal' data-position='top right'><i class="fas fa-plus"></i>&nbsp;&nbsp; Fiche d'autorisation</a>
                                        @endif
                                        @if($item->open_account == null)
                                        <a href="#" class="btn btn-sm btn-primary btn-rounded" onclick="openAccountForm('{{ $key }}')" data-tooltip='modal' data-position='top right'><i class="fas fa-pen"></i>&nbsp;&nbsp; Ouverture de compte</a>
                                        @endif
                                        @if($item->depot_apport == null)
                                        <a href="#" class="btn btn-sm btn-secondary btn-rounded"><i class="fas fa-plus"></i>&nbsp;&nbsp; Dépôt de l'apport</a>
                                        @endif
                                        @if($item->demande_pret == null)
                                        <a href="{{route('candidature.demande_pret')}}" class="btn btn-sm btn-info btn-rounded"><i class="fas fa-money-bill"></i>&nbsp;&nbsp; Demande de prêt</a>
                                        @endif
                                    </td>
                                </tr>
    
                                {{-- Modal pour ajouter une fiche d'autorisation --}}
                                <div class="modal fade" id="ajouterFicheAutorisationModal{{ $key }}" tabindex="-1" aria-labelledby="label" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <form id="autorisationForm" action="{{ route('candidature.update_fiche_autorisation') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <medium class="modal-title text-uppercase fw-bold" id="label">Fiche d’autorisation d’ouverture de compte FIDRA ou autre</medium>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="candidature_id" value="{{$item->id}}" />
                                                <div class="text-center">
                                                    <p><span class="fw-bold">NB </span> <span class="text-danger">*</span> : <span class="text-danger">Cette fiche est nécessaire pour l'ouverture du compte d'un bénéficiare .</span> </p> 
                                                </div>
                                                <br>
                                                <div class="text-center">
                                                    <h1 class="form-label">Bénéficiaire : <span class="fw-bold">{{ $item->user->fullName() }}</span></h1>
                                                </div>
                                                <br>
                                                <div class="row mt-2">
                                                    <div class="col-md-12 form-group">
                                                        <label for="fiche_autorisation" class="form-label">Fiche d'autorisation </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="fiche_autorisation" name="fiche_autorisation">
                                                        </div>
                                                        @error('fiche_autorisation')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                                                </div>
                                            </div> 
                                        </form>
                                      </div>
                                    </div>
                                </div>

                                {{-- Modal pour ajouter une fiche d'autorisation --}}
                                <div class="modal fade" id="afficherFicheAutorisationModal{{ $key }}" tabindex="-1" aria-labelledby="label" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                      <div class="modal-content">
                                            <div class="modal-header">
                                                <medium class="modal-title text-uppercase fw-bold" id="label">Fiche d’autorisation </medium>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe src="{{ asset($item->fiche) }}" width="100%" height="800px"></iframe>
                                            </div>
                                      </div>
                                    </div>
                                </div>

                                {{-- Modal pour l'ouverture de compte d'un bénéficiaire --}}
                                <div class="modal fade" id="openAccountModal{{ $key }}" tabindex="-1" aria-labelledby="label" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <form id="openAccountForm" action="{{ route('candidature.update_fiche_autorisation') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <medium class="modal-title text-uppercase fw-bold" id="label">Ouverture de compte de {{ $item->user->fullName() }}</medium>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="candidature_id" value="{{$item->id}}" />
                                                
                                                <div class="row mt-2">
                                                    <div class="col-md-12 form-group">
                                                        <label for="fiche_autorisation" class="form-label">Nom & Prénom(s) du bénéficiaire</label>
                                                        <input type="text" class="form-control" id="fiche_autorisation" name="fiche_autorisation">
                                                        @error('fiche_autorisation')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="no_compte" class="form-label">N° de compte / RIB</label>
                                                        <input type="text" class="form-control" id="no_compte" name="no_compte">
                                                        @error('no_compte')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="agence_name" class="form-label">Nom de la banque</label>
                                                        <input type="text" class="form-control" id="agence_name" name="agence_name">
                                                        @error('agence_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                                    <button type="submit" class="btn btn-primary px-4">Enregistrer</button>
                                                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                                                </div>
                                            </div> 
                                        </form>
                                      </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   document.getElementById("filterInput").addEventListener("input", function() {
    var filterValue = this.value.toLowerCase(); 
    var table = document.getElementById("myTable"); // Récupérer le tableau
    var tr = table.getElementsByTagName("tr"); // Récupérer toutes les lignes du tableau
    
    // Parcourir toutes les lignes du tableau
    for (var i = 1; i < tr.length; i++) { 
        var found = false; 
        var tds = tr[i].getElementsByTagName("td"); 
        
        // Parcourir toutes les cellules de la ligne
        for (var j = 0; j < tds.length; j++) {
        var td = tds[j];
        if (td) {
            var txtValue = td.textContent || td.innerText; 
            if (txtValue.toLowerCase().indexOf(filterValue) > -1) { 
            found = true; // Marquer comme trouvé si le texte correspond
            break; // Sortir de la boucle dès que le texte est trouvé dans une cellule
            }
        }
        }
        
        // Afficher ou masquer la ligne en fonction de si le texte filtré est trouvé dans n'importe quelle cellule de cette ligne
        if (found) {
        tr[i].style.display = ""; 
        } else {
        tr[i].style.display = "none"; 
        }
    }
    });

    $(document).ready(function (){
        $('#autorisationForm').validate({
            rules: {
                fiche_autorisation: {
                    required : true,
                }, 
            },
            messages :{
                fiche_autorisation: {
                    required : 'La fiche d\'autorisation est obligatoire',
                },  
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('text-danger');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
@endsection
@push('js-push')
<script>
    function ajouterFicheAutorisation(key) {
        var myModal = new bootstrap.Modal(document.getElementById('ajouterFicheAutorisationModal' + key));
        myModal.show();
    }
</script>
<script>
    function afficherFicheAutorisation(key) {
        var myModal = new bootstrap.Modal(document.getElementById('afficherFicheAutorisationModal' + key));
        myModal.show();
    }
</script>
<script>
    function openAccountForm(key) {
        var myModal = new bootstrap.Modal(document.getElementById('openAccountModal' + key));
        myModal.show();
    }
</script>
<script>
    (function() {
    "use strict";
    
    $('.btnDelete').on('click', function() {
        var url;
        url = $(this).attr("data-url");
        $('.modal_URL').attr("href", url);
    });
})();
</script>
@endpush

