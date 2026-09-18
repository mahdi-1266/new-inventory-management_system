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
            <li class="breadcrumb-item active">Add Brand</li>
          </ol>
        </div>
      </div>

      <!-- Form Validation -->
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Add Brand</h5>
            </div>
            <!-- end card header -->

            <div class="card-body">
              <form
                action="{{ route('store.brand') }}"
                class="row g-3"
                method="POST"
                enctype="multipart/form-data"
              >
                @csrf
                <div class="col-md-6">
                  <label for="name" class="form-label">Brand Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    required=""
                    placeholder="Enter your brand name"
                  />
                </div>
                <div class="col-md-6">
                  <label for="logo" class="form-label">Brand Logo</label>
                  <input
                    type="file"
                    class="form-control"
                    name="logo"
                    id="logo"
                    required=""
                  />
                </div>

                <div class="col-md-6">
                  <img
                    src="{{ url('upload/no-photo.jpg') }}"
                    class="rounded-circle avatar-xxl img-thumbnail float-start"
                    style="width: 100px; height: 100px"
                    alt=""
                    id="showLogo"
                  />
                </div>

                <div class="col-12">
                  <button class="btn btn-primary" type="submit">
                    Add Brand
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