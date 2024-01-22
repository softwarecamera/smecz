@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-12">
            <div class="custom--card">
                <div class="card-body">
                    <h5 class="text-center">
                        @lang('You have requested to invest in FDR')
                    </h5>
                    <p class="text--danger text-center">(@lang('Be Sure Before Confirm'))</p>
                    <ul class="mt-3">
                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">@lang('Plan')</span>
                            <span>{{ __($plan->name) }}</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">@lang('Profit Rate')</span>
                            <span>{{ getAmount($plan->interest_rate) }}%</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">@lang('Your Amount')</span>
                            <span>{{ $general->cur_sym . showAmount($amount) }}</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">@lang('Profit in Every') {{ $plan->installment_interval }} @lang('Days')</span>
                            <span>{{ $general->cur_sym . showAmount(($amount * $plan->interest_rate) / 100) }}</span>
                        </li>

                        <li class="pricing-card__list flex-between text--danger">
                            <span class="fw-bold">@lang('Can\'t Be Withdrawn Till')</span>
                            <span>{{ showDateTime(now()->addDays($plan->locked_days), 'd M, Y') }}</span>
                        </li>
                    </ul>

                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <a class="btn btn--dark" href="{{ route('user.home') }}">@lang('Cancel')</a>
                        <form action="{{ route('user.fdr.apply.confirm', $verificationId) }}" method="POST">
                            @csrf
                            <button class="btn btn--base" type="submit">@lang('Confirm')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('user.fdr.plans') }}" class="btn btn-outline--base">@lang('FDR Plans')</a>
            <a href="{{ route('user.fdr.list') }}" class="btn btn--base active">@lang('My FDR List')</a>
        </div>
    </div>
@endpush
