import React from 'react';
import { Head } from '@inertiajs/inertia-react';
import AdminAuthenticatedLayout from '@/Layouts/Admin/AdminAuthenticatedLayout';

export default function AdminDashboard(props) {
    return (
        <AdminAuthenticatedLayout>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">The Dashboard for Admin and Owner</div>
                    </div>
                </div>
            </div>
        </AdminAuthenticatedLayout>
    );
}
