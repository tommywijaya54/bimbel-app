import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage } from '@inertiajs/inertia-react';
import HeaderAction from '@/Shared/LayoutComponent/HeaderAction';

export default function MainLayout({auth, errors, title, children}) {
    const {flash} = usePage().props;

    return (
        <AuthenticatedLayout
            auth={auth}
            errors={errors}
            hasHeader={title}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">{title}
                    <HeaderAction></HeaderAction>
                </h2>
            }
        >
            <Head title={title} />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {flash.message && (
                        <div className="alert">{flash.message}</div>
                    )}
                    {children}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}