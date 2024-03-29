@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="full-table">
        <table class="table table--responsive--md">
            <thead>
                <tr>
                    <th>@lang('S.N.')</th>
                    <th>@lang('Account No.')</th>
                    <th>@lang('Account Name')</th>
                    <th>@lang('Short Name')</th>
                    <th>@lang('Details')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($beneficiaries as $beneficiary)
                    <tr>
                        <td>{{ $loop->index + $beneficiaries->firstItem() }}</td>
                        <td> {{ $beneficiary->account_number }} </td>
                        <td>{{ $beneficiary->account_name }}</td>
                        <td> {{ $beneficiary->short_name }}</td>
                        <td>
                            <button class="btn btn--sm btn-outline--base sendBtn" data-id="{{ $beneficiary->id }}">
                                <i class="las la-hand-holding-usd"></i> @lang('Transfer Money')
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%">@lang($emptyMessage)</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($beneficiaries->hasPages())
        {{ paginateLinks($beneficiaries) }}
    @endif
@endsection

@push('modal')
    <div class="modal fade custom--modal" id="sendModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Transfer Money')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="form-label required">@lang('Amount')</label>
                            <div class="input-group custom-input-group">
                                <input class="form-control form--control" name="amount" type="text" required>
                                <span class="input-group-text">@lang($general->cur_text)</span>
                            </div>
                        </div>

                        @include($activeTemplate . 'partials.otp_field')

                        <div class="my-4">
                            <ul>
                                <li class="pricing-card__list flex-between">
                                    <span class="fw-bold">@lang('Limit Per Transaction')</span>
                                    <span>{{ $general->cur_sym . showAmount($general->minimum_transfer_limit) }} (@lang('Min'))</span>
                                </li>

                                <li class="pricing-card__list flex-between">
                                    <span class="fw-bold">@lang('Daily Limit')</span>
                                    <span>{{ $general->cur_sym . showAmount($general->daily_transfer_limit) }} (@lang('Max'))</span>
                                </li>

                                <li class="pricing-card__list flex-between">
                                    <span class="fw-bold">@lang('Monthly Limit')</span>
                                    <span>{{ $general->cur_sym . showAmount($general->monthly_transfer_limit) }} (@lang('Max'))</span>
                                </li>

                                @php $transferCharge = $general->transferCharge(); @endphp

                                @if ($transferCharge)
                                    <li class="pricing-card__list flex-between">
                                        <span class="fw-bold">@lang('Charge Per Transaction')</span>
                                        <span class="text--danger"> {{ $transferCharge }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        'use strict';
        (function($) {
            $('.sendBtn').on('click', function() {
                let modal = $('#sendModal');
                let route = `{{ route('user.transfer.own.bank.request', ':id') }}`;
                modal.find('form')[0].action = route.replace(':id', $(this).data('id'))
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush

<x-transfer-breadcrumb-menu />
