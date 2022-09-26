import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import CompRowAndBox from '@/Shared/CompRowAndBox';
import CreateForm from '@/Shared/CreateForm';

export default function Index(props) {
    return (
        <MainLayout
            auth={props.auth}
            errors={props.errors}
            title={props.page_title}
        >
            <div className='create-form'>
                <CompRowAndBox
                    header={
                        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                            Create form for {props.modal}
                        </h2>}
                >
                    <CreateForm props={props}></CreateForm>
                </CompRowAndBox>
            </div>
        </MainLayout>
    );
}
