
<x-app-layout>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Permisos</h4>
                  <p class="card-category">Permisos registrados</p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 text-right">
                      <a href="{{ route('permission.create') }}" class="btn btn-sm btn-primary"> <i class="fas fa-plus">Añadir permiso</a></i>
                    </div>
                    <br>
                  </div>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Guard</th>
                        <th>Created_at</th>
                        <th class="text-right">Acciones</th>
                      </thead>
                      <tbody>
                        @forelse ($permissions as $permission)
                        <tr>
                          <td>{{ $permission->id }}</td>
                          <td>{{ $permission->name }}</td>
                          <td>{{ $permission->guard_name }}</td>
                          <td>{{ $permission->created_at }}</td>
                          <td class="td-actions text-right">
                             <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('permission.destroy', $permission->id) }}" method="POST"
                              style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-danger" type="submit" rel="tooltip">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="2">Sin registros.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer mr-auto">
                  {{ $permissions->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
