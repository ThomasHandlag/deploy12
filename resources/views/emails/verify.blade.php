<x-mail::message>
# Verify Your Email Address

Please use the following one-time code to verify your email address:

**{{ $otpCode }}**

This code is valid for 1 minute.

If you did not create an account, no further action is required.

<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</x-mail::footer>
</x-slot:footer>
</x-mail::message>