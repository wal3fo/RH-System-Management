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

              <div class="col-6">
                <div class="card card-olive card-outline">
                  <div class="card-header">
                    <h3 class="card-title"><span class="fas fa-heart fa-sm text-olive me-1"></span> Droits des Congés</h3>
                  </div>
                  <div class="card-body table-responsive p-0">
                      <table class="table table-bordered">
                        <thead>
                        <tr class="text-center">
                          <th class="no-sort">Motif</th>
                          <th class="no-sort">Durée</th>
                        </tr>
                        </thead>
                        <tbody>
                          @php
                            $Rules = DB::table('hs_rules')->where('Type', 'SIMPLE')->orderBy('Id')->get();
                          @endphp

                          @foreach($Rules as $Item)
                          <tr>
                            <td class="w-75">{{ @$Item->Label }}</td>
                            <td class="text-center">{{ @$Item->Duration }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>

              <div class="col-6">
                <div class="card card-olive card-outline">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title"><span class="fas fa-fire fa-sm text-olive me-1"></span> Jours fériés</h3>

                  <div class="card-tools">
                      @if(Functions::IsAdministrator())
                        <input type="file" class="d-none" id="companyHolidays" accept=".xlsx, .xls">
                        <button class="btn btn-xs bg-olive" id="start_uploadHolidays">
                          <i class="fas fa-solid fa-upload fa-sm"></i>
                          Télécharger
                        </button>
                      @endif
                  </div>
                  </div>
                  <div class="card-body table-responsive p-0">
                    <table class="table table-bordered">
                      <thead>
                      <tr class="text-center">
                        <th class="no-sort">Motif</th>
                        <th class="no-sort">Durée</th>
                      </tr>
                      </thead>
                      <tbody>
                          @php
                            $Rules = DB::table('hs_rules')->where('Type', 'ADVANCED')->orderBy('Id')->get();
                          @endphp

                          @foreach($Rules as $Item)
                          <tr>
                            <td class="w-75">{{ @$Item->Label }}</td>
                            <td class="text-center">{{ @$Item->Duration }}</td>
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

    @include('metas.footer')
    </div>
    @include('metas.scripts')
  </body>
</html>
