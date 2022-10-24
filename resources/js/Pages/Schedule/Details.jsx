import React, { useEffect, useState } from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';
import { useForm } from '@inertiajs/inertia-react';
import InputField from '@/Shared/PageComponent/Field/InputField';
import ValueField from '@/Shared/PageComponent/Field/ValueField';
import { UpdateButton, DeleteButton } from '@/Shared/PageComponent/Button/Buttons';
import { TableWithInlineForm } from '@/Shared/PageComponent/Table/TableComponent';
import { Inertia } from '@inertiajs/inertia';

const TableRowEditable = ({columns, data:row_data, setFieldData, onUpdate, onDelete, processing}) => {
    // const fields = columns.filter(f => !f.extrafield);
    // fields.forEach(f => f.value = row_data[f.entityname]);
    
    let dataSet = columns.filter(f => !f.extrafield).reduce((obj,field) => (obj[field.entityname] = row_data[field.entityname],obj),{});
    
    const {id : item_id} = row_data;
    
    let {errors} = useForm(dataSet); 

    const setData = (entityname,value) => {
        setFieldData(item_id, entityname, value)
    }
    
    useEffect(() => {
        Object.keys(data).forEach(key => setData(key,row_data[key]));
    },[item_id]) 


    return <tr>
        {
            columns.map((field, keyId) => {
                return <td key={keyId}> 
                {
                    field.extrafield ? 
                    <ValueField Field={{...field, value:row_data[field.entityname]}} nowrapper='true' />:
                    <InputField Field={field} 
                        data={row_data}
                        setData={setData}
                        errors={errors} 
                        nowrapper='true' 
                    />
                }
                </td>
            })
        }
        <td>
            {item_id} 
            <UpdateButton onClick={e => onUpdate(item_id)}></UpdateButton>
            <DeleteButton onClick={e => onDelete(item_id)}></DeleteButton>
        </td>
    </tr>
}

const TableEditable = ({column, data:table_data, schedule_id, ...props}) => {
    let dataSet = {}

    table_data.forEach(d => {
        dataSet[d.id] = d;
    });

    const  {data, setData, post, put, delete : destroy , processing, errors} = useForm(dataSet); 
    
    const setFieldData = (item_id, entityname, value) => {
        data[item_id][entityname] = value;
        setData(data);
    }

    const updateItem = (item_id) => {
        Inertia.put(route('delete.schedule.item',{id:schedule_id,item_id}),
            data[item_id],
            {preserveScroll: true})
    }

    const deleteItem = (item_id) => {
        destroy(
            route('delete.schedule.item',{
                id:schedule_id,
                item_id}),
            {preserveScroll: true}
        );
    }

    return <>
        <form>
            <table className={'table-border-compact w-full '}>
                <thead>
                    <tr>
                        {column.map((t,i) => <th key={i}>{t.label}</th>)}
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {table_data.map((row_data,keyId) => {
                        return <TableRowEditable 
                            key={keyId} 
                            
                            columns={column} 
                            data={row_data}

                            setFieldData={setFieldData}
                            onUpdate={updateItem}
                            onDelete={deleteItem}

                            processing={processing}
                        {...props}></TableRowEditable>
                    })}
                </tbody>
            </table>
        </form>
    </>;
}


export default (props) => {
    const dayFormat = {weekday: 'long'};
    const timeFormat =  {hour: '2-digit', minute: '2-digit'};

    props.schedule.items.forEach(i => {
        i.day = i.id +' : '+(new Date(i.session_date)).toLocaleDateString(locale.code,dayFormat);
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
                    <TableEditable
                        column={props.form_schema.item_form.fields}

                        schedule_id={props.form_schema.item.id}
                        data={props.schedule.items}
                    ></TableEditable>
    
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

/**
 * 
 */