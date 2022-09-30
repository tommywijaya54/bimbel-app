import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from './Shared/Form/Form';

export default function EditForm(props) {
    return (
        <MainLayout
            {...props}
        >
            <h1 className='attention'>Common Edit Form</h1>
            <Form
                {...props.form_schema}
            >
            </Form>
        </MainLayout>
    );
}