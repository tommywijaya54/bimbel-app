import React from 'react';
import { Head } from '@inertiajs/inertia-react';
import AdminAuthenticatedLayout from '@/Layouts/Admin/AdminAuthenticatedLayout';

export default function SADashboard(props) {
    const links = ['user','permission'];

    return (
        <AdminAuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            title="Admin - Dashboard"
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Admin - Dashboard</h2>}
            links={links}
        >
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">You're logged in!</div>
                    </div>
                </div>
            </div>

        </AdminAuthenticatedLayout>
    );
}
