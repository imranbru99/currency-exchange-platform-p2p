@extends('admin.layouts.app')

@section('panel')
<div class="container-fluid" >
            <div class="card">
                <div class="card-header"> <div class="d-flex justify-content-center">  <span class="label label-success"><i id="operator_live" class="fa fa-circle" aria-hidden="true" style="color: rgb(139, 242, 74); opacity: 1;"></i> User Online Status</span>
      </div></div>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                          <th scope="col">@lang('SL')</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Last Seen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                           <tr>
                             <td data-label="@lang('Seria')l">{{ $loop->iteration }}</td>
                                <td><a href="{{ route('admin.users.detail', $user->id) }}">{{ $user->fullname }}</a></td>
                              <td>{{ $user->username }}</td>  
                                <td>
                                    {{ Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                </td>
                                <td>
                                    @if(Cache::has('user-is-online-' . $user->id))
                                        <span class="badge badge-success">Online</span>
                                    @else
                                        <span class="badge badge-secondary">Offline</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
</div>
@endsection
