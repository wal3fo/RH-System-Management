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
              <div class="col-12 d-none">
                <div class="card card-olive card-outline">
                  <div class="card-header">
                    <h3 class="card-title"><span class="fas fa-code-branch fa-sm text-olive me-1"></span>Permissions</h3>
                  </div>
                  <div class="card-body row g-3">

                    <div class="col-12 col-md-4">
                        <p class="fw-bold text-center bg-dark rounded">Salarié(e)</p>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <p class="fw-bold text-center bg-dark rounded">Résponsable</p>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <p class="fw-bold text-center bg-dark rounded">Directeur</p>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                        <div class="icheck-olive">
                          <input type="checkbox" id="remember" checked>
                          <label for="remember">
                            Souviens-toi de moi
                          </label>
                        </div>
                    </div>

                  </div>

                </div>
              </div>

              <div class="col-12">
                <div class="card card-olive card-outline">
                  <div class="card-header">
                    <h3 class="card-title"><span class="fas fa-users fa-sm text-olive me-1"></span>Fonctions</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-sm bg-olive" data-bs-toggle="modal" data-bs-target="#mdNewFunction">
                        <i class="fas fa-plus fa-sm me-1"></i> Créer une fonction
                      </button>
                    </div>
                  </div>
                  <div class="card-body table-responsive p-0">
                    <table id="datatables" class="table table-bordered">
                      <thead>
                      <tr>
                      <th class="w-1 no-sort text-center"><i class="fas fa-qrcode"></i></th>
                      <th class="no-sort text-center">Fonction</th>
                      <th class="no-sort text-center text-nowrap">
                        Supérieur
                      </th>
                      <th class="no-sort text-center">Département</th>
                      <th class="no-sort text-center">Validateur</th>
                      <th class="no-sort text-center">
                        <span class="fas fa-circle-info fa-lg"></span>
                      </th>
                      </tr>
                      </thead>
                      <tbody>
                        @php
                          $Items = DB::table('hs_workfunctions')->orderBy('Id')->get();
                        @endphp

                        @foreach($Items as $Item)
                            @php
                                $Validator = DB::table('hs_workfunctions')->where('Id', $Item->Validator)->first();
                            @endphp
                          <tr>
                            <td class="fw-bold text-center">
                                {{ @$Item->Id }}
                            </td>
                            <td>
                              <div class="d-flex flex-column user-select-none">
                                <span class="text-dark fw-bold">
                                    <span class="fa-solid fa-shield-heart text-olive"></span>
                                    <span class="text-decoration-underline">{{ @$Item->JobFunction }}</span>
                                </span>
                                @php
                                  $Groups = DB::table('hs_users')->where('WorkFunction', $Item->Id)->get();
                                @endphp
                                <div class="d-flex gap-1">
                                  @foreach($Groups as $SubItem)
                                    <a href="{{ url('manager/users') }}/{{ @$SubItem->Id }}-{{ @Functions::Clean($SubItem->Name) }}" class="text-dark">
                                      <i class="fas fa-caret-right fa-sm text-dark"></i> {{ @$SubItem->Name }}
                                    </a>
                                  @endforeach
                                </div>
                              </div>
                            </td>
                            <td class="text-center">
                                @if($Item->Super === 1)
                                    <span class="fas fa-check-double fs-4 fw-bold text-olive"></span>
                                @endif
                            </td>
                            <td>{{ @$Item->Department }}</td>
                            <td>
                              <div class="d-flex flex-column user-select-none">
                                <span class="text-dark fw-bold">
                                    <span class="fa-solid fa-shield-heart text-olive"></span>
                                    <span class="text-decoration-underline">{{ @$Validator->JobFunction }}</span>
                                </span>
                                @php
                                  $Group = DB::table('hs_users')->where('WorkFunction', $Validator->Id)->get();
                                @endphp
                                <div class="d-flex gap-1">
                                  @foreach($Group as $SubItem)
                                    <a href="{{ url('manager/users') }}/{{ @$SubItem->Id }}-{{ @Functions::Clean($SubItem->Name) }}" class="text-dark">
                                      <i class="fas fa-caret-right fa-sm text-dark"></i> {{ @$SubItem->Name }}
                                    </a>
                                  @endforeach
                                </div>
                              </div>
                            </td>
                            <td class="text-start">
                                <input type="hidden" class="job__work__job__field" value="{{ @$Item->WorkJob }}">
                                <input type="hidden" class="job__validator__field" value="{{ @$Item->Validator }}">
                                <input type="hidden" class="job__function__field" value="{{ @$Item->JobFunction }}">
                                <input type="hidden" class="job__department__field" value="{{ @$Item->Department }}">
                                <input type="hidden" class="job__super__admin__field" value="{{ @$Item->Super }}">
                                <div class="d-flex flex-column gap-0 text-nowrap">
                                  <a href="#" class="start_editUserFunction text-dark" data-iue="{{ @$Item->Id }}">
                                    <i class="fas fa-circle-dot fa-sm"></i>
                                    Modifier
                                  </a>
                                  <a href="#" class="start_deleteUserFunction text-olive" data-iue="{{ @$Item->Id }}">
                                    <i class="fas fa-circle-dot fa-sm"></i>
                                    Supprimer
                                  </a>
                                </div>
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

    <div class="modal fade" id="mdNewFunction">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-plus fa-sm me-1"></i> Insertion</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3">
                <div class="col-12">
                    <label class="form-label">Fonction <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="start_functionLabel">
                </div>

                <div class="col-12">
                    <label class="form-label">Département <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="start_functionDepartment">
                </div>

                <div class="col-12">
                    <label class="form-label">Profil <span class="text-danger">*</span></label>
                    <select class="form-control select2picker" data-size="5" data-live-search="true" id="start_functionWorkJob">
                        <option selected disabled>Choisissez une valeur</option>
                        <option value="Administrator">Administrateur</option>
                        <option value="Director">Directeur</option>
                        <option value="Manager">Résponsable</option>
                        <option value="Salary">Salarié(e)</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Validateur</label>
                    <select class="form-control select2picker" data-size="5" data-live-search="true" id="start_functionValidator">
                        <option selected disabled>Choisissez une valeur</option>
                        @foreach($Items as $Item)
                            <option value="{{ @$Item->Id }}">{{ @$Item->JobFunction }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <div class="icheck-olive">
                        <input type="checkbox" id="start_functionSuperAdmin">
                        <label for="start_functionSuperAdmin">
                            Réponsable +1
                        </label>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-sm bg-olive" id="start_createUserFunction">
            <i class="fas fa-plus me-1"></i> Confirmer
            </button>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="mdEditFunction">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-gears fa-sm me-1"></i> Modification</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3">
                <div class="col-12">
                    <label class="form-label">Fonction <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="start_functionEditLabel">
                </div>

                <div class="col-12">
                    <label class="form-label">Département <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="start_functionEditDepartment">
                </div>

                <div class="col-12">
                    <label class="form-label">Profil <span class="text-danger">*</span></label>
                    <select class="form-control select2picker" data-size="5" data-live-search="true" id="start_functionEditWorkJob">
                        <option selected disabled>Choisissez une valeur</option>
                        <option value="Administrator">Administrateur</option>
                        <option value="Director">Directeur</option>
                        <option value="Manager">Résponsable</option>
                        <option value="Salary">Salarié(e)</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Validateur</label>
                    <select class="form-control select2picker" data-size="5" data-live-search="true" id="start_functionEditValidator">
                        @foreach($Items as $Item)
                            <option value="{{ @$Item->Id }}">{{ @$Item->JobFunction }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <div class="icheck-olive">
                        <input type="checkbox" id="start_functionEditSuperAdmin">
                        <label for="start_functionEditSuperAdmin">
                            Réponsable +1
                        </label>
                    </div>
                </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm bg-olive" id="start_updateUserFunction">
              <i class="fas fa-floppy-disk me-1"></i> Sauvegarder
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="mdDeleteFunction">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title tracking-wide">Confirmation !</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <p class="text-center">
                <i class="fas fa-solid fa-skull-crossbones text-olive fs-1"></i>
              </p>
              <p class="d-flex flex-column align-items-center">
                 <span class="fw-bold">Êtes-vous sûr(e) de vouloir supprimer cette fonction :</span>
                 <span class="fw-bold text-olive" id="to_delete_function_field"></span>
                 <span class="fw-bold fs-4">?</span>
              </p>
              <p class="m-0 text-center">
                 Cette action est irréversible et toutes les données associées seront perdues.
              </p>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-sm bg-olive" id="start_removeUserFunction">
              <i class="fas fa-trash fa-sm me-1"></i> Supprimer
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