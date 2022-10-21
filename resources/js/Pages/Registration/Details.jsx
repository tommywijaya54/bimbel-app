import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';
import DetailsSummaryComponent from '@/Shared/PageComponent/Element/DetailsSummaryComponent';
import { TableWithInlineForm } from '@/Shared/PageComponent/Table/TableComponent';

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
                            header='Salaries information'>
                                <TableWithInlineForm
                                    column='start_date:Start date,amount,note'
                                    data={props.items}
                                    
                                    create_url={props.form_schema.id+'/item'}
                                    delete_url={props.form_schema.id+'/item'}
                                >
                                </TableWithInlineForm>
                    </DetailsSummaryComponent>
                </div>
            </fieldset>

        </MainLayout>
    );
}