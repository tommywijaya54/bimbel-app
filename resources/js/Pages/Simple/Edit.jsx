import React from 'react';
import MainAuthenticatedLayout from '@/Layouts/MainAuthenticatedLayout';
import CompRowAndBox from '@/Shared/CompRowAndBox';
import Display from '@/Shared/Display';
import SmartFooterButton from '@/Components/SmartFooterButton';

export default function Show(props) {
    const data = props.data;
    return (
        <MainAuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            title={props.page_title}
            header_action={props.action_button}
        >
            <CompRowAndBox
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        {data.name}
                        <span className="info">{props.component_header}</span>
                    </h2>}
                footer={
                    <SmartFooterButton 
                        componentFor={props.component_for} 
                        obj={data}
                        ></SmartFooterButton>
                }
            >
                <Display
                    content={props.data}
                    fields={props.view}
                >
                </Display>
            </CompRowAndBox>
        </MainAuthenticatedLayout>
    );
}
