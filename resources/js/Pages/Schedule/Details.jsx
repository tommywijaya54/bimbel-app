import React, { useEffect, useState } from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/PageComponent/Form/Form';
import { useForm } from '@inertiajs/inertia-react';
import InputField from '@/Shared/PageComponent/Field/InputField';
import ValueField from '@/Shared/PageComponent/Field/ValueField';
import { UpdateButton, DeleteButton } from '@/Shared/PageComponent/Button/Buttons';
import { TableWithInlineForm } from '@/Shared/PageComponent/Table/TableComponent';
import { Inertia } from '@inertiajs/inertia';
import CalenderInput from '@/Shared/PageComponent/Field/InputField/CalenderInput';
import UnitMapField from '@/Shared/PageComponent/Field/UnitMapField';

const TableRowEditable = ({columns, data:row_data, setFieldData, onUpdate, onDelete, processing}) => {
    
    let dataSet = columns.filter(f => !f.extrafield).reduce((obj,field) => (obj[field.entityname] = row_data[field.entityname],obj),{});
    let {errors} = useForm(dataSet);

    const {id : item_id} = row_data;

    const setData = (entityname,value) => {
        setFieldData(item_id, entityname, value);
    } 

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
    const {data, setData, post, put, delete : destroy , processing, errors} = useForm(table_data); 
    
    const setFieldData = (item_id, entityname, value) => {
        setData(data.find(i => i.id == item_id)[entityname] = value);
    }

    const updateItem = (item_id) => {
        Inertia.put(route('delete.schedule.item',{id:schedule_id,item_id}),
            data.find(i => i.id == item_id),
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
                    {data.map((row_data,keyId) => {
                        return <TableRowEditable 
                            key={keyId} 
                            
                            columns={column} 
                            data={row_data}

                            setFieldData={setFieldData}
                            onUpdate={updateItem}
                            onDelete={deleteItem}

                            processing={processing}

                            {...props}
                        ></TableRowEditable>
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

    const [SelectedDateList, setSelectedDateList] = useState([]);
    
    return (
        <MainLayout
            {...props}
        >   
            <fieldset className='shadow-lg mb-12'>
                <legend>Schedule List</legend>
                <div className='p-6'>
                     <div className='bg-slate-300'>
                        <CalenderInput
                            SelectedDateList={SelectedDateList}
                            setSelectedDateList={setSelectedDateList}
                        />
                    </div>
                </div>
                <div className='p-6 flex'>
                    <div className='flex-none w-80'>
                        <UnitMapField map={SelectedDateList} />
                    </div>
                    <div className='grow'>Right Pane</div>
                </div>
            </fieldset>

            <Form
                {...props.form_schema}
            >
            </Form>
        </MainLayout>
    );
}

/**
 * 
 * <TableEditable
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
 */