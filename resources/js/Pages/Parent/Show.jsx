import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';
import { FieldUtil } from '@/Shared/Util/Field_util';
import DetailsSummaryComponent from '@/Shared/PageComponent/Element/DetailsSummaryComponent';
import DisplayForm from '@/Shared/PageComponent/Form/DisplayForm';
export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >   
            <Form
                {...props.form_schema}
            >
            </Form>
            
            <fieldset className='shadow-lg'>
                <legend>Their child information</legend>
                <div className='p-6'>
                    {props.students && 
                        props.students.map((student, keyid) => {
                            
                            return <DetailsSummaryComponent
                                key={keyid}
                                header={student.name}>
                                    <div className='flex flex-wrap w-full display-form'>
                                        <DisplayForm 
                                            fields={
                                                FieldUtil.createFields_setData(
                                                    props.student_form_fields,
                                                    student)
                                            }></DisplayForm>
                                    </div>
                            </DetailsSummaryComponent>
                        })
                        
                    }
                </div>
            </fieldset>
        </MainLayout>
    );
}