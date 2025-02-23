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
                @php
                  $User = DB::table('hs_users')->where('Id', Session::get('Id'))->first();
                @endphp
                <div class="col-12 col-md-3">
                    <div class="card bg-gradient--dark">
                      <div class="card-body text-center box-profile">
                        <div class="text-center mb-2">
                          <img class="img-fluid shadow" src="{{ Functions::GeneratAvatar(Session::get('Id')) }}" id="avatarPreviwer">
                        </div>
                        <h3 class="profile-username fw-bold text--dark text-center text-uppercase mb-0">{{ @$User->Name }}</h3>
                        <span class="badge bg-{{ Functions::getJobColor($User->WorkJob) }} text-center">
                          {{ @Functions::getWorkFunction($User->WorkFunction) }}
                        </span>
                      </div>
                      <div class="card-footer text-center pt-0">
                          <input type="file" class="d-none" id="userSettingAvatar" data-user="{{ @$User->Id }}" accept="image/*">
                          <button type="button" class="btn bg-gradient-dark btn-sm mt-3" id="userSettingAvatarPicker">
                            <i class="fas fa-solid fa-upload fa-sm me-1"></i> Charger un profil
                          </button>
                      </div>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="card">
                      <div class="card-body">
                          <div class="row g-3">
                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="{{ @$User->Name }}" readonly>
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                  </div>
                                </div>
                                <input type="email" class="form-control" value="{{ @$User->Email }}" id="userNextEmail">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                  </div>
                                </div>
                                <input type="password" class="form-control" placeholder="Mot de passe" id="userNextPassword">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                  </div>
                                </div>
                                <input type="password" class="form-control" placeholder="Entrer à nouveau" id="userNext2Password">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-key"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="{{ @$User->Serial }}" readonly>
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-hospital"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="{{ @$User->Insurance }}" readonly>
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="{{ @$User->CIN }}" readonly>
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="{{ @$User->Phone }}" id="userNextPhone">
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-user-tie"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="{{ @Functions::getEUVersion($User->WorkJob) }}" disabled>
                              </div>
                            </div>

                            <div class="col-6">
                              <div class="input-group d-flex">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-solid fa-hashtag"></span>
                                  </div>
                                </div>
                                <input type="text" class="form-control" value="{{ @Functions::getWorkFunction($User->WorkFunction) }}" disabled>
                              </div>
                            </div>

                          </div>
                      </div>

                      <div class="card-footer text-end">
                          <button type="button" class="btn bg-olive btn-sm" id="userStart_updateUser" data-user="{{ @$User->Id }}">
                            <i class="fas fa-solid fa-edit me-1"></i> Sauvegarder
                          </button>
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
