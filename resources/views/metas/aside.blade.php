@php use App\Models\Functions; @endphp
<aside class="main-sidebar sidebar-dark-primary elevation-0">
  <a href="{{ url('.') }}" class="brand-link bg-olive d-flex gap-2 justify-content-center align-items-center py-1">
    <img src="{{ asset('resources/assets/img/logo.webp') }}" class="p-1 d--none bg-white rounded" width="55">
    <span class="bg-white d-none rounded h-100 p-2 elevation-1">
      <i class="fa-solid fa-fire-flame-curved fa-xl text-olive"></i>
    </span>
    <h5 class="d-grid fw-bold text-white w-100 mb-0">
      <span class="fs-4">{{ env('APP_NAME') }}</span>
      <small>
        Version {{ env('APP_VERS') }}
      </small>
    </h5>
  </a>
  
  <div class="sidebar">
    <nav class="mt-2 d-grid justify-content-between user-select-none">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
        @if(Functions::IsAdministrator())
          @php
            $Directors = DB::table('hs_users')->where(['WorkJob' => 'Director', 'Status' => 'ACTIF'])->orderBy('TimeOfRegister')->count();
            $Managers = DB::table('hs_users')->where(['WorkJob' => 'Manager', 'Status' => 'ACTIF'])->orderBy('TimeOfRegister')->count();
            $Salaries = DB::table('hs_users')->where(['WorkJob' => 'Salary', 'Status' => 'ACTIF'])->orderBy('TimeOfRegister')->count();
            $Dropped = DB::table('hs_users')->where(['Status' => 'DELETED'])->orderBy('TimeOfRegister')->count();
          @endphp
          <li class="nav-header">Utilisateurs</li>
          <li class="nav-item">
            <a href="{{ url('manager/users/directors') }}" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Directeurs
                <span class="badge bg-olive right">{{ @$Directors }}</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('manager/users/managers') }}" class="nav-link">
              <i class="nav-icon fas fa-user-nurse"></i>
              <p>
                Résponsables
                <span class="badge bg-olive right">{{ @$Managers }}</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('manager/users/salaries') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Salariés
                <span class="badge bg-olive right">{{ @$Salaries }}</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('manager/users/dropped') }}" class="nav-link">
              <i class="nav-icon fas fa-ban"></i>
              <p>
                Supprimés
                <span class="badge bg-olive right">{{ @$Dropped }}</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('manager/users/functions') }}" class="nav-link">
              <i class="nav-icon fas fa-plug-circle-check"></i>
              <p>
                Fonctions
              </p>
            </a>
          </li>
          @php
            $MyTeam = DB::table('hs_workfunctions')->where('Id', Session::get('WorkFunction'))->get();
          @endphp
          @if(!is_null($MyTeam) && $MyTeam->count() > 0)
            <li class="nav-header">Géstion Équipe <span class="badge badge-danger ms-1">Admin</span></li>
            <li class="nav-item">
              <a href="{{ url('teams/vacations') }}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-gift"></i>
                <p>Congés</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('teams/absences') }}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-clock"></i>
                <p>Absences</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('teams/certificates') }}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-file-pdf"></i>
                <p>Attestations</p>
              </a>
            </li>
          @endif
        @endif

        @if(Functions::IsDirector() OR Functions::IsManager())
          @php
            $MyTeam = DB::table('hs_workfunctions')->where('Id', Session::get('WorkFunction'))->get();
          @endphp
          @if(!is_null($MyTeam) && $MyTeam->count() > 0)
            <li class="nav-header">Géstion Équipe <span class="badge badge-danger ms-1">Admin</span></li>
            <li class="nav-item">
              <a href="{{ url('teams/vacations') }}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-gift"></i>
                <p>Congés</p>
              </a>
            </li>

            @if(Functions::IsManager())
              <li class="nav-item">
                <a href="{{ url('teams/absences') }}" class="nav-link">
                  <i class="nav-icon fas fa-solid fa-clock"></i>
                  <p>Absences</p>
                </a>
              </li>
            @endif
          @endif
        @endif

        <li class="nav-header">Droits</li>
        <li class="nav-item">
          <a href="{{ url('sessions/rules') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Droits Congés - Fériés</p>
          </a>
        </li>

        @if(!Functions::IsAdministrator())
          <li class="nav-header">Mes Demandes</li>
          <li class="nav-item">
            @php
              $Vacations = DB::table('hs_aways')->Where(['UserId' => Session::get('Id'), 'Category' => 'Vacations'])->orderByDesc('TimeOf')->count();
              $Absences = DB::table('hs_aways')->Where(['UserId' => Session::get('Id'), 'Category' => 'Absences'])->orderByDesc('TimeOf')->count();
            @endphp
            <a href="{{ url('sessions/vacations') }}" class="nav-link">
              <i class="nav-icon fas fa-solid fa-gift"></i>
              <p>Congés <span class="badge bg-olive right">{{ @$Vacations }}</span></p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('sessions/absences') }}" class="nav-link">
              <i class="nav-icon fas fa-clock"></i>
              <p>Absences <span class="badge bg-olive right">{{ @$Absences }}</span></p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('sessions/certificates') }}" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>Attestations <span class="badge bg-olive fw-bold right">BETA</span></p>
            </a>
          </li>
        @endif
      </ul>

      <ul class="nav nav-pills nav-sidebar flex-column w-100 position-absolute bottom-0 start-0">
        <li class="nav-header text-center">
          <small class="text-white">
            POWERED BY <i class="fas fa-lg fa-fire-flame-curved text-olive"></i> <a href="mailto:dhoucam@outlook.com" class="fw-bold text-white">WAVEAUS</a>
          </small>
        </li>
      </ul>
    </nav>
  </div>
</aside>