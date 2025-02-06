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
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          
        </div>
        <!-- [ sample-page ] end -->
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

  @endsection
  