<!DOCTYPE html>
<html lang="en">
  @include('metas.head')
  <body class="dark-mode hold-transition login-page" style="background: linear-gradient(45deg, #2e7555 50%, #262a2e 50%);">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-olive">
        <div class="card-header d-flex justify-content-between">
          <h5 class="d-grid fw-bold text-white mb-0">
            <span class="fs-3">{{ env('APP_NAME') }}</span>
            <small>
              Version {{ env('APP_VERS') }}
              <span class="badge badge-light text-olive fw-bold ms-2">BETA</span>
            </small>
          </h5>
          <img src="{{ asset('resources/assets/img/logo.webp') }}" class="p-1 bg-white elevate-1 rounded" width="60">
        </div>
        <div class="card-body">
          <form class="row g-3">
            <div class="col-12">
                <label class="form-label">Adresse Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Email" id="userLoginEmail">
            </div>

            <div class="col-12">
                <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Password" id="userLoginPassword">
            </div>

            <div class="col-12">
              <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                  <div class="icheck-olive">
                    <input type="checkbox" id="remember" checked>
                    <label for="remember">
                      Souviens-toi de moi
                    </label>
                  </div>
                </div>

                <div class="col-auto">
                  <button class="btn btn-sm bg-olive" id="userStart_SignIn">
                    <i class="fas fa-arrow-right-to-bracket fa-sm me-1"></i>
                    Se Connecter
                  </button>
                </div>
              </div>
            </div>

            <div class="col-12">
              <hr class="mt-0">
              <a href="#"><i class="fas fa-lock text-dark me-1"></i> Mot de passe oublié ?!</a>
            </div>
            @csrf
          </form>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    @include('metas.scripts')
  </body>
</html>