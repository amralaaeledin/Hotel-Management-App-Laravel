@php
    $user = Auth::guard('web')->user();
    $role = $user->getRoleNames()[0];
    $prefix = $role;
    if (in_array($role, ['manager', 'receptionist'])) {
        $prefix = 'staff';
    }
@endphp

@extends('layouts.adminlte')

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection
@section('extra-js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                scrollX: true,
            });
        });
    </script>
@endsection

@section('title')
    {{ ucfirst($role) }} - Dashboard
@endsection
@section('navbar')
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="ml-auto navbar-nav">
        </ul>
    </nav>
    <!-- /.navbar -->
@endsection
@section('sidebar')
    <!-- Main Sidebar Container -->
    <aside style="min-width:fit-content;" class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/home" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span style="font-size:0.92em;" class="brand-text font-weight-light">{{ ucfirst($role) }} -
                Dashboard</span>
        </a>

        <!-- Sidebar -->
        <div class="mt-2 mb-3 sidebar">
            <!-- Sidebar user panel (optional) -->
            @if ($user->avatar)
                <div class="image">
                    <img style="width:60px; height:60px; object-fit:center;" src="{{ asset($user->avatar) }}"
                        class="img-circle elevation-2" alt="User Image">
                </div>
            @endif
            <div class="mt-2 info">
                <a href="#" class="d-block">{{ $user->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul style="position:relative; min-height: 75vh;" class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-header">STAFF</li>
                @can('view managers', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ $role }}/managers" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Managers
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view receptionists', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ $role }}/receptionists" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Receptionists
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view clients', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ $role }}/clients" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Clients
                            </p>
                        </a>
                    </li>
                @endcan
                @role('receptionist', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ $role }}/my-clients" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                My Clients
                            </p>
                        </a>
                    </li>
                @endrole
                <li class="nav-header">HOTEL</li>
                @can('view floors', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ $role }}/floors" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Floors
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view rooms', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ $role }}/rooms" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Manage Rooms
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view reservations', 'web')
                    <li class="nav-item has-treeview">
                        <a href="/{{ $role }}/reservations" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Client Reservations
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-header" style="margin-top:auto;">SETTINGS</li>
                @if ($prefix != 'admin')
                    <li style="cursor:pointer; bottom:10px; width:100%;" class="nav-item has-treeview">
                        <a href="{{ route($role . 's' . '.edit', $user->id) }}" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Edit Profile
                            </p>
                        </a>
                    </li>
                @endif
                <li style="cursor:pointer; bottom:10px;  width:100%;" class="nav-item has-treeview">
                    <form action="{{ route($prefix . '.logout') }}" method="POST">
                        @csrf
                        <button class="nav-link" onmouseout="this.style.color='#6c757d'"
                            onmouseover="this.style.color='#fff'"
                            style="width:100%; text-align:left; border:none; outline:none; background:transparent; color:#6c757d;"
                            type="submit">
                            <i class="nav-icon fas fa-cog"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endsection
@section('content')
    <div class="pt-4 content-wrapper">
        @if (session('success'))
            <div class="container">
                <div class="mb-4 alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @elseif (session('fail'))
            <div class="container">
                <div class="mb-4 alert alert-danger">
                    {{ session('fail') }}
                </div>
            </div>
        @endif

        <!-- /.home -->
        @if (isset($user) && explode('/', Request::url())[4] === 'dashboard')
            <div class="mx-auto card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <h6 style="margin-top:22px;" class="mb-2 card-subtitle text-muted">{{ $user->getRoleNames()[0] }}</h6>
                    <p class="card-text">{{ $user->email }}</p>
                </div>
            </div>
        @endif


        <!-- /.managers -->
        @can('view managers', 'web')
            @if (isset($managers))
                <div class="container">
                    <a href="{{ route('staff.register', 'manager') }}" type="button"
                        class="m-0 mb-4 mr-1 btn btn-success btn-lg">Add Manager</a>
                    @if (!empty($managers))
                        <x-data-table>
                            <x-slot name="thead">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold sorting sorting_asc" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" style="width: 105px"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                            #
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Name
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            National Id
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Email
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Avatar
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Added By
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                            </x-slot>
                            <x-slot name="tbody">
                                <tbody>
                                    @foreach ($managers as $manager)
                                        <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                            <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                            <td class="dtr-control sorting_1" tabindex="1">{{ $manager->name }}</td>
                                            <td>{{ $manager->national_id }}</td>
                                            <td>{{ $manager->email }}</td>
                                            <td><img alt="manager-avatar" width="42"
                                                    src="{{ asset($manager->avatar) }}" /></td>
                                            <td>
                                                {{ $manager->creator->name }}
                                            </td>
                                            <td style="height:42px;"
                                                class="d-md-flex align-items-center justify-content-center">
                                                @can('edit managers', 'web')
                                                    <a href="{{ route('managers.edit', $manager->id) }}" style="width:60px;"
                                                        type="button" class="m-0 mr-1 btn btn-block btn-info btn-xs">Edit</a>
                                                @endcan
                                                @can('delete managers', 'web')
                                                    <button type="button" style="width:60px;"
                                                        class="m-0 mr-1 btn btn-block btn-xs btn-danger" data-toggle="modal"
                                                        data-target="#modal{{ $manager->id }}">
                                                        Delete
                                                    </button>
                                                    <div class="modal fade" id="modal{{ $manager->id }}"
                                                        style="display: none; padding-right: 14px;" aria-modal="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Delete Manager</h4>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div style="text-align:left;" class="modal-body">
                                                                    <p>You Sure you want to
                                                                        delete this ?</p>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                    <form style="display: inline"
                                                                        action="{{ route('managers.destroy', $manager->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="m-0 btn btn-block btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </x-slot>
                            <x-slot name="tfoot">
                                <tfoot>
                                    <tr>
                                        <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">National Id</th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Email
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Avatar
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Added By
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </x-slot>
                        </x-data-table>
                    @endif
                </div>
            @endif
        @endcan

        <!-- /.receptionists -->
        @can('view receptionists', 'web')
            @if (isset($receptionists))
                <div class="container">
                    <a href="{{ route('staff.register', 'receptionist') }}" type="button"
                        class="m-0 mb-4 mr-1 btn btn-success btn-lg">Add Receptionist</a>
                    @if (!empty($receptionists))
                        <x-data-table>
                            <x-slot name="thead">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold sorting sorting_asc" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" style="width: 105px"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                            #
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Name
                                        </th>

                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Email
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Created At
                                        </th>

                                        @role('admin', 'web')
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">
                                                Manager Name
                                            </th>
                                        @endrole
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                            </x-slot>
                            <x-slot name="tbody">
                                <tbody>
                                    @foreach ($receptionists as $receptionist)
                                        <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                            <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                            <td class="dtr-control sorting_1" tabindex="1">{{ $receptionist->name }}</td>
                                            <td>{{ $receptionist->email }}</td>
                                            <td>{{ $receptionist->getCreatedAt() }}</td>
                                            @role('admin', 'web')
                                                <td>
                                                    {{ $receptionist->creator->name }}
                                                </td>
                                            @endrole
                                            <td style="height:42px;"
                                                class="d-md-flex align-items-center justify-content-center">
                                                @if ($user->id == $receptionist->creator->id || $role == 'admin')
                                                    @can('ban receptionists', 'web')
                                                        <a href="{{ route('receptionists.ban', $receptionist->id) }}"
                                                            style="width:60px;" type="button"
                                                            class="m-0 mr-1 btn btn-block btn-dark btn-xs">
                                                            @if ($receptionist->banned_at)
                                                                Unban
                                                            @else
                                                                Ban
                                                            @endif
                                                        </a>
                                                    @endcan
                                                    @can('edit receptionists', 'web')
                                                        <a href="{{ route('receptionists.edit', $receptionist->id) }}"
                                                            style="width:60px;" type="button"
                                                            class="m-0 mr-1 btn btn-block btn-info btn-xs">Edit</a>
                                                    @endcan
                                                    @can('delete receptionists', 'web')
                                                        <button type="button" style="width:60px;"
                                                            class="m-0 mr-1 btn btn-block btn-xs btn-danger" data-toggle="modal"
                                                            data-target="#modal{{ $receptionist->id }}">
                                                            Delete
                                                        </button>
                                                        <div class="modal fade" id="modal{{ $receptionist->id }}"
                                                            style="display: none; padding-right: 14px;" aria-modal="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Delete Receptionist</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div style="text-align:left;" class="modal-body">
                                                                        <p>You Sure you want to
                                                                            delete this ?</p>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <form style="display: inline"
                                                                            action="{{ route('receptionists.destroy', $receptionist->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="m-0 btn btn-block btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                    @endcan
                                                @else
                                                    No actions allowed
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </x-slot>
                            <x-slot name="tfoot">
                                <tfoot>
                                    <tr>
                                        <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Email
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Created At
                                        </th>
                                        @role('admin', 'web')
                                            <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                                Manager Name
                                            </th>
                                        @endrole
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </x-slot>
                        </x-data-table>
                    @endif
                </div>
            @endif
        @endcan


        <!-- /.clients -->
        @can('view clients', 'web')
            @if (isset($clients))
                <div class="container">
                    @if (!empty($clients))
                        <x-data-table>
                            <x-slot name="thead">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold sorting sorting_asc" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" style="width: 105px"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                            #
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Name
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Gender
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Email
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Mobile
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Country
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Avatar
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Approved
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                            </x-slot>
                            <x-slot name="tbody">
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                            <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                            <td class="dtr-control sorting_1" tabindex="1">{{ $client->name }}</td>
                                            <td>{{ $client->getGender() }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->mobile }}</td>
                                            <td>{{ $client->getCountry() }}</td>
                                            <td><img alt="client-avatar" width="42"
                                                    src="{{ asset($client->avatar) }}" /></td>
                                            <td>
                                                @if ($client->approved)
                                                    Approved
                                                @else
                                                    <form action="{{ route('clients.approve', $client->id) }}" method="POST"
                                                        style="display: inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-block bg-gradient-primary btn-xs">Aprrove
                                                            Now!</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td style="height:42px;"
                                                class="dt-body-right dtr-hidden d-md-flex align-items-center justify-content-center">
                                                @if (
                                                    !in_array($role, ['receptionist']) &&
                                                        ($user->id == $client->approver?->id || in_array($role, ['admin', 'manager'])))
                                                    @can('edit clients', 'web')
                                                        <a href="{{ route('clients.edit', $client->id) }}" style="width:60px;"
                                                            type="button" class="m-0 mr-1 btn btn-block btn-info btn-xs">Edit</a>
                                                    @endcan
                                                    @can('delete clients', 'web')
                                                        <button type="button" style="width:60px;"
                                                            class="m-0 mr-1 btn btn-block btn-xs btn-danger" data-toggle="modal"
                                                            data-target="#modal{{ $client->id }}">
                                                            Delete
                                                        </button>
                                                        <div class="modal fade" id="modal{{ $client->id }}"
                                                            style="display: none; padding-right: 14px;" aria-modal="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Delete Client</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div style="text-align:left;" class="modal-body">
                                                                        <p>You Sure you want to
                                                                            delete this ?</p>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <form style="display: inline"
                                                                            action="{{ route('clients.destroy', $client->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="m-0 btn btn-block btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                    @endcan
                                                @else
                                                    No actions allowed
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </x-slot>
                            <x-slot name="tfoot">
                                <tfoot>
                                    <tr>
                                        <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Gender</th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Email
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Mobile
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Country
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Avatar
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Approved
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </x-slot>
                        </x-data-table>
                    @endif
                </div>
            @endif
        @endcan

        <!-- /.floors -->
        @can('view floors', 'web')
            @if (isset($floors))
                <div class="container">
                    <a href="{{ route('floors.create') }}" type="button" class="m-0 mb-4 mr-1 btn btn-success btn-lg">Add
                        Floor</a>
                    @if (!empty($floors))
                        <x-data-table>
                            <x-slot name="thead">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold sorting sorting_asc" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" style="width: 105px"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                            #
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Name
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Number
                                        </th>
                                        @role('admin', 'web')
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">
                                                Manager Name
                                            </th>
                                        @endrole
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                            </x-slot>
                            <x-slot name="tbody">
                                <tbody>
                                    @foreach ($floors as $floor)
                                        <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                            <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                            <td class="dtr-control sorting_1" tabindex="1">{{ $floor->name }}</td>
                                            <td>{{ $floor->id }}</td>
                                            @role('admin', 'web')
                                                <td>
                                                    {{ $floor->creator->name }}
                                                </td>
                                            @endrole
                                            <td style="height:42px;"
                                                class="dt-body-right dtr-hidden d-md-flex align-items-center justify-content-center">
                                                @if ($user->id == $floor->creator->id || $role == 'admin')
                                                    @can('edit floors', 'web')
                                                        <a href="{{ route('floors.edit', $floor->id) }}" style="width:60px;"
                                                            type="button" class="m-0 mr-1 btn btn-block btn-info btn-xs">Edit</a>
                                                    @endcan
                                                    @can('delete floors', 'web')
                                                        <button type="button" style="width:60px;"
                                                            class="m-0 mr-1 btn btn-block btn-xs btn-danger" data-toggle="modal"
                                                            data-target="#modal{{ $floor->id }}">
                                                            Delete
                                                        </button>
                                                        <div class="modal fade" id="modal{{ $floor->id }}"
                                                            style="display: none; padding-right: 14px;" aria-modal="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Delete Floor</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div style="text-align:left;" class="modal-body">
                                                                        <p>You Sure you want to
                                                                            delete this ?</p>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <form style="display: inline"
                                                                            action="{{ route('floors.destroy', $floor->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="m-0 btn btn-block btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                    @endcan
                                                @else
                                                    No actions allowed
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </x-slot>
                            <x-slot name="tfoot">
                                <tfoot>
                                    <tr>
                                        <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Number</th>
                                        @role('admin', 'web')
                                            <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                                Manager Name
                                            </th>
                                        @endrole
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </x-slot>
                        </x-data-table>
                    @endif
                </div>
            @endif
        @endcan


        <!-- /.rooms -->
        @can('view rooms', 'web')
            @if (isset($rooms))
                <div class="container">
                    <a href="{{ route('rooms.create') }}" type="button" class="m-0 mb-4 mr-1 btn btn-success btn-lg">Add
                        Room</a>
                    @if (!empty($rooms))
                        <x-data-table>
                            <x-slot name="thead">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold sorting sorting_asc" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" style="width: 105px"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                            #
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Number
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Floor Name
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Capacity
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Price
                                        </th>
                                        @role('admin', 'web')
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">
                                                Manager Name
                                            </th>
                                        @endrole
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                            </x-slot>
                            <x-slot name="tbody">
                                <tbody>
                                    @foreach ($rooms as $room)
                                        <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                            <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                            <td class="dtr-control sorting_1" tabindex="1">{{ $room->id }}</td>
                                            <td>{{ $room->floor->name }}</td>
                                            <td>{{ $room->capacity }}</td>
                                            <td>{{ $room->price }}</td>
                                            @role('admin', 'web')
                                                <td>
                                                    {{ $room->creator->name }}
                                                </td>
                                            @endrole
                                            <td style="height:42px;"
                                                class="dt-body-right dtr-hidden d-md-flex align-items-center justify-content-center">
                                                @if ($user->id == $room->creator->id || $role == 'admin')
                                                    @can('edit rooms', 'web')
                                                        <a href="{{ route('rooms.edit', $room->id) }}" style="width:60px;"
                                                            type="button" class="m-0 mr-1 btn btn-block btn-info btn-xs">Edit</a>
                                                    @endcan
                                                    @can('delete rooms', 'web')
                                                        <button type="button" style="width:60px;"
                                                            class="m-0 mr-1 btn btn-block btn-xs btn-danger" data-toggle="modal"
                                                            data-target="#modal{{ $room->id }}">
                                                            Delete
                                                        </button>
                                                        <div class="modal fade" id="modal{{ $room->id }}"
                                                            style="display: none; padding-right: 14px;" aria-modal="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Delete Room</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div style="text-align:left;" class="modal-body">
                                                                        <p>You Sure you want to
                                                                            delete this ?</p>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <form style="display: inline"
                                                                            action="{{ route('rooms.destroy', $room->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="m-0 btn btn-block btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                    @endcan
                                                @else
                                                    No actions allowed
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </x-slot>
                            <x-slot name="tfoot">
                                <tfoot>
                                    <tr>
                                        <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                        <th rowspan="1" colspan="1">Number</th>
                                        <th rowspan="1" colspan="1">Floor Name</th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Capacity
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Price
                                        </th>
                                        @role('admin', 'web')
                                            <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                                Manager Name
                                            </th>
                                        @endrole
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </x-slot>
                        </x-data-table>
                    @endif
                </div>
            @endif
        @endcan

        <!-- /.reservations -->
        @can('view reservations', 'web')
            @if (isset($reservations))
                <div class="container">

                    @if (!empty($reservations))
                        <x-data-table>
                            <x-slot name="thead">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold sorting sorting_asc" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" style="width: 105px"
                                            aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                            #
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Client
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Room Number
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Floor Name
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Duration
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Price Paid Per Day
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Accompany Number
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            Start Date
                                        </th>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 105px" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">
                                            End Date
                                        </th>
                                    </tr>
                                </thead>
                            </x-slot>
                            <x-slot name="tbody">
                                <tbody>
                                    @foreach ($reservations as $reservation)
                                        <tr class="{{ $loop->index % 2 === 0 ? 'odd' : 'even' }}">
                                            <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                                            <td class="dtr-control sorting_1" tabindex="1">
                                                {{ $reservation->client->name }}</td>
                                            <td>{{ $reservation->room->id }}</td>
                                            <td>{{ $reservation->floor->name }}</td>
                                            <td>{{ $reservation->duration }}</td>
                                            <td>{{ $reservation->price_paid_per_day }}</td>
                                            <td>{{ $reservation->accompany_number }}</td>
                                            <td>{{ $reservation->getStDate() }}</td>
                                            <td>{{ $reservation->getEndDate() }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </x-slot>
                            <x-slot name="tfoot">
                                <tfoot>
                                    <tr>
                                        <th class="font-weight-bold" rowspan="1" colspan="1">#</th>
                                        <th rowspan="1" colspan="1">Client</th>
                                        <th rowspan="1" colspan="1">Room Number</th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Floor Name
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Duration
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Price Paid Per Day
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Accompany Number
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            Start Date
                                        </th>
                                        <th class="dt-body-right dtr-hidden" rowspan="1" colspan="1"">
                                            End Date
                                        </th>
                                    </tr>
                                </tfoot>
                            </x-slot>
                        </x-data-table>
                    @endif
                </div>
            @endif
        @endcan

    </div>

@endsection
