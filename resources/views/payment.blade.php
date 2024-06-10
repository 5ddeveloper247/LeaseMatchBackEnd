<!DOCTYPE html>
<html>
<head>
    <title>Subscribe</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <form action="{{ route('subscribe.process') }}" method="POST" id="payment-form">
        @csrf
        <label for="subscription_id">Choose a subscription:</label>
        <select name="subscription_id" id="subscription_id" required>
            @foreach(@$subscriptions as $subscription)
                <option value="{{ $subscription->id }}">{{ $subscription->name }} (${{ $subscription->price }})</option>
            @endforeach
        </select>

        <div id="card-element"></div>
        <button type="submit">Subscribe</button>
    </form>

    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Display error.message in your UI.
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
