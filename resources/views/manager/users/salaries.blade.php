<!DOCTYPE html>
@php use App\Models\Functions; @endphp
<html lang="en">
  @include('metas.head')
  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble img-circle bg-white" src="{{ asset('resources/assets/img/logo.webp') }}" height="50" width="50">
      </div>
      @include('metas.navbar')
      
      @include('metas.aside')

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid"></div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card card-olive card-outline">
                  <div class="card-header">
                    <h3 class="card-title"><span class="fas fa-users fa-sm text-olive me-1"></span>Salariés</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-sm bg-olive" data-bs-toggle="modal" data-bs-target="#mdNewSalary">
                        <i class="fas fa-user-plus fas-sm me-1"></i> Créer un utilisateur
                      </button>
                    </div>
                  </div>
                  <div class="card-body table-responsive p-0">
                    <table id="datatables" class="table table-bordered">
                      <thead>
                      <tr>
                        <th class="text-center no-sort">Nom et Prénom</th>
                        <th class="text-center no-sort">Solde</th>
                        <th class="text-center no-sort">Adresse Email</th>
                        <th class="text-center no-sort">Matricule</th>
                        <th class="text-center no-sort">Mutuelle</th>
                        <th class="text-center no-sort">CIN</th>
                        <th class="text-center no-sort">Téléphone</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php
                          $Users = DB::table('hs_users')->where(['WorkJob' => 'Salary', 'Status' => 'ACTIF'])->orderBy('TimeOfRegister')->get();
                        @endphp

                        @foreach($Users as $User)
                          <tr>
                            <td>
                              <div class="d-grid justify-content-start"> 
                                <span>
                                  <i class="fas fa-caret-right fa-sm"></i>
                                  <a href="{{ url('manager/users') }}/{{ @$User->Id }}-{{ @Functions::Clean($User->Name) }}" class="text-decoration-underline">
                                    {{ @$User->Name }}
                                  </a>
                                </span>
                                <span class="text-dark">
                                  <i class="fas fa-caret-right fa-sm"></i>
                                  {{ @Functions::getWorkFunction($User->WorkFunction) }}
                                </span>
                              </div>
                            </td>
                            <td class="text-center">{{ @$User->Balance }}</td>
                            <td class="text-center">{{ @$User->Email }}</td>
                            <td class="text-center">{{ @$User->Serial }}</td>
                            <td class="text-center">{{ @$User->Insurance }}</td>
                            <td class="text-center">{{ @$User->CIN }}</td>
                            <td class="text-center">{{ @$User->Phone }}</td>
                          </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>

                </div>
              </div>

            </div>
          </div>
      </div>
      </section>
    </div>

    <div class="modal fade" id="mdNewSalary">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Créer un(e) salarié(e)</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-2">
              <div class="col-6">
                  <label class="form-label">Nom et Prénom <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="userRegisterName">
              </div>

              <div class="col-6">
                  <label class="form-label">Adresse Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="userRegisterEmail">
              </div>

              <div class="col-6">
                  <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="userRegisterPassword">
              </div>

              <div class="col-6">
                  <label class="form-label">Confirmer Mot de passe <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="userRegister2Password">
              </div>

              <div class="col-6">
                  <label class="form-label">Matricule N° <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="userRegisterSerial">
              </div>

              <div class="col-4">
                  <label class="form-label">Matricule N° <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="userRegisterSerial">
              </div>

              <div class="col-4">
                  <label class="form-label">CNSS N° <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="userRegisterInsurance">
              </div>

              <div class="col-4">
                  <label class="form-label">Date Entrée <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="userRegisterTimeOf">
              </div>

              <div class="col-2">
                  <label class="form-label">Solde</label>
                  <input type="number" pattern="^\d*(\.\d{0,1})?$" class="form-control" id="userRegisterBalance">
              </div>

              <div class="col-6">
                  <label class="form-label">N° Téléphone <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="userRegisterPhone">
              </div>

              <div class="col-6">
                  <label class="form-label">Profil <span class="text-danger">*</span></label>
                  <input type="hidden" value="Salary" id="userRegisterWorkJob">
                  <input type="text" class="form-control" value="Salarié(e)" readonly>
              </div>

              <div class="col-6">
                  <label class="form-label">Position <span class="text-danger">*</span></label>
                  <select class="form-control select2picker" data-size="5" data-live-search="true" id="userRegisterWorkFunction">
                    <option value="23">Chargé Process et R&D</option>
                    <option value="47">Chargée Administrative RH et Paie</option>
                    <option value="51">Assistance Médico-Social</option>
                    <option value="44">Acheteur Sénior</option>
                    <option value="19">Comptable Caisse et TVA Fournisseur</option>
                    <option value="27">Administrateur Réseaux et Système Information</option>
                    <option value="9">Chargé(e) d'Import & Export</option>
                    <option value="46">Chargé(e) Développement RH</option>
                    <option value="32">Chargé(e) GPAO</option>
                    <option value="30">Contrôleur de Gestion</option>
                    <option value="49">Chargé(e) d'Accueil et Bureau Ordre</option>
                    <option value="18">Comptable Senior</option>
                    <option value="25">Technicien de Laboratoire</option>
                    <option value="20">Comptable</option>
                    <option value="39">Chargé(e) Contrôle Qualité</option>
                    <option value="36">Gestionnaires de Stocks</option>
                    <option value="42">Superviseur HSE</option>
                    <option value="40">Chargé(e) Assurance Qualité et Export</option>
                    <option value="48">Chargé(e) Moyens Généraux</option>
                    <option value="28">Informaticien</option>
                    <option value="50">Coursiers</option>
                    <option value="4">Opérateurs de Production</option>
                    <option value="5">Conducteurs de Machine</option>
                    <option value="1">Techniciens</option>
                    <option value="16">Chargé(e) Règlement</option>
                    <option value="22">Chargé(e) R&D</option>
                    <option value="35">Manutentionnaires</option>
                  </select>
              </div>

            </form>

          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-sm bg-olive" id="userStart_SignUp">
              <i class="fas fa-plus me-1"></i> Créer maintenant
            </button>
          </div>
        </div>
      </div>
    </div>

    @include('metas.footer')
    </div>
    @include('metas.scripts')
  </body>
</html>
