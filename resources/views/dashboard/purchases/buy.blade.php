@extends('layouts.form')
@section('card-title')
    Buy Package For User
@endsection
@section('form-action')
    {{route('dashboard.purchases.store')}}
@endsection
@section('form-method')
    @method('post')
@endsection
@section('form-content')
    <script src="https://js.stripe.com/v3/"></script>

    <div class="form-group row">
        <label for="package" class="col-sm-4 col-form-label">Training Package</label>
        <div class="col-sm-8">
            <select class="form-control select2" style="width: 100%;" id="package" name="package">
                @foreach($packages as $package)
                    <option value="{{$package->id}}">{{$package->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="user" class="col-sm-4 col-form-label">User</label>
        <div class="col-sm-8">
            <select class="form-control select2" style="width: 100%;" id="user" name="user">
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @hasanyrole('city_manager|admin')
    <div class="form-group row">
        <label for="gym" class="col-sm-4 col-form-label">GYM</label>
        <div class="col-sm-8">
            <select class="form-control select2" style="width: 100%;" id="gym" name="gym">
                @foreach($gyms as $gym)
                    <option value="{{$gym->id}}">{{$gym->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endrole
    <hr>
    <div class="form-group">
        <label for="card-element">Credit Card</label>
        <div id="card-element">
            <!-- a Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors -->
        <div id="card-errors" role="alert"></div>
    </div>

@endsection
@section('page-footer')
    <script>
        (function(){
            $('.select2').select2()
            var stripe = Stripe('{{ env('STRIPE_KEY') }}');
            var elements = stripe.elements();
            var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Raleway", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });
            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            // Handle form submission
            var form = document.querySelector('#mainForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                var options = {
                    name: document.getElementById('user').options[document.getElementById('user').selectedIndex].text,
                }
                stripe.createToken(card, options).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            });
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('mainForm');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                // Submit the form
                form.submit();
            }
        })();
    </script>
@endsection

