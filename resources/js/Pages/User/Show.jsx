import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/inertia-react';
import DebugComponent from '@/Shared/Debug/DebugComponent';
import UserDetails from '@/Components/UserDetails';
import ParentDetails from '@/Components/ParentDetails';
import StudentDetails from '@/Components/StudentDetails';

export default function Show(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">User Details</h2>}
        >
            <Head title="Dashboard - User Details" />

            <div className="py-12">
                <UserDetails user={props.user}>
                    <ParentDetails parent={props.details.parent}></ParentDetails>

                    {props.details.students.map((student,keyId) => {
                        return <StudentDetails key={keyId} student={student}></StudentDetails>
                    })}

                </UserDetails>
                
            </div>
            <DebugComponent></DebugComponent>
        </AuthenticatedLayout>
    );
}
