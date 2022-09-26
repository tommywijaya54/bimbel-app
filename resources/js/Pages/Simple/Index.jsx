import React from 'react';
import MainAuthenticatedLayout from '@/Layouts/MainAuthenticatedLayout';
import ListView from '@/Shared/ListView';

export default function Index(props) {
    return (
        <MainAuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            title={props.page_title}
            header_action={props.action_button}
        >
            <div className="overflow-x-auto bg-white rounded shadow">
                <ListView
                    listprops={props}
                ></ListView>
            </div>
        </MainAuthenticatedLayout>
    );
}
