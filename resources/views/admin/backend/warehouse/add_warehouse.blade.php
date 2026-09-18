@extends ('admin.admin_master')
@section ('admin_body')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <div class="content">
    <!-- Start Content-->
    <div class="container-xxl">
      <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="text-end">
          <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item">
              <a href="javascript: void(0);">Forms</a>
            </li>
            <li class="breadcrumb-item active">Add WareHouse</li>
          </ol>
        </div>
      </div>

      <!-- Form Validation -->
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Add WareHouse</h5>
            </div>
            <!-- end card header -->

            <div class="card-body">
              <form
                action="{{ route('store.warehouse') }}"
                class="row g-3"
                method="POST"
              >
                @csrf

                <div class="col-md-6">
                  <label for="name" class="form-label">WareHouse Name:</label>
                  <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    placeholder="Enter your warehouse name"
                  />
                  @error ('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="email" class="form-label">WareHouse Email:</label>
                  <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Enter your warehouse email"
                  />
                  @error ('email')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="phone" class="form-label">WareHouse Phone:</label>
                  <input
                    type="text"
                    class="form-control @error('phone') is-invalid @enderror"
                    id="phone"
                    name="phone"
                    placeholder="Enter your warehouse phone"
                  />
                  @error ('phone')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="city" class="form-label">WareHouse City:</label>
                  <input
                    type="text"
                    class="form-control @error('city') is-invalid @enderror"
                    id="city"
                    name="city"
                    placeholder="Enter your warehouse city"
                  />
                  @error ('city')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-12">
                  <button class="btn btn-primary" type="submit">
                    Add WareHouse
                  </button>
                </div>
              </form>
            </div>
            <!-- end card-body -->
          </div>
          <!-- end card-->
        </div>
        <!-- end col -->
      </div>
    </div>
    <!-- container-fluid -->
  </div>

  <script type="text/javascript">
    $(document).ready(function () {
      $("#logo").change(function (e) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#showLogo").attr("src", e.target.result);
        };
        reader.readAsDataURL(e.target.files["0"]);
      });
    });
  </script>
@endsection