import React from 'react';
import MainAuthenticatedLayout from '@/Layouts/MainAuthenticatedLayout';
import CreateForm from '@/Shared/CreateForm';

export default function Index(props) {
    return (
        <MainAuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            title={props.pagetitle}
        >
            <div className="overflow-x-auto bg-white rounded shadow">
                <CreateForm formprops={props}></CreateForm>
            </div>
        </MainAuthenticatedLayout>
    );
}
