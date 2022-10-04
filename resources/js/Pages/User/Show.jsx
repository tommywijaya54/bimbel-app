import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';
import UnitMapField from '@/Shared/DisplayPageComponent/Field/UnitMapField';

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

            <div>
                <fieldset className='shadow-lg'>
                    <legend>Extra Information</legend>
                    
                    <UnitMapField map={props.user.permission} header={
                        <h2 className='text-lg'>Permissions</h2>
                    }></UnitMapField>
                    
                </fieldset>
            </div>
        </MainLayout>
    );
}