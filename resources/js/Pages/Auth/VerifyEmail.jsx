import PrimaryButton from '@/Components/PrimaryButton';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({});

    const verify = (e) => {
        e.preventDefault();

        post(route('verify'), {
            data: {
                code: e.target.code.value,
            },
            preserveScroll: true,
            onSuccess: () => {
                // Handle success, e.g., redirect to a different page
            },
            onError: (errors) => {
                // Handle errors, e.g., show error messages
            },
        });
    }

    return (
        <GuestLayout>
            <Head title="Email Verification" />

            <div className="mb-4 text-sm text-gray-600">
                Thanks for signing up! Before getting started, could you verify
                your email address by enter the 6 digit code we just emailed to
                you? If you didn't receive the email, we will gladly send you
                another.
            </div>

            {status === 'verification-code-sent' && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    A new verification code has been sent to the email address
                    you provided during registration.
                </div>
            )}

            <form onSubmit={verify}>
                <div className="mt-4 flex flex-col items-center justify-between">
                    <input
                        type="text"
                        id="code"
                        name="code"
                        className="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm sm:text-sm"
                        placeholder="Enter the code"
                        required
                        autoComplete="one-time-code"
                        autoFocus
                        maxLength={6}
                    />
                    <div className='mt-4 flex flex-row items-center gap-6 justify-between'>
                        <PrimaryButton disabled={processing} className="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-300"
                        >
                            Verification Email
                        </PrimaryButton>
                        <Link
                            href={route('verification.send')}
                            method="post"
                            as="button"
                            className="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300"
                        >
                            {status == 'verification-code-sent'
                                ? 'Resend Verification Code'
                                : 'Send Verification Code'}
                        </Link>
                    </div>
                </div>
            </form>
            <Link
                href={route('logout')}
                method="post"
                as="button"
                className="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            >
                Log Out
            </Link>
        </GuestLayout>
    );
}
