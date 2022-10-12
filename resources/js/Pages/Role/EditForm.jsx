import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';

export default function EditForm(props) {
    return (
        <MainLayout
            {...props}
        >
            <h1 className='attention'>Role Edit Form</h1>
            <Form
                {...props.form_schema}
            >
                
            </Form>
        </MainLayout>
    );
}