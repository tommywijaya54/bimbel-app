import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import StudentDetails from '@/Shared/PageComponent/StudentDetails';
import Form from '@/Shared/DisplayPageComponent/Form/Form';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <h1 className='attention'>Parent Show</h1>
            
            <Form
                {...props.form_schema}
            >
            </Form>
            
            {
                props.students.map((student, keyid)=>{
                    return <StudentDetails student={student}></StudentDetails>
                })
            }
            
        </MainLayout>
    );
}