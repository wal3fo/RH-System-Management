  <!DOCTYPE html>
@php use App\Models\Functions; @endphp
<html lang="en">
  @include('metas.head')
  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
      <div class="preloader flex-column justify-content-center align-items-center d-none">
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
            <div class="row user-select-none">
              <div class="col-md-7 col-12">
                <div class="row">
                    <div class="col-12 col-md-6">
                      <div class="info-box bg-dark">
                      <div class="ribbon-wrapper">
                        <div class="ribbon bg-olive text-xs">
                          Mensuel
                        </div>
                      </div>
                        <span class="info-box-icon bg-olive elevation-1">
                          <i class="fas fa-solid fa-gift"></i>
                        </span>
                        <div class="info-box-content">
                          <span class="info-box-text">Solde Congés</span>
                          <span class="info-box-number d-flex justify-content-between align-items-center">
                            <span>{{ Session::get('Balance') }} <small>Jours</small></span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="info-box bg-dark">
                        <span class="info-box-icon bg-olive elevation-1">
                          <i class="fas fa-regular fa-calendar-alt"></i>
                        </span>
                        <div class="info-box-content">
                          <span class="info-box-text">Date en cours</span>
                          <span class="info-box-number">{{ @Functions::getActualCalendar() }}</span>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="card bg-dark card-olive card-outline">
                          <div class="card-header">
                            <h3 class="card-title">
                              <i class="far fa-calendar-alt me-1"></i>
                              Calendrier
                            </h3>

                            <div class="card-tools">
                              <small id="calendar#jquery">{{ @Functions::getActualCalendar() }}</small>
                            </div>
                          </div>
                          
                          <div class="card-body p-0">
                            <div id="calendar" class="w-100"></div>
                          </div>
                          
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-12 col-md-5">
                <div class="card bg-dark card-olive card-outline">
                  <div class="card-body d-flex flex-column gap-1 p-2">
                      @php
                          $User = DB::table('hs_users')->where('Id', Session::get('Id'))->first();
                      @endphp
                      <div class="d-flex justify-content-between align-items-center rounded p-2">
                        <div class="d-flex gap-2 align-items-center">
                          <span class="badge bg-olive p-2" style="width: 35px; height: 25px;"><i class="fas fa-lg fa-id-card"></i></span>
                          <span>Nom et Prénom</span>
                        </div>
                        <span>{{ @$User->Name }}</span>
                      </div>

                      <div class="d-flex justify-content-between align-items-center rounded p-2">
                        <div class="d-flex gap-2 align-items-center">
                          <span class="badge bg-gray p-2" style="width: 35px; height: 25px;"><i class="fas fa-lg fa-hospital-user"></i></span>
                          <span>Déclaration C.N.S.S</span>
                        </div>
                        <span>{{ @$User->Insurance }}</span>
                      </div>

                      <div class="d-flex justify-content-between align-items-center rounded p-2">
                        <div class="d-flex gap-2 align-items-center">
                          <span class="badge bg-olive p-2" style="width: 35px; height: 25px;"><i class="fas fa-lg fa-address-card"></i></span>
                          <span>Numéro C.I.N</span>
                        </div>
                        <span>{{ @$User->CIN }}</span>
                      </div>

                      <div class="d-flex justify-content-between align-items-center rounded p-2">
                        <div class="d-flex gap-2 align-items-center">
                          <span class="badge bg-gray p-2" style="width: 35px; height: 25px;"><i class="fas fa-lg fa-plug-circle-check"></i></span>
                          <span>Profil</span>
                        </div>
                        <span>{{ @Functions::getEUVersion($User->WorkJob) }}</span>
                      </div>

                      <div class="d-flex justify-content-between align-items-center rounded p-2">
                        <div class="d-flex gap-2 align-items-center">
                          <span class="badge bg-olive p-2" style="width: 35px; height: 25px;"><i class="fas fa-lg fa-headset"></i></span>
                          <span>Situation</span>
                        </div>
                        <span>{{ @Functions::getWorkFunction($User->WorkFunction) }}</span>
                      </div>

                      <div class="d-flex justify-content-between align-items-center rounded p-2">
                        <div class="d-flex gap-2 align-items-center">
                          <span class="badge bg-gray p-2" style="width: 35px; height: 25px;"><i class="fas fa-lg fa-clock"></i></span>
                          <span>Date Entre</span>
                        </div>
                        <span>{{ @Functions::formaTime($User->TimeOfRegister) }}</span>
                      </div>
                  </div>

                  </div>
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