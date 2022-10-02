import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import CompRowAndBox from '@/Shared/CompRowAndBox';
import Display from '@/Shared/Display';
import SmartFooterButton from '@/Components/Layout/FormFooterButton';

export default function Show(props) {
    return (
        <MainLayout
            auth={props.auth}
            errors={props.errors}
            title={props.page_title}
        >
            <CompRowAndBox
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        {props.data.name}
                        <span className="info">{props.component_header}</span>
                    </h2>}
                footer={
                    <SmartFooterButton 
                        componentFor={props.modal} 
                        obj={props.data}
                        ></SmartFooterButton>
                }
            >
                <Display
                    content={props.data}
                    fields={props.form_fields}
                >
                </Display>
            </CompRowAndBox>
        </MainLayout>
    );
}
