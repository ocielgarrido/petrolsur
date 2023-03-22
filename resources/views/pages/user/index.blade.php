
<x-app-layout>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Usuarios</h4>
                    <p class="card-category">Usuarios registrados</p>
                  </div>
                  <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="success">
                      {{ session('success') }}
                    </div>
                    @endif
                    <div class="row">
                      <div class="col-12 text-right">
                        {{-- @can('user_create') --}}
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus">Añadir usuario</a></i>
                        {{-- @endcan --}}
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="text-primary">
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Correo</th>
                          <th>Username</th>
                          <th>Full Name</th>
                          <th>Roles</th>
                          <th class="text-right">Acciones</th>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                            <tr>
                              <td>{{ $user->id }}</td>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td>{{ $user->username }}</td>
                              <td>{{ $user->fullname }}</td>
                              <td>
                                  @forelse ($user->roles as $role)
                                    <span class="badge badge-info">{{ $role->name }}</span>
                                  @empty
                                    <span class="badge badge-danger">No roles</span>
                                  @endforelse
                                </td>
                              <td class="td-actions text-right">                              
                                {{-- @can('user_edit') --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"> <i class="fas fa-edit"></i></a>
                                {{-- @endcan --}}
                                {{-- @can('user_destroy') --}}
                                <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                                @csrf
                                @method('DELETE')
                                    <button class="btn btn-danger" type="submit" rel="tooltip">
                                      <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                {{-- @endcan --}}
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer mr-auto">
                    {{ $users->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-app-layout>
