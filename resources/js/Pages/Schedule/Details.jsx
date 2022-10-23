import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';
import DetailsSummaryComponent from '@/Shared/PageComponent/Element/DetailsSummaryComponent';
import { TableWithInlineForm } from '@/Shared/PageComponent/Table/TableComponent';

export default (props) => {
    const dayFormat = {weekday: 'long'};
    const timeFormat =  {hour: '2-digit', minute: '2-digit'};

    props.schedule.items.forEach(i => {
        i.day = (new Date(i.session_date)).toLocaleDateString(locale.code,dayFormat);

        // console.log(new Date(i.date+' '+i.start_at));
        // console.log((new Date(i.date+' '+i.start_at)).toLocaleDateString(locale.code,timeFormat));

        // i.start_at = (new Date(i.date+' '+i.start_at)).toLocaleDateString(locale.code,timeFormat);
        // i.end_at = (new Date(i.date+' '+i.end_at)).toLocaleDateString(locale.code,timeFormat);
        
        // console.log(i.end_at);
    });

    return (
        <MainLayout
            {...props}
        >
            <Form
                {...props.form_schema}
            >
            </Form>
            <fieldset className='shadow-lg'>
                <legend>Schedule List</legend>
                <div className='p-6'>
                    <TableWithInlineForm
                        column={props.form_schema.item_form.fields}
                        data={props.schedule.items}
                        create_url={'item'}
                        delete_url={'item'}
                    >
                    </TableWithInlineForm>
                </div>
            </fieldset>
        </MainLayout>
    );
}