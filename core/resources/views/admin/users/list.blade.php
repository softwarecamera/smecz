@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Branch')</th>
                                    <th>@lang('Email') | @lang('Phone')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Balance') | @lang('Account No.')</th>
                                    @if (can('admin.users.detail') || can('admin.users.kyc.details'))
                                        <th>@lang('Action')</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ __($loop->index + $users->firstItem()) }}</td>

                                        <td>
                                            <span class="fw-bold d-block">{{ __($user->fullname) }}</span>
                                            <span class="small">
                                                @can('admin.users.detail')
                                                    <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                                @else
                                                    <span>@</span>{{ $user->username }}
                                                @endcan
                                            </span>
                                        </td>

                                        <td>
                                            @if ($user->branch)
                                                <span class="fw-bold text--primary"> {{ __(@$user->branch->name) }}</span>
                                                <br>
                                                @can('admin.branch.staff.details')
                                                    <a href="{{ route('admin.branch.staff.details', $user->branch_staff_id) }}"> {{ __(@$user->branchStaff->name) }}</a>
                                                @else
                                                    {{ __(@$user->branchStaff->name) }}
                                                @endcan
                                            @else
                                                <span class="text--info fw-bold">@lang('Online')</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}<br>{{ $user->mobile }}</td>

                                        <td>
                                            <span class="fw-bold" title="{{ @$user->address->country }}">{{ $user->country_code }}</span>
                                        </td>

                                        <td>
                                            {{ showDateTime($user->created_at) }} <br> {{ diffForHumans($user->created_at) }}
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($user->balance) }}</span>
                                            <span class="d-block text--primary">{{ $user->account_number }}</span>
                                        </td>
                                        @if (can('admin.users.detail') || can('admin.users.kyc.details'))
                                            <td>
                                                <div class="button--group">
                                                    @can('admin.users.detail')
                                                        <a href="{{ route('admin.users.detail', $user->id) }}" class="btn btn-sm btn-outline--primary">
                                                            <i class="las la-desktop"></i> @lang('Details')
                                                        </a>
                                                    @endcan
                                                    @can('admin.users.kyc.details')
                                                        @if (request()->routeIs('admin.users.kyc.pending'))
                                                            <a href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank" class="btn btn-sm btn-outline--dark">
                                                                <i class="las la-user-check"></i>@lang('KYC Data')
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($users) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
