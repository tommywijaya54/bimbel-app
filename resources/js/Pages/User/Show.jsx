import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';
import UnitMapField from '@/Shared/DisplayPageComponent/Field/UnitMapField';
import DetailsSummaryComponent from '@/Shared/DisplayPageComponent/Element/DetailsSummaryComponent';
import DisplayForm from '@/Shared/DisplayPageComponent/Form/DisplayForm';
import { FieldUtil } from '@/Shared/DisplayPageComponent/Field/util_field';

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
                                <div className='flex flex-wrap w-full'>
                                    <DisplayForm 
                                        fields={
                                            FieldUtil.createFields_setData(
                                                'nik,,name,email,phone,,address,note,join_date,exit_date,_,emergency_name,emergency_phone,branch_id',
                                                props.user.details.employee)
                                        }></DisplayForm>
                                </div>
                        </DetailsSummaryComponent>
                    }
                    {props.user.details && props.user.details.parent && 
                        <DetailsSummaryComponent
                            header='Information of this user : their parent information'>
                                <div className='flex flex-wrap w-full'>
                                    <DisplayForm 
                                        fields={
                                            FieldUtil.createFields_setData(
                                                'nik,blacklist,name,email,phone,birth_date,address,note,emergency_name,emergency_phone,bank_account_name,virtual_account_name,',
                                                props.user.details.parent)
                                        }></DisplayForm>
                                </div>
                        </DetailsSummaryComponent>
                    }
                    {props.user.details && props.user.details.student && 
                        <DetailsSummaryComponent
                            header='Their student information'>
                                <div className='flex flex-wrap w-full'>
                                    <DisplayForm 
                                        fields={
                                            FieldUtil.createFields_setData(
                                                'name,birth_date,type,grade,email,phone,address,,join_date,exit_date,health_condition,exit_reason,note',
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