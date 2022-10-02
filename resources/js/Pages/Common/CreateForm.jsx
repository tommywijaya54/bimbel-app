import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';

export default function CreateForm(props) {
    return (
        <MainLayout
            {...props}
        >
            <h1 className='attention'>Common Create Form</h1>
            <Form
                {...props.form_schema}
            >
            </Form>
        </MainLayout>
    );
}