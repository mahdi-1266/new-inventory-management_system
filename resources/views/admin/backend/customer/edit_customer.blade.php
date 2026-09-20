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
            <li class="breadcrumb-item active">Edit Customer</li>
          </ol>
        </div>
      </div>

      <!-- Form Validation -->
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Edit Customer</h5>
            </div>
            <!-- end card header -->

            <div class="card-body">
              <form
                action="{{ route('update.customer') }}"
                class="row g-3"
                method="POST"
                enctype="multipart/form-data"
              >
                @csrf

                {{-- id is needed here to update the warehouse --}}
                <input
                  type="hidden"
                  class="form-control"
                  name="id"
                  value="{{ $customer->id }}"
                />

                <div class="col-md-6">
                  <label for="name" class="form-label">Customer Name:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    required=""
                    value="{{ $customer->name }}"
                    placeholder="Enter your warehouse name"
                  />
                </div>

                <div class="col-md-6">
                  <label for="email" class="form-label">Customer Email:</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ $customer->email }}"
                  />
                </div>

                <div class="col-md-6">
                  <label for="phone" class="form-label">Customer Phone:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="phone"
                    name="phone"
                    value="{{ $customer->phone }}"
                  />
                </div>

                <div class="col-md-6">
                  <label for="address" class="form-label"
                  >Customer Address:</label
                  >
                  <textarea
                    class="form-control"
                    name="address"
                    id="address"
                    required=""
                    placeholder="Enter supplier address"
                  >{{ $customer->address}}</textarea
                  >
                </div>

                <div class="col-12">
                  <button class="btn btn-primary" type="submit">
                    Update Supplier
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