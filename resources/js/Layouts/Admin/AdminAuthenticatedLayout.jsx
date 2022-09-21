import React from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import AdminLayout from './AdminLayout';

export default function AdminAuthenticatedLayout({children}) {
    const {flash, auth, errors} = usePage().props;
    const title = "Admin - Dashboard";
    const links = ['permission'];

    return (
        <AdminLayout
            auth={auth}
            errors={errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{title}</h2>}
            links={links}
        >
            <Head title={title} />

            {flash.message && (
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="alert">{flash.message}</div>
                    </div>
                </div>
            )}

            {children}
        </AdminLayout>
    );
}