@extends ('admin.admin_master')
@section ('admin_body')
  <div class="content">
    <!-- Start Content-->
    <div class="container-xxl">
      <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
          <h4 class="fs-18 fw-semibold m-0">All Brands</h4>
        </div>

        <div class="text-end">
          <ol class="breadcrumb m-0 py-0">
            <a href="{{ route('add.brand') }}" class="btn btn-secondary"
              >Add Brand</a
            >
          </ol>
        </div>
      </div>

      <!-- Datatables  -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table
                id="datatable"
                class="table table-bordered dt-responsive table-responsive nowrap"
              >
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($brand as $key => $logo)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $logo->name }}</td>
                      <td>
                        <img
                          src="{{ asset($logo->logo) }}"
                          alt="Brand Logo"
                          style="width: 70px; height: 40px"
                        />
                      </td>
                      <td>
                        <a
                          href="{{ route('edit.brand', $logo->id) }}"
                          class="btn btn-success btn-sm"
                          >Edit</a
                        >
                        <a
                          href="{{ route('delete.brand', $logo->id) }}"
                          class="btn btn-danger btn-sm"
                          id="deleteBrand"
                          >Delete</a
                        >
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
    <!-- container-fluid -->
  </div>
  <!-- content -->
@endsection