<div>
    <div class="container">
        <div class="card my-5">
            <div class="card-header">
                <div class="d-flex justify-content-between">                 
                    <h3 class="text-danger">Listado Backups</h3>
               </div>
            </div>      
       </div>
        @if ($showData==true)

        <div class="table-responsive">
            @if (session()->has('success'))          
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"></use></svg>
                <div>
                    <strong>{{session('success')}}</strong>
                </div>
              </div>
            @endif
            @if (session()->has('error'))
            <div class="alert alert-danger">
                <strong>{{session('error')}}</strong>
            </div>
            @endif
           <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="color-abel">id</th>
                        <th class="color-abel">Fecha</th>
                        <th class="color-abel">Archivo</th>
                        <th class="color-abel">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($backups as $backup)
                    <tr>
                       <td>{{$backup->id}}</td>
                        <td>{{$backup->created_at}}</td>
                        <td>{{$backup->file}}</td>
                        <td><a href="{{asset('storage/backup')}}/{{$backup->file}}" download><i class="fa fa-download"></i></a></td>                        
                    </tr>
                    @empty
                    <h3 class="text-danger">No se encontraron registros</h3>
                    @endforelse

                </tbody>
            </table>
        </div>
        @endif  

    </div>

</div>
