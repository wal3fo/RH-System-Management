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
                    <h3 class="card-title">Demandes des attestations</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-sm bg-olive" data-bs-toggle="modal" data-bs-target="#mdRequestCertif">
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
                        <th class="no-sort">Type</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Opération</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php
                          $Requests = DB::table('hs_certificates')->where('UserId', Session::get('Id'))->orderByDesc('TimeOf')->get();
                        @endphp

                        @foreach($Requests as $Request)
                          @php
                            $Sess = DB::table('hs_users')->where('Id', $Request->UserId)->first();
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
                                    <span>
                                      <span>
                                        <i class="fas fa-solid fa-filter fa-sm text-olive me-1"></i>
                                        {{ @$Request->Type }}
                                      </span>
                                      @if(!is_null($Request->PeriodOf))
                                      <span>
                                        <u>{{ @Functions::formaDate($Request->PeriodOf) }}</u>
                                      </span>
                                      @endif
                                    </span>
                                    @if(!empty($Request->UserPrefix))
                                    <span>
                                    <i class="fas fa-solid fa-comment-dots text-gray fa-sm me-1"></i>
                                    {{ @$Request->UserPrefix }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center text-nowrap">
                                <span>
                                    @if($Request->Status === 'APPROVED')
                                      <i class="fas fa-sm fa-check-double text-success me-1"></i> Validé
                                    @elseif($Request->Status === 'CANCELLED')
                                      <i class="fas fa-sm fa-ban text-danger me-1"></i> Rejeté
                                    @else
                                        <span>
                                            <i class="fas fa-solid fa-sm fa-clock text-info me-1"></i>
                                            En attente
                                        </span>
                                    @endif
                                </span>
                            </td>
                            <td class="text-center text-nowrap">
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

    <div class="modal fade" id="mdRequestCertif">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Formulaire des attestations</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-2">

              <div class="col-12">
                <label class="form-label">Type</label>
                <select class="form-control select2picker" data-live-search="true" id="start_requestCertifType">
                  <option value="Attestation de Travail">Attestation de Travail</option>
                  <option value="Attestation de Salaire">Attestation de Salaire</option>

                  <option value="Attestation de Congé">Attestation de Congé</option>
                  <option value="Attestation de Stage">Attestation de Stage</option>

                  <option value="ttestation de Travail et Salaire">Attestation de Travail et Salaire</option>
                  <option value="Attestation annuelle de Salaire">Attestation annuelle de Salaire</option>
                  
                  <option value="Attestation de domiciliation de Salaire">Attestation de domiciliation de Salaire</option>

                  <option value="Bulletin de Paie">Bulletin de Paie</option>
                  <option value="BDS">BDS</option>
                </select>
              </div>

              <div class="col-12 d-none" id="periodSection">
                <label class="form-label">Période</label>
                <input class="form-control" placeholder="dd-mm-yyyy" id="start_requestCertifPeriod">
              </div>

              <div class="col-12">
                <label class="form-label">Commentaire</label>
                <input type="text" class="form-control" id="start_requestCertifPrefix">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn bg-olive btn-sm" id="start_createRequestCertif">
              <i class="fas fa-paper-plane fa-sm me-1"></i>
              Envoyer
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
