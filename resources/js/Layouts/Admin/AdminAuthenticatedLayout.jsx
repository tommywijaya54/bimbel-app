import React from 'react';
import { Head, usePage } from '@inertiajs/inertia-react';
import AdminLayout from './AdminLayout';

export default function AdminAuthenticatedLayout({auth, errors, title, children, links}) {
    const {flash} = usePage().props;
    
    return (
        <AdminLayout
            auth={auth}
            errors={errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{title}</h2>}
            links={links}
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
        </AdminLayout>
    );
}