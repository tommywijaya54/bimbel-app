import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';
import UnitMapField from '@/Shared/DisplayPageComponent/Field/UnitMapField';
import DetailsSummaryComponent from '@/Shared/DisplayPageComponent/Element/DetailsSummaryComponent';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <h1 className='attention'>Show User details</h1>
            <Form
                {...props.form_schema}
            >
            </Form>

            
            <fieldset className='shadow-lg'>
                <legend>Extra Information</legend>
                <div className='p-6'>
                    <DetailsSummaryComponent
                        header='Permissions'>
                        <UnitMapField map={props.user.permission}></UnitMapField>
                    </DetailsSummaryComponent>
                </div>
            </fieldset>
        </MainLayout>
    );
}