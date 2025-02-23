<!DOCTYPE html>
@php use App\Models\Functions; @endphp
<html lang="en">
  @include('metas.head')

  <style>
    @media print {
      body {-webkit-print-color-adjust: exact;}
      #containerPrintFooter {
        position: absolute;
        bottom: 0;
      }
    }
  </style>

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
                    <div class="card-tools">
                      <button type="button" class="btn btn-sm bg-olive" id="start_printCertificate">
                        <i class="fas fa-print fa-sm me-1"></i> Imprimer
                      </button>
                    </div>
                  </div>

                  @if($ReferenceId)
                    @php
                      $Request = DB::table('hs_aways')->where('Id', $ReferenceId)->first();
                    @endphp
                    @if(!is_null($Request))
                      @php
                        $User = DB::table('hs_users')->where('Id', $Request->UserId)->first();
                        $Senior = DB::table('hs_users')->where('WorkFunction', $Request->SeniorId)->first();
                      @endphp
                      <div class="p-2" id="containerPrint">
                        <div class="card-body">
                            <div class="row border">
                              <div class="col-3 text-center border-right justify-content-center mt-2">
                                <img src="{{ asset('resources/assets/img/logo_paper.webp') }}" height="120">
                              </div>
                              <div class="col-6 d-flex flex-column gap-2 justify-content-center align-items-center">
                                <span class="fs-2 fw-bold text-uppercase">Enregistrement</span>
                                <span class="fs-2 fw-bold text-uppercase">Demande de congé</span>
                              </div>
                              <div class="col-3 d-flex flex-column border-left justify-content-start p-3 text-nowrap">
                                  <span class="fs-6 d-flex justify-content-between align-items-center">
                                    <span class="text--uppercase fw-bold">Référence</span> En-Ps-08230000 {{ @$Request->Id }}
                                  </span>
                                  <span class="fs-6 d-flex justify-content-between align-items-center">
                                    <span class="text--uppercase fw-bold">Status</span> {{ @Functions::getEUVersion($Request->Status) }}
                                  </span>
                                  <span class="fs-6 d-flex justify-content-between align-items-center">
                                    <span class="text--uppercase fw-bold">Mise en application</span> 2023-08
                                  </span>
                                  <hr class="my-1 mt-2">
                                  <span class="text-center">
                                    <small class="text--uppercase fw--bold">Page 1 sur 1</small>
                                  </span>
                              </div>
                            </div>
                        </div>

                        <div class="card-body text-end mb-4">
                          <span class="fw-bold">Date :</span> {{ @Functions::formaDate($Request->TimeOf) }}
                        </div>

                        <div class="card-body mb-4">
                            <div class="row border p-2">
                              <div class="col-5 text-start justify-content-center">
                                <span class="fw-bold">Nom et Prénom du Bénéficiaire</span>
                              </div>
                              <div class="col-2 text-center justify-content-center">
                                <span class="fw-bold">:</span>
                              </div>
                              <div class="col-5 text-end justify-content-center">
                                <span>{{ @$User->Name }}</span>
                              </div>
                            </div>

                            <div class="row border border-top-0 p-2">
                              <div class="col-5 text-start justify-content-center">
                                <span class="fw-bold">Matricule N°</span>
                              </div>
                              <div class="col-2 text-center justify-content-center">
                                <span class="fw-bold">:</span>
                              </div>
                              <div class="col-5 text-end justify-content-center">
                                <span>{{ @$User->Serial }}</span>
                              </div>
                            </div>
                            
                            <div class="row border border-top-0 p-2">
                              <div class="col-5 text-start justify-content-center">
                                <span class="fw-bold">Fonction</span>
                              </div>
                              <div class="col-2 text-center justify-content-center">
                                <span class="fw-bold">:</span>
                              </div>
                              <div class="col-5 text-end justify-content-center">
                                <span>{{ Functions::getWorkFunction($User->WorkFunction) }}</span>
                              </div>
                            </div>

                            <div class="row border border-top-0 p-2">
                              <div class="col-5 text-start justify-content-center">
                                <span class="fw-bold">Date d’embauche</span>
                              </div>
                              <div class="col-2 text-center justify-content-center">
                                <span class="fw-bold">:</span>
                              </div>
                              <div class="col-5 text-end justify-content-center">
                                <span>{{ @Functions::formaDate($Request->TimeOfRegister) }}</span>
                              </div>
                            </div>
                            
                            <div class="row border border-top-0 p-2">
                              <div class="col-5 text-start justify-content-center">
                                <span class="fw-bold">Nom du département</span>
                              </div>
                              <div class="col-2 text-center justify-content-center">
                                <span class="fw-bold">:</span>
                              </div>
                              <div class="col-5 text-end justify-content-center">
                                <span>{{ Functions::getWorkDFunction($User->WorkFunction) }}</span>
                              </div>
                            </div>

                            <div class="row border border-top-0 p-2">
                              <div class="col-5 text-start justify-content-center">
                                <span class="fw-bold">Nom du responsable Hiérarchique</span>
                              </div>
                              <div class="col-2 text-center justify-content-center">
                                <span class="fw-bold">:</span>
                              </div>
                              <div class="col-5 text-end justify-content-center">
                                <span>{{ @$Senior->Name }}</span>
                              </div>
                            </div>
                            
                            <div class="row border border-top-0 p-2">
                              <div class="col-5 text-start justify-content-center">
                                <span class="fw-bold">Nom du responsable Département</span>
                              </div>
                              <div class="col-2 text-center justify-content-center">
                                <span class="fw-bold">:</span>
                              </div>
                              <div class="col-5 text-end justify-content-center">
                                <span>{{ @$Senior->Name }}</span>
                              </div>
                            </div>

                        </div>
                        
                        <div class="card-body px-3 py-0">
                          <h3 class="fs-5 fw-bold text-decoration-underline mb-0">Types de Congés :</h3>
                        </div>

                        <div class="card-body mb-4">
                            <div class="row g-2 border justify-content-between">
                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type1" {{ @$Request->Type === 'Congé Annuel Groupé' ? 'checked' : '' }}>
                                    <label for="type1">
                                      Congé Annuel Groupé
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type2" {{ @$Request->Type === 'Congé Maladie' ? 'checked' : '' }}>
                                    <label for="type2">
                                      Congé Maladie
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type3" {{ @$Request->Type === 'Congé Mariage' ? 'checked' : '' }}>
                                    <label for="type3">
                                      Congé de Mariage
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type4" {{ @$Request->Type === 'Congé Fractionné' ? 'checked' : '' }}>
                                    <label for="type4">
                                      Congé Fractionné
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type5" {{ @$Request->Type === 'Congé ACC Travail' ? 'checked' : '' }}>
                                    <label for="type5">
                                      Congé ACC Travail
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type6" {{ @$Request->Type === 'Congé Naissance' ? 'checked' : '' }}>
                                    <label for="type6">
                                      Congé de Naissance
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type7" {{ @$Request->Type === 'Congé Compensateur' ? 'checked' : '' }}>
                                    <label for="type7">
                                      Congé Compensateur
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type8" {{ @$Request->Type === 'Congé Maternité' ? 'checked' : '' }}>
                                    <label for="type8">
                                      Congé Maternité
                                    </label>
                                  </div>
                              </div>

                              <div class="col-3 justify-content-center">
                                  <div class="icheck-dark">
                                    <input type="checkbox" disabled id="type9" {{ @$Request->Type === 'Congé Rècupération' ? 'checked' : '' }}>
                                    <label for="type9">
                                      Congé Rècupération
                                    </label>
                                  </div>
                              </div>
                            </div>
                        </div>
                        
                        <div class="card-body px-3 py-0">
                          <h3 class="fs-5 fw-bold text-decoration-underline mb-0">Solde Années Précédentes :</h3>
                        </div>

                        <div class="card-body mb-4">
                          <div class="row g-2 border pb-2 justify-content-between">

                            <div class="col-12 justify-content-center">
                              <div class="row">
                                <div class="col-5 text-start justify-content-center">
                                  <span class="fw-bold">Année en cours</span>
                                </div>
                                <div class="col-2 text-center justify-content-center">
                                  <span class="fw-bold">:</span>
                                </div>
                                <div class="col-5 text-end justify-content-center">
                                  <span><span class="fw-bold">N</span> {{ @Functions::formaYear($Request->TimeOf) }}</span>
                                </div>
                              </div>
                            </div>

                            <div class="col-12 justify-content-center">
                              <div class="row">
                                <div class="col-5 text-start justify-content-center">
                                  <span class="fw-bold">Date Sortie</span>
                                </div>
                                <div class="col-2 text-center justify-content-center">
                                  <span class="fw-bold">:</span>
                                </div>
                                <div class="col-5 text-end justify-content-center">
                                  <span>{{ @Functions::formaDate($Request->StartDate) }}</span>
                                </div>
                              </div>
                            </div>

                            <div class="col-12 justify-content-center">
                              <div class="row">
                                <div class="col-5 text-start justify-content-center">
                                  <span class="fw-bold">Date Entrée</span>
                                </div>
                                <div class="col-2 text-center justify-content-center">
                                  <span class="fw-bold">:</span>
                                </div>
                                <div class="col-5 text-end justify-content-center">
                                  <span>{{ @Functions::formaDate($Request->EndDate) }}</span>
                                </div>
                              </div>
                            </div>

                            <div class="col-12 justify-content-center">
                              <div class="row">
                                <div class="col-5 text-start justify-content-center">
                                  <span class="fw-bold">Nombre Jours Ouvrable</span>
                                </div>
                                <div class="col-2 text-center justify-content-center">
                                  <span class="fw-bold">:</span>
                                </div>
                                <div class="col-5 text-end justify-content-center">
                                  <span>{{ @$Request->Nbrs }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="card-body px-3 py-0">
                          <h3 class="fs-5 fw-bold text-decoration-underline mb-0">Accords :</h3>
                        </div>

                        <div class="card-body mb-4">
                          <div class="row g-2 border justify-content-between">
                            <div class="col-3 text-center justify-content-center border-right">
                              <span class="fs-5 w-100 fw-bold text-decoration-underline">L’intéressé(e)</span>

                              <div class="p-3 mt-2 text-center d-flex align-items-center justify-content-center h-75">
                                <div class="p-2 rounded" style="border: 3px solid #28a745;">
                                  <span class="fw-bold fs-6 text-uppercase text-success">
                                    {{ @$User->Name }}
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-3 text-center justify-content-center border-right">
                              <span class="fs-5 w-100 fw-bold text-decoration-underline">Supérieur Hiérarchique</span>

                              <div class="p-3 mt-2 text-center d-flex align-items-center justify-content-center h-75">
                                <div class="p-2 rounded" style="border: 3px solid #28a745;">
                                  <span class="fw-bold fs-6 text-uppercase text-success">
                                    {{ @$Senior->Name }}
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-3 text-center justify-content-center border-right">
                              <span class="fs-5 w-100 fw-bold text-decoration-underline">Directeur Général</span>

                              <div class="p-5 mt-2">

                              </div>
                            </div>
                            <div class="col-3 text-center justify-content-center">
                              <span class="fs-5 w-100 fw-bold text-decoration-underline">Département RH</span>

                              <div class="p-5 mt-2">

                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="card-body d-grid align-items-center justify-content-start mt-5" id="containerPrintFooter">
                          <strong>© Propriété Exclusive MATHEI</strong>
                          <small>
                            Toute copie ou distribution non autorisée est strictement interdite, et les contrevenants seront poursuivis.
                          </small>
                        </div>
                      </div>
                    @endif
                  @endif
                </div>
              </div>

            </div>
          </div>
      </div>
      </section>
    </div>

    @include('metas.footer')
    </div>
    @include('metas.scripts')
  </body>
</html>
