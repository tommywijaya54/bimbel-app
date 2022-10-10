import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <h1 className='attention'>Employeee / Show</h1>
            <Form
                {...props.form_schema}
            >
                <div className="form-component pr-6 pb-8 w-full lg:w-1/2">
                    <label className="form-label">Role:</label>
                    <div className="form-input">{props.roles.map((role,keyid) => <span key={keyid} className='unit'>{role}</span>)}</div>
                </div>
            </Form>
        </MainLayout>
    );
}