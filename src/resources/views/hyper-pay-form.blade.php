<link rel="stylesheet" href="/hyperpay/style.css">

<div>
    @if (session('alert') || empty($config['gatewayes']))
        <div class='hy_alert-container'>
            <div class="hy_alert hy_alert-danger hy_alert-white rounded">
                <div class="hy_icon">x</div>
                <strong> {{ session('alert') ?? 'Configration Error! No Gatewayes found in config' }}</strong>
            </div>
            @if(session('alert'))
                <div class="btn-reload">{{ __('payment.Pay_Again_?') }}</div>
            @endif
        </div>
    @endif

    <div @if (Config::get('app.locale') == 'ar') class="arabic-card @if (session('alert')) hidden @endif" @endif>
        <div class="brands-container">
            @foreach($config['gatewayes'] ?? [] as $key => $gateway)
                <label class="hy_btn-container ">
                    <span>{{ __('payment.' . ($gateway['label'] ?? $key)) }}</span>
                    @foreach (explode(' ', $gateway['brands']) ?? [] as $brand)
                        <div class="wpwl-brand-{{ $brand }}  wpwl-img"></div>
                    @endforeach
                    <input class="brand"
                        @if ($loop->index == 0) {{ $bran = $gateway['brands'] }} checked @endif
                        data-checkout_id="{{ $prepare($key) }}" data-brands="{{ $gateway['brands'] }}" type="radio"
                        name="brands">
                    <div class="checked"></div>
                </label>
            @endforeach
        </div>
        <div id="hyperpay_forms_container"></div>
    </div>

</div>
<script src="https://code.jquery.com/jquery.js" type="text/javascript"></script>
<script>
    var locale = "{{ Config::get('app.locale') }}";
    var paymentWidgets = "{{ $paymentWidgets }}";
    var postBack_URL = "{{ URL::to('/hyperpay/payment') }}";

    $('.btn-reload').on('click', function() {
        $('.hidden').removeClass('hidden');
        $('.btn-reload').remove()
    })
</script>
<script src="/hyperpay/script.js"></script>
