import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import ListView from '@/Shared/ListView';

export default function Index(props) {
    return (
        <MainLayout
            auth={props.auth}
            errors={props.errors}
            title={props.page_title}
        >
            <div className="overflow-x-auto bg-white rounded shadow">
                <ListView
                    listprops={props}
                ></ListView>
            </div>
        </MainLayout>
    );
}
