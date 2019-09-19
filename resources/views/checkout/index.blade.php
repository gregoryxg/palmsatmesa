<html>
    <head>
    </head>
    <body>
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            var stripe = Stripe('{{env('STRIPE_KEY')}}');

            stripe.redirectToCheckout({
                // Make the id field from the Checkout Session creation API response
                // available to this file, so you can provide it as parameter here
                // instead of the placeholder.
                sessionId: '{{ $stripe_session_id }}'
            }).then(function (result) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, display the localized error message to your customer
                // using `result.error.message`.
                console.log(result.error.message);
            });
        </script>

    </body>
</html>
