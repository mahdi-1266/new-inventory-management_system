@extends ('admin.admin_master')
@section ('admin_body')
  <div class="content">
    <!-- Start Content-->
    <div class="container-xxl">
      <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
          <h4 class="fs-18 fw-semibold m-0">All Product Catagory</h4>
        </div>

        <div class="text-end">
          <ol class="breadcrumb m-0 py-0">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-toggle="modal"
              data-bs-target="#standard-modal"
            >
              Add Category
            </button>
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
                  <th>Product Name</th>
                  <th>Product Slug</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($category as $key => $item)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->category_name }}</td>
                    <td>{{ $item->category_slug }}</td>

                    <td>
                      <button
                        type="button"
                        class="btn btn-success btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#category"
                        id="{{ $item->id }}"
                        onclick="categoryEdit(this.id)"
                      >
                        Edit
                      </button>
                      <a
                        href="{{ route('delete.category', $item->id) }}"
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

  <!-- Insert category -->
  <div
    class="modal fade"
    id="standard-modal"
    tabindex="-1"
    aria-labelledby="standard-modalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="standard-modalLabel">
            Product Category
          </h1>
        </div>
        <div class="modal-body">
          <form action="{{ route('store.category') }}" method="POST">
            @csrf

            <div class="form-group col-md-12">
              <label for="inputName" class="form-label"
              >Product Category Name</label
              >
              <input
                type="text"
                class="form-control"
                id="inputName"
                name="category_name"
                placeholder="Enter product name"
              />
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit category -->
  <div
    class="modal fade"
    id="category"
    tabindex="-1"
    aria-labelledby="standard-modalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="standard-modalLabel">
            Edit Product Category
          </h1>
        </div>
        <div class="modal-body">
          <form action="{{ route('update.category') }}" method="POST">
            @csrf

            <input type="hidden" name="cat_id" id="cat_id" />

            <div class="form-group col-md-12">
              <label for="inputName" class="form-label"
              >Product Category Name</label
              >
              <input
                type="text"
                class="form-control"
                id="cat_name"
                name="category_name"
                placeholder="Enter product name"
              />
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <script class="">
    function categoryEdit(id) {
      $.ajax({
        type: "GET",
        url: "/edit/category/" + id,
        dataType: "json",
        success: function (data) {
          // getting the input value
          $("#cat_name").val(data.category_name);
          $("#cat_id").val(data.id);
        },
      });
    }
  </script>
@endsection