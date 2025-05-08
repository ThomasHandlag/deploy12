import { Link, Head } from '@inertiajs/react';
export default function TestV({ auth, laravelVersion, phpVersion }) {
    return (
        <div>
            <div className="h-16 w-16 bg-red-50 flex items-center justify-center rounded-full">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    strokeWidth="1.5"
                    className="w-7 h-7 stroke-red-500"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"
                    />
                </svg>
            </div>

            <h2 className="mt-6 text-xl font-semibold text-gray-900">
                Documentation
            </h2>

            <p className="mt-4 text-gray-500 text-sm leading-relaxed">
                Laravel has wonderful documentation covering every aspect of the framework.
                Whether you are a newcomer or have prior experience with Laravel, we recommend
                reading our documentation from beginning to end.
            </p>
        </div>
    );
}
