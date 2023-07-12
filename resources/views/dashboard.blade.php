<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hi Welcom {{Auth::user()->name}}
        </h2>
        <b style="float: left"> Total Of Users </b>
        <span class="badge bg-danger">{{count($users)}}</span>
    </x-slot>

    <div class="py-12">

            <div class="container">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col"># ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Eamil</th>
                        <th scope="col">Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            {{
                                $user->created_at->diffForHumans()

                             }}</td>
                      </tr>
                    @endforeach



                    </tbody>
                  </table>

            </div>


    </div>
</x-app-layout>
