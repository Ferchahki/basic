<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Edit Category<b></b>
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
                        <div class="card">
                            <div class="card-header"> Update Category </div>
                            <div class="card-body">
                                <form action="{{ url('category/update/'.$categories->id)  }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category Name</label>
                                        <input type="text" name="category_name" class="form-control"
                                            id="exampleInputEmail1"  value="{{$categories->category_name}}"
                                            aria-describedby="emailHelp">
                                        @error('category_name')
                                            <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Update Category</button>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>



    </div>
</x-app-layout>
