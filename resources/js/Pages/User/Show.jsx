import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';
import UnitMapField from '@/Shared/PageComponent/Field/UnitMapField';
import DetailsSummaryComponent from '@/Shared/PageComponent/Element/DetailsSummaryComponent';
import DisplayForm from '@/Shared/PageComponent/Form/DisplayForm';
import { FieldUtil } from '@/Shared/Util/Field_util';

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
                <legend>Extra Information</legend>
                <div className='p-6'>
                    <DetailsSummaryComponent
                        header='Permissions'>
                        <UnitMapField map={props.user.permission}></UnitMapField>
                    </DetailsSummaryComponent>

                    {props.user.details && props.user.details.employee && 
                        <DetailsSummaryComponent
                            header='Employment Details'>
                                <div className='flex flex-wrap w-full display-form'>
                                    <DisplayForm 
                                        fields={
                                            FieldUtil.createFields_setData(
                                                props.employee_form_fields,
                                                props.user.details.employee)
                                        }></DisplayForm>
                                </div>
                        </DetailsSummaryComponent>
                    }

                    {props.user.details && props.user.details.parent && 
                        <DetailsSummaryComponent
                            header='Information of this user : their parent information'>
                                <div className='flex flex-wrap w-full display-form'>
                                    <DisplayForm 
                                        fields={
                                            FieldUtil.createFields_setData(
                                                props.parent_form_fields,
                                                props.user.details.parent)
                                        }></DisplayForm>
                                </div>
                        </DetailsSummaryComponent>
                    }
                    
                    {props.user.details && props.user.details.student && 
                        <DetailsSummaryComponent
                            header='Their student information'>
                                <div className='flex flex-wrap w-full display-form'>
                                    <DisplayForm 
                                        fields={
                                            FieldUtil.createFields_setData(
                                                props.student_form_fields,
                                                props.user.details.student)
                                        }></DisplayForm>
                                </div>
                        </DetailsSummaryComponent>
                    }
                </div>
            </fieldset>
        </MainLayout>
    );
}