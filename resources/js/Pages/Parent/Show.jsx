import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import StudentDetails from '@/Shared/PageComponent/StudentDetails';
import Form from '@/Shared/PageComponent/Form/Form';

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
            
            <div>
                <fieldset className='shadow-lg'>
                    <legend>Student / Child information</legend>
                    <div className='p-6'>
                        {
                            props.students.map((student, keyid)=>{
                                return <StudentDetails key={keyid} student={student}></StudentDetails>
                            })
                        }
                    </div>
                </fieldset>
            </div>
            
        </MainLayout>
    );
}