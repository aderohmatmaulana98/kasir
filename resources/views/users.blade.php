@extends('layout.base')
@section('content') 
<!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center justify-content-between">
            <div class="col-sm-auto">
              <div class="page-header-title">
                <h5 class="mb-0">{{$title}}</h5>
              </div>
            </div>
              <div class="col-sm-auto">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../navigation/index.html"><i class="ph-duotone ph-house"></i></a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">Layout</a></li>
                  <li class="breadcrumb-item" aria-current="page">Vertical Layout</li>
                </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Tabel Users</h5><br><br>
                              
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah User
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Nama Pengguna" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                           <select name="id_role" id="id_role" class="form-select" required>
                                                <option value="">Pilih Role</option>
                                                @foreach ($role as $r)
                                                    <option value="{{ $r->id }}">{{ $r->nama_role }}</option>                                                    
                                                @endforeach
                                           </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>                                
                        </div>
                        </div>
                    </div>
              </div>
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="order-table" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if ($u->id_role == 1)
                                    Admin
                                @else
                                    Kasir
                                @endif
                            </td>
                            <td>
                              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $u->id }}">
                                  Edit
                              </button>
                              
                              <!-- Modal -->
                              <div class="modal fade" id="exampleModal1{{ $u->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          <form action="{{ route('users.update',$u->id) }}" method="POST">
                                              @csrf
                                              <div class="row">
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control" placeholder="Nama Pengguna" value="{{ $u->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $u->email }}" required>
                                                </div>
                                                <div class="form-group">
                                                   <select name="id_role" id="id_role" class="form-select" required>
                                                        <option value="">Pilih Role</option>
                                                        @foreach ($role as $r)
                                                        <option value="{{ $r->id }}" {{ $r->id == $u->id_role ? 'selected' : '' }}>
                                                            {{ $r->nama_role }}
                                                        </option>                                                    
                                                        @endforeach
                                                   </select>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary">Save changes</button>
                                          </div>
                                      </form>                                
                                  </div>
                                  </div>
                              </div>
                                <button class="btn btn-sm btn-danger" onclick="hapusBarang({{ $u->id }})">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                          </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
      <!-- [ Main Content ] end -->
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if (session('success'))
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Sukses!',
          text: "{{ session('success') }}",
          showConfirmButton: false,
          timer: 3000
      });
  </script>
  @endif
  
  @if (session('error'))
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: "{{ session('error') }}",
          showConfirmButton: true
      });
  </script>
  @endif
  <script>
    function hapusBarang(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data user ini akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
              fetch(`/user/${id}`, {
                  method: "DELETE",
                  headers: {
                      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                      "Content-Type": "application/json"
                  }
              })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Dihapus!",
                            text: "Data user berhasil dihapus.",
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menghapus data.",
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    }
    </script>

  @endsection
  