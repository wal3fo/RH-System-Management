@php use App\Models\Functions; @endphp
<nav class="main-header navbar navbar-expand navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item d-sm-inline-block">
      <a href="{{ url('sessions/settings') }}" class="nav-link ps-0 pt-0">
        <div class="d-flex gap-2 align-items-center">
          <img src="{{ Functions::GeneratAvatar(Session::get('Id')) }}" class="rounded" width="40" height="40" style="padding: .1rem;object-fit: scale-down;background: #ffffff;">
          <div class="d-grid gap-0 align-items-start">
            <h6 class="mb-0">{{ Session::get('Name') }}</h6>
            <small class="text-olive mt-0">
              {{ Functions::getEUVersion(Session::get('WorkJob')) }}
              @if(!empty(Session::get('WorkFunction')))
                - {{ Functions::getWorkFunction(Session::get('WorkFunction')) }}
              @endif
            </small>
          </div>
        </div>
      </a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

  @if(Functions::IsConnected())
    <li class="nav-item">
      <button class="btn btn-sm bg-olive mt-1" id="userStart_SignOut">
        <i class="fas fa-solid fa-power-off me-1"></i> Déconnecter
      </button>
    </li>
  @endif
  </ul>
</nav>