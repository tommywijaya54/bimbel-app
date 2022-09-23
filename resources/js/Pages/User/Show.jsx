import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/inertia-react';
import DebugComponent from '@/Shared/Debug/DebugComponent';
import UserDetails from '@/Components/UserDetails';



export default function Show(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">User Details</h2>}
        >
            <Head title="Dashboard - User Details" />

            <div className="py-12">
                <UserDetails user={props.user}></UserDetails>

                
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">User Details</div>
                    </div>
                </div>

                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white mt-6 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className=" p-6 bg-white border-b border-gray-200">User Details</div>
                    </div>
                </div>
            </div>



            <DebugComponent></DebugComponent>
        </AuthenticatedLayout>
    );
}
