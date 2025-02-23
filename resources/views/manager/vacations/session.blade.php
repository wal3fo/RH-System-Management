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
                    <h3 class="card-title">Mes Demandes Congés</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-sm bg-olive" data-bs-toggle="modal" data-bs-target="#mdRequestVacation">
                        <i class="fas fa-plus fa-sm me-1"></i> Créer une demande
                      </button>
                    </div>
                  </div>
                  <div class="card-body table-responsive p-0">
                    <table id="datatables" class="table table-bordered">
                      <thead>
                        <tr class="text-center">
                          <th class="w-1 no-sort">Ref.</th>
                          <th class="no-sort">Créateur</th>
                          <th class="no-sort">Motif</th>
                          <th class="no-sort">Sortie</th>
                          <th class="no-sort">Entrée</th>
                          <th class="no-sort">Status</th>
                          <th class="no-sort">Opération</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $Requests = DB::table('hs_aways')->Where(['UserId' => Session::get('Id'), 'Category' => 'Vacations'])->orderByDesc('TimeOf')->get();
                        @endphp

                        @foreach($Requests as $Request)
                          @php
                            $Sess = DB::table('hs_users')->where('Id', $Request->UserId)->first();
                            $Senior = DB::table('hs_users')->where('WorkFunction', $Request->SeniorId)->first();
                          @endphp
                          <tr>
                            <td class="text-center fw-bold fs-6 bg-{{ @Functions::getStatusColor($Request->Status) }}">
                              {{ @$Request->Id }}
                            </td>
                            <td class="text-nowrap">
                              <div class="d-flex flex-column gap-0">
                                <span>
                                  &#x2022; {{ @$Sess->Name }}
                                </span>
                                <span class="text-{{ @Functions::getJobColor($Sess->WorkJob) }}">
                                  &#x2022; {{ @Functions::getEUVersion($Sess->WorkJob) }}
                                </span>
                              </div>
                            </td>
                            <td class="text-start text-nowrap">
                              <div class="d-flex flex-column gap-0"> 
                                @if(!empty($Request->Type))
                                  <span>
                                    <i class="fas fa-filter fa-sm text-olive me-1"></i>
                                    {{ @$Request->Type }}
                                  </span>
                                @endif
                                <span>
                                  <i class="fas fa-comment-dots fa-sm text-gray me-1"></i>
                                  {{ @$Request->UserPrefix }}
                                </span>
                                <span>
                                  <i class="fas fa-sun fa-sm text-olive me-1"></i>
                                  {{ @$Request->Nbrs }} Jour(s)
                                </span>
                              </div>
                            </td>
                            <td class="text-center text-nowrap">
                              {{ @Functions::formaDate($Request->StartDate) }}
                            </td>
                            <td class="text-center text-nowrap">
                              {{ @Functions::formaDate($Request->EndDate) }}
                            </td>
                            <td class="text-start text-nowrap">
                              <div class="d-flex flex-column gap-0">
                                <span>
                                  @if($Request->Status === 'APPROVED')
                                    <i class="fas fa-sm fa-check-double text-success me-1"></i> Validateur <u>{{ $Senior->Name }}</u>
                                  @elseif($Request->Status === 'CANCELLED')
                                    <i class="fas fa-sm fa-ban text-danger me-1"></i> Rejecteur <u>{{ $Senior->Name }}</u>
                                  @else
                                    <div class="d-flex justify-content-between align-items-center">
                                      <span>
                                        <i class="fas fa-solid fa-sm fa-clock text-info me-1"></i>
                                        En attente
                                      </span>

                                      <button class="start_editUserVRequest btn btn-xs bg-olive" data-iue="{{ @$Request->Id }}">
                                        Modifier
                                      </button>
                                    </div>
                                  @endif
                                </span>
                                @if(!empty($Request->SeniorPrefix))
                                <span>
                                  <i class="fas fa-comment-dots text-gray fa-sm me-1"></i>
                                  <span class="senior__prefix__field">{{ @$Request->SeniorPrefix }}</span>
                                </span>
                                @endif
                                <span class="senior__status__field d-none">{{ @$Request->Status }}</span>
                                @if($Request->Status == 'APPROVED')
                                  <span>
                                    <i class="fas fa-cloud-arrow-down fa-sm text-olive me-1"></i>
                                    <a href="{{ url('vacations/certificates') }}/{{ @$Request->Id }}" class="text-dark">
                                      Télécharger
                                    </a>
                                  </span>
                                @endif
                              </div>
                            </td>
                            <td class="text-center text-nowrap">
                              <input type="hidden" class="start__date__field" value="{{ @Functions::unSyncDate($Request->StartDate) }}">
                              <input type="hidden" class="end__date__field" value="{{ @Functions::unSyncDate($Request->EndDate) }}">
                              <input type="hidden" class="prefix__field" value="{{ @$Request->UserPrefix }}">
                              <input type="hidden" class="type__field" value="{{ @$Request->Type }}">
                              <input type="hidden" class="half__field" value="{{ @$Request->IsHalf }}">

                              <i class="fas fa-regular fa-bell text-gray me-1"></i>
                              {{ @Functions::formaTime($Request->TimeOf) }}
                            </td>
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

    <div class="modal fade" id="mdRequestVacation">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Formulaire des congés</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-2">
              <div class="col-6">
                <label class="form-label">Date Sortie</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control float-right" id="start_requestStartDate">
                </div>
              </div>

              <div class="col-6">
                <label class="form-label">Date Entrée</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control float-right" id="start_requestEndDate">
                </div>
              </div>

              <div class="col-12">
                <label class="form-label">Type</label>
                <select class="form-control select2picker" data-live-search="true" id="start_requestType">
                  <option value="Congé Annuel Groupé">Congé Annuel Groupé</option>
                  <option value="Congé Maladie">Congé Maladie</option>
                  <option value="Congé Mariage">Congé Mariage</option>
                  <option value="Congé Fractionné">Congé Fractionné</option>
                  <option value="Congé ACC Travail">Congé ACC Travail</option>
                  <option value="Congé Naissance">Congé Naissance</option>
                  <option value="Congé Compensateur">Congé Compensateur</option>
                  <option value="Congé Maternité">Congé Maternité</option>
                  <option value="Congé Rècupération">Congé Rècupération</option>
                </select>
                <input type="hidden" value="Vacations" id="start_requestCategory">
              </div>

              <div class="col-12">
                <label class="form-label">Justification</label>
                <input type="text" class="form-control" placeholder="Motif de congé" id="start_requestPrefix">
              </div>

              <div class="col-12">
                  <div class="icheck-olive">
                    <input type="checkbox" id="start_createHalfRequest">
                    <label class="fw-medium" for="start_createHalfRequest">Congé demi journée</label>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn bg-olive btn-sm" id="start_createRequestV">
              <i class="fas fa-paper-plane fa-sm me-1"></i>
              Envoyer
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="mdEditVacation">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Formulaire des congés</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-2">
              <div class="col-6">
                <label class="form-label">Date Sortie</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control float-right" id="start_requestEditStartDate">
                </div>
              </div>

              <div class="col-6">
                <label class="form-label">Date Entrée</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control float-right" id="start_requestEditEndDate">
                </div>
              </div>

              <div class="col-12">
                <label class="form-label">Type</label>
                <select class="form-control select2picker" data-live-search="true" id="start_requestEditType">
                  <option value="Congé Annuel Groupé">Congé Annuel Groupé</option>
                  <option value="Congé Maladie">Congé Maladie</option>
                  <option value="Congé Mariage">Congé Mariage</option>
                  <option value="Congé Fractionné">Congé Fractionné</option>
                  <option value="Congé ACC Travail">Congé ACC Travail</option>
                  <option value="Congé Naissance">Congé Naissance</option>
                  <option value="Congé Compensateur">Congé Compensateur</option>
                  <option value="Congé Maternité">Congé Maternité</option>
                  <option value="Congé Rècupération">Congé Rècupération</option>
                </select>
                <input type="hidden" value="Vacations" id="start_requestCategory">
              </div>

              <div class="col-12">
                <label class="form-label">Justification</label>
                <input type="text" class="form-control" placeholder="Motif de congé" id="start_requestEditPrefix">
              </div>

              <div class="col-12">
                  <div class="icheck-olive">
                    <input type="checkbox" id="start_editHalfRequest">
                    <label class="fw-medium" for="start_editHalfRequest">Congé demi journée</label>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn bg-olive btn-sm" id="start_updateUserVRequest">
              <i class="fas fa-hourglass-start fa-sm me-1"></i>
              Sauvegarder
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
