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
            @php
              $User = Db::table('hs_users')->where('Id', $UserId)->first();
            @endphp
            <div class="row">

              <div class="col-12 col-md-8">
                <div class="card card-olive card-outline">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title text-uppercase">Informations</h3>
                    @if(Functions::IsAdministrator())
                      @if($User->Status === 'ACTIF')
                        <div class="card-tools">
                          <button type="button" class="btn btn-xs btn-danger" id="userStart_DeleteUser" data-user="{{ @$User->Id }}">
                            <i class="fas fa-trash fa-sm me-1"></i> Supprimer
                          </button>
                        </div>
                      @else
                        <div class="card-tools">
                          <button type="button" class="btn btn-xs bg-olive" id="userStart_RestoreUser" data-user="{{ @$User->Id }}">
                            <i class="fas fa-caret-up fa-sm me-1"></i> Réstaurer
                          </button>
                        </div>
                      @endif
                    @endif
                  </div>
                  <div class="card-body">
                    <form class="row g-2">
                      <div class="col mx--auto">
                          <div class="text-center box-profile">
                            <div class="text-center mb-2">
                              <img class="img-fluid rounded-circle border" src="{{ Functions::GeneratAvatar($User->Id) }}" id="avatarPreviwer">
                            </div>
                            <h3 class="d-none profile-username fw-bold text--dark text-center text-uppercase mb-0">{{ @$User->Name }}</h3>
                            <span class="d-none badge bg-{{ Functions::getJobColor($User->WorkJob) }} text-center">
                              {{ @Functions::getWorkFunction($User->WorkFunction) }}
                            </span>
                          </div>
                      </div>

                      <div class="col-6">
                        <div class="row">
                          <div class="col-12">
                            <label class="form-label">Nom et Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ @$User->Name }}" id="userNextName">
                          </div>
                          <div class="col-12">
                            <label class="form-label">Adresse Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" value="{{ @$User->Email }}" id="userNextEmail">
                          </div>
                        </div>
                      </div>

                      <div class="col-6">
                          <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                          <input type="password" class="form-control" id="userNextPassword">
                      </div>

                      <div class="col-6">
                          <label class="form-label">Confirmer Mot de passe <span class="text-danger">*</span></label>
                          <input type="password" class="form-control" id="userNext2Password">
                      </div>

                      <div class="col-3">
                          <label class="form-label">Matricule N° <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" value="{{ @$User->Serial }}" id="userNextSerial">
                      </div>

                      <div class="col-3">
                          <label class="form-label">CNSS N° <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" value="{{ @$User->Insurance }}" id="userNextInsurance">
                      </div>

                      <div class="col-6">
                          <label class="form-label">Date Entrée <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" value="{{ @$User->TimeOfRegister }}" id="userNextTimeOfRegister">
                      </div>

                      <div class="col-4">
                          <label class="form-label">CIN N° <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" value="{{ @$User->CIN }}" id="userNextCIN">
                      </div>

                      <div class="col-2">
                          <label class="form-label">Solde</label>
                          <input type="number" value="{{ @$User->Balance }}" pattern="^\d*(\.\d{0,1})?$" class="form-control" id="userNextBalance">
                      </div>

                      <div class="col-6">
                          <label class="form-label">N° Téléphone <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">+212</span>
                            </div>
                            <input type="text" class="form-control" value="{{ @$User->Phone }}" id="userNextPhone" data-inputmask='"mask": "(9) 9999 9999"' data-mask>
                          </div>
                      </div>

                      <div class="col-6">
                          <label class="form-label">Profil <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" value="{{ @$User->WorkJob }}" id="userNextWorkJob" readonly>
                      </div>

                      <div class="col-6">
                          <label class="form-label">Position <span class="text-danger">*</span></label>
                            <select class="form-control select2picker" data-size="5" data-live-search="true" id="userNextWorkFunction">
                              @php
                                $Functions = DB::table('hs_workfunctions')->where('WorkJob', $User->WorkJob)->orderBy('Id')->get();
                              @endphp
                              @foreach($Functions as $Item)
                                <option value="{{ @$Item->Id }}" {{ @$User->WorkFunction == $Item->Id ? 'selected' : '' }}>
                                  {{ @$Item->JobFunction }}
                                </option>
                              @endforeach
                            </select>
                      </div>

                    </form>

                  </div>

                  <div class="card-footer d-flex align-items-center justify-content-between">
                    @if(Functions::IsAdministrator())
                      <input type="file" class="d-none" id="userSettingAvatar" data-user="{{ @$User->Id }}" accept="image/*">
                      <button type="button" class="btn bg-dark btn-sm" id="userSettingAvatarPicker">
                        <i class="fas fa-solid fa-upload fa-sm me-1"></i> Charger un profil
                      </button>
                    @endif
                    <button type="button" class="btn btn-sm bg-olive" id="userStart_updateUser" data-user="{{ @$User->Id }}">
                      <i class="fas fa-solid fa-screwdriver me-1"></i> Sauvegarder
                    </button>
                  </div>

                </div>
              </div>

              @if($User->WorkJob !== 'Salary')
                <div class="col-12 col-md-4">
                  <div class="card card-olive card-outline">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h3 class="card-title text-uppercase">L'équipe</h3>
                      @if(Functions::IsAdministrator())
                          <div class="card-tools">
                            <button type="button" class="btn btn-xs bg-olive" data-bs-toggle="modal" data-bs-target="#mdLinkUsers">
                              <i class="fas fa-plus fa-sm me-1"></i> Associer
                            </button>
                          </div>
                      @endif
                    </div>
                    <div class="card-body">
                        <div class="timeline m-0">
                          @php
                              //$Functions = DB::table('hs_workfunctions')->where('Validator', $User->WorkFunction)->pluck('Id')->toArray();
                              //$Teams = DB::table('hs_users')->whereIn('WorkFunction', $Functions)->whereNot('WorkJob', 'Administrator')->get();

                              $SubTeams = DB::table('hs_teams')->where('SeniorId', $User->Id)->get();
                          @endphp

                          @foreach($SubTeams as $SubUser)
                            @php
                              $Member = DB::table('hs_users')->where('Id', $SubUser->UserId)->first();
                            @endphp
                            <div>
                              <i class="fas fa-user rounded bg-{{ @Functions::getJobColor($Member->WorkJob) }}"></i>
                              
                              <div class="timeline-item align-items-center bg-{{ @Functions::getJobColor($Member->WorkJob) }} d-grid gap-0">
                                <span class="time text-white">{{ @Functions::getWorkFunction($Member->WorkFunction) }}</span>
                                <h3 class="timeline-header text-white d-flex justify-content-between">
                                  <span>{{ @$Member->Name }}</span>
                                  <button class="start_unlinkUser btn bg-white btn-xs" data-user="{{ @$Member->Id }}" data-senior="{{ @$User->Id }}">
                                    <i class="far fa-trash"></i>
                                  </button>
                                </h3>
                              </div>
                            </div>
                          @endforeach
                        </div>
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>
      </div>
      </section>
    </div>

    <div class="modal fade" id="mdLinkUsers">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title tracking-wide">Associer des utilisateurs</h4>
            <button type="button" class="close" data-bs-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body select2-olive">
            <label class="form-label">Utilisateurs <span class="text-danger">*</span></label>
            <input type="hidden" value="{{ @$User->Id }}" id="start_linkSeniorId">
            <select id="start_linkListUsers" class="select2picker" multiple="multiple" data-placeholder="Sélectionner l'utilisateur à relier" data-dropdown-css-class="select2-olive">
              @php
                $Users = DB::table('hs_users')->orderBy('Id')->get();
              @endphp

              @foreach($Users as $Item)
                <option value="{{ @$Item->Id }}">
                  <span>{{ @$Item->Name }}</span>
                  <small>- {{ @Functions::getEUVersion($Item->WorkJob) }}</small>
                </option>
              @endforeach
            </select>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-sm bg-olive" id="start_linkUsers">
              <i class="fas fa-plus fa-sm me-1"></i> Associer
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="mdDeleteUser">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title tracking-wide">Confirmation !</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <p class="text-center">
                <i class="fas fa-solid fa-skull-crossbones text-danger fs-1"></i>
              </p>
              <p class="text-center">
                 Êtes-vous sûr(e) de vouloir supprimer ce utilisateur ?
              </p>
              <p class="m-0 text-center">
                 Cette action est irréversible et toutes les données associées seront perdues.
              </p>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-sm btn-danger" id="userStart_DeleteUser" data-user="{{ @$User->Id }}">
              <i class="fas fa-trash fa-sm me-1"></i> Supprimer
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