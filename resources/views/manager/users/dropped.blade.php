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
                    <h3 class="card-title"><span class="fas fa-users fa-sm text-olive me-1"></span>Utilisateurs Supprimés</h3>
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
                          $Users = DB::table('hs_users')->where(['Status' => 'DELETED'])->orderBy('TimeOfRegister')->get();
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

    @include('metas.footer')
    </div>
    @include('metas.scripts')
  </body>
</html>