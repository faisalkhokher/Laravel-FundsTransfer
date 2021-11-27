@extends('layouts.backend')

@section('content')

<button id="link-button">Link Account</button>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var handler = Plaid.create({
            token: '{{ $link->link_token }}',
            onLoad: function() {
                // Optional, called when Link loads
            },

            onSuccess: (public_token, metadata) => {
                console.log('Success!');
                console.log(public_token);
                console.log(metadata);
                fetch('{{ route('plaid-redirect') }}', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('input[name="_token"]').val()
                    },

                    method: "post",
                    credentials: "same-origin",
                    body: JSON.stringify({
                        public_token: public_token,
                        accounts: metadata.accounts,
                        institution: metadata.institution,
                        link_session_id: metadata.link_session_id,
                    })

                });
            },
            onExit: function(err, metadata) {
                // The user exited the Link flow.
                if (err != null) {
                    // The user encountered a Plaid API error prior to exiting.
                    console.log('Error');
                    console.log(err);
                    console.log(metadata);
                }
                // metadata contains information about the institution
                // that the user selected and the most recent API request IDs.
                // Storing this information can be helpful for support.
            }
            {{--,receivedRedirectUri: '{{ route('plaid-redirect') }}',--}}

        });

        $('#link-button').on('click', function(e) {
            handler.open();
        });

    })

</script>

@endsection