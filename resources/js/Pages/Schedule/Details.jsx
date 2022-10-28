import React, { useEffect, useState } from 'react';
import MainLayout from '@/Layouts/MainLayout';
import CalenderInput from '@/Shared/PageComponent/Field/InputField/CalenderInput';
import Component from '@/Shared/PageComponent/Form/Component';
import { LoadingButton } from '@/Shared/PageComponent/Button/Buttons';
import { useForm } from '@inertiajs/inertia-react';
import { FormSchema } from '@/Shared/Util/Form_util';
import InputField from '@/Shared/PageComponent/Field/InputField';

const _dn = {
    day (date) {
        return date.toLocaleDateString(locale.code, { weekday: 'long' }); 
    },
    date (date) {
        return date.toLocaleDateString(locale.code, locale.dateFormat); 
    },
    month (date) {
        return date.toLocaleDateString(locale.code, { month: 'short' }); 
    },
    long_month (date) {
        return date.toLocaleDateString(locale.code, { month: 'long' }); 
    },
    remove_second (str) {
        return str.substring(0,5);
    }
}

const ScheduleItemTable = ({data}) => {
    return <>
            <table className={'table-border-compact w-full '}>
                <thead>
                    <tr>
                        <th style={{width:'30px'}}></th>
                        <th>Tanggal</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((d,keyId) => {
                        return <tr key={keyId}>
                            <td>{keyId+1}</td>
                            <td>{_dn.day(d)}, {_dn.date(d)}</td>
                            <td>{d.session_start_time}</td>
                            <td>{d.session_end_time}</td>
                        </tr>
                    })}
                </tbody>
            </table>
        </>;
}

const ScheduleParentForm = ({fields, data, setData, errors}) => {
    return <>
        <div className="flex flex-wrap -mb-8 -mr-6">
            {fields.map((Field, keyId) => {
                return <InputField 
                        Field={Field} 
                        key={keyId}
                        errors={errors}
                        data={data}
                        setData={setData}    
                    ></InputField>
            })}
        </div>
    </>
}
export default (props) => {
    
    const ScheduleItems = props.schedule.items.map(i => {
        const d = new Date(i.session_date);
        d.session_start_time = _dn.remove_second(i.session_start_time);
        d.session_end_time = _dn.remove_second(i.session_end_time);
        return d;
    }).sort((d1,d2) => d1-d2);
    
    const [SelectedDateList, setSelectedDateList] = useState(ScheduleItems);
    const [startTime, setStartTime] = useState('14:00');
    const [endTime, setEndTime] = useState('15:00');

    const onSelectDate = (date) => {
        date.session_start_time = startTime;
        date.session_end_time = endTime;
        return date;
    }
    
    const Form = new FormSchema(props.form_schema);
    const method = Form.edit_form ? {_method: 'PUT'} : null;
    const UseFormObject = {...Form.getVariableForUseForm(), ...method};
    const { data, setData, errors, post, processing, transform } = useForm(UseFormObject);

    transform((data) => {
        return data;
    })

    function handleSubmit(e) {
        e.preventDefault();
        post(Form.submit_url);
    }
    
    return (
        <MainLayout
            {...props}
        >   
            <div className="w-full">
                <form onSubmit={handleSubmit}>
                    <Component
                        header={
                            <h2 className="font-semibold text-xl text-gray-800 leading-tight">Schedule Form</h2>
                        }
                        className={'create-form no-padding'}
                    >
                        <div className='grow p-6'>
                            <ScheduleParentForm fields={Form.fields} {...{data, setData, errors}}/>
                            <fieldset className='shadow-lg bg-slate-200 '>
                                <legend>Schedule Session List</legend>
                                <div className='p-6'>
                                    <div className='flex'>
                                        <div className='flex-none'>
                                            <CalenderInput
                                                SelectedDateList={SelectedDateList}
                                                setSelectedDateList={setSelectedDateList}
                                                onSelectDate={onSelectDate}
                                            />
                                        </div>
                                        <div className='grow'>
                                            <div className='pl-6'>
                                                <div className='mt-6'>
                                                    <table className='w-full mb-4'>
                                                        <tbody>
                                                            <tr>
                                                                <td className='text-right'>
                                                                    <div className='p-2'>Apply same session time</div>
                                                                </td>
                                                                <td>
                                                                    <div className='relative'>
                                                                        <input className='anchor-hover-placeholder input-field form-input narrow' type='time' value={startTime} onChange={e => setStartTime(e.target.value)} />
                                                                        <div className='hover-placeholder'>Jam Mulai</div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div className='relative'>
                                                                        <input className='anchor-hover-placeholder input-field form-input narrow' type='time' value={endTime} onChange={e => setEndTime(e.target.value)} />
                                                                        <div className='hover-placeholder'>Jam Selesai</div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div className='bg-white'>
                                                    <ScheduleItemTable 
                                                        columns={props.form_schema.item_form.fields}
                                                        data={SelectedDateList}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div className="w-full flex items-center px-6 py-4 bg-gray-100 border-t border-gray-200">
                            <LoadingButton
                                loading={processing}
                                type="submit"
                                className="ml-auto btn-indigo"
                            >
                                Save
                            </LoadingButton>
                        </div>
                    </Component>
                </form>
            </div>
        </MainLayout>
    );
}

/**
 * 
 * <Form
        {...props.form_schema}
    >
    </Form>
    
 * 
 * 
 * 
 * 
            <TableWithInlineForm
                column={props.form_schema.item_form.fields}
                data={props.schedule.items}
                create_url={'item'}
                delete_url={'item'}
            >
            </TableWithInlineForm>
 */
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

                    /** 
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
} */