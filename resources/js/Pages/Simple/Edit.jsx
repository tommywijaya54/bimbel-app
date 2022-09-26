import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import CompRowAndBox from '@/Shared/CompRowAndBox';
import EditForm from '@/Shared/EditForm';

export default function Show(props) {
    return (
        <MainLayout
            auth={props.auth}
            errors={props.errors}
            title={props.page_title}
            header_action={props.action_button}
        >
            <div className='edit-form'>
                <CompRowAndBox
                    header={
                        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                            {props.data.name}
                            <span className="info">{props.component_header}</span>
                        </h2>}
                >
                    <EditForm
                        props={props}>
                    </EditForm>
                </CompRowAndBox>
            </div>
        </MainLayout>
    );
}
