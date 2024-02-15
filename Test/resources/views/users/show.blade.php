@extends('layouts.app')

@section('content')
    <<div class="container">
       <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card p-4">
                <div class="card">
                    <div class="card-header">{{ ucfirst($user->name) }} </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="card-text">User Name: {{ $user->user_name }}</p>
                                <p class="card-text">Name: {{ $user->name }}</p>
                                <p class="card-text">Email: {{ $user->email}}</p>
                                <p class="card-text">User Type: {{ $user->user_type }}</p>
                                <p class="card-text">User Status: {{ $user->status}}</p>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

