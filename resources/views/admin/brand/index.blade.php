<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            <b>Brand all </b>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        @once
                            @if ($message = session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <strong>{{ $message }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        @endonce

                        <div class="card-header"> All Category </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID No</th>
                                    <th scope="col"> Brnad Name </th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <!-- @php($i = 1) -->
                                @foreach ($brand as $brand)
                                  <tr>
                                      <th scope="row"> {{ $brand->firstItem() + $loop->index }} </th>
                                      <td> {{ $brand->brand_name}} </td>
                                      <td> </td>
                                      <td>
                                          @if ($brand->created_at == null)
                                              <span class="text-danger"> No Date Set</span>
                                          @else
                                              {{ Carbon\Carbon::parse($brand->created_at)->diffForHumans() }}
                                          @endif
                                      </td>
                                      <td>
                                          {{-- <a href="{{ url('category/edit/' . $brand->id) }}"
                                              class="btn btn-info">Edit</a>
                                          <a href="{{ url('softdelete/category/' . $brand->id) }}"
                                              class="btn btn-danger">Delete</a> --}}
                                      </td>
                                  </tr>
                                 @endforeach

                            </tbody>
                        </table>
                        {{$brand->links()}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"> Add Brand </div>
                        <div class="card-body">
                            <form action="{{ route('brand.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brnad Name</label>
                                    <input type="text" name="brand_name" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"><br>
                                    <input type="file" name="brand_image" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp">
                                    @error('brand_name')
                                        <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Add Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Trash Part -->

        </div>

        <!-- End Trush -->



    </div>
</x-app-layout>
