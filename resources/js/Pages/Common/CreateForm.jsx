import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';

export default function CreateForm(props) {
    return (
        <MainLayout
            {...props}
        >
            <Form
                {...props.form_schema}
            >
            </Form>
        </MainLayout>
    );
}