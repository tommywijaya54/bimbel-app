import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';
import DetailsSummaryComponent from '@/Shared/PageComponent/Element/DetailsSummaryComponent';
import { TableComponent, TableWithInlineForm } from '@/Shared/PageComponent/Table/TableComponent';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <Form
                {...props.form_schema}
            >
                <div className="form-component pr-6 pb-8 w-full lg:w-1/2">
                    <label className="form-label">Role:</label>
                    <div className="form-input">{props.roles.map((role,keyid) => <span key={keyid} className='unit'>{role}</span>)}</div>
                </div>
            </Form>

            <fieldset className='shadow-lg'>
                <legend>Extra Information</legend>
                <div className='p-6'>
                    <DetailsSummaryComponent
                            header='Salaries information'>
                                <TableWithInlineForm
                                    column='start_date:Start date,amount,note'
                                    data={props.salaries}
                                    
                                    create_url={props.form_schema.id+'/salary'}
                                    delete_url={props.form_schema.id+'/salary'}
                                >
                                </TableWithInlineForm>
                    </DetailsSummaryComponent>
                </div>
            </fieldset>
        </MainLayout>
    );
}