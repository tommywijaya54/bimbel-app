import React, { useEffect, useState } from 'react';
import MainLayout from '@/Layouts/MainLayout';
import CalenderInput from '@/Shared/PageComponent/Field/InputField/CalenderInput';
import Component from '@/Shared/PageComponent/Form/Component';
import { DeleteButton, LoadingButton } from '@/Shared/PageComponent/Button/Buttons';
import { useForm } from '@inertiajs/inertia-react';
import { FormSchema } from '@/Shared/Util/Form_util';
import InputField from '@/Shared/PageComponent/Field/InputField';

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
                            <td>{dn.day(d)}, {dn.date(d)}</td>
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
    let ScheduleItems = props.schedule ? 
    props.schedule.items.map(i => {
        const d = new Date(i.session_date);
        d.id = i.id;
        d.session_date = new Date(i.session_date);
        d.session_start_time = dn.remove_second(i.session_start_time);
        d.session_end_time = dn.remove_second(i.session_end_time);
        return d;
    }).sort((d1,d2) => d1-d2) : [];
    
    const [SelectedDateList, setSelectedDateList] = useState(ScheduleItems);
    const [startTime, setStartTime] = useState('14:00');
    const [endTime, setEndTime] = useState('15:00');
    
    const calenderFn = {
        formatDataForServer(items){
            const it =  items.map(i => {
                const date = new Date(i);
                return {
                    id:(i.id || ''),
                    session_date:dn.setDateForServer(date),
                    session_start_time:dn.setDateForServer(dn.setTime(date,i.session_start_time)),
                    session_end_time:dn.setDateForServer(dn.setTime(date,i.session_end_time))
                };
            });
            // console.log(it);
            return it;
        },
        onSelectDate(date){
            date.id = date.id
            date.session_date = date;
            date.session_start_time = startTime;
            date.session_end_time = endTime;
            
            return date;
        }
    }

    calenderFn.setItems = (name,items) => {
        setData(name,calenderFn.formatDataForServer(items));
    }
    


    const Form = new FormSchema(props.form_schema);
    const method = Form.edit_form ? {_method: 'PUT'} : null;
    const UseFormObject = {...Form.getVariableForUseForm(), ...method, items: calenderFn.formatDataForServer(SelectedDateList)};
    const { data, setData, errors, post, put, delete : destroy, processing} = useForm(UseFormObject);
    
    const scheduleFn = {
        delete(){
            destroy(route('delete.schedule',{
                id:props.schedule.id
            }));
        },
        submit(e){
            e.preventDefault();
            if(props.schedule){
                put(route('update.schedule',{
                    id:props.schedule.id
                }));
            }else{
                post(Form.submit_url);
            }
        }
    }
    
    return (
        <MainLayout
            {...props}
        >   
            <div className="w-full">
                <form onSubmit={scheduleFn.submit}>
                    <Component
                        header={
                            <h2 className="font-semibold text-xl text-gray-800 leading-tight">Schedule Form</h2>
                        }
                        className={'create-form no-padding'}
                    >
                        <div className='grow p-6'>
                            <ScheduleParentForm fields={Form.fields} {...{data, setData, errors}}/>
                            <fieldset className='shadow-lg bg-slate-200 mt-6'>
                                <legend>Schedule Session List</legend>
                                {errors.items && <div className='note error br-1'>Please select calender and fill the start time and end time</div>}
                                <div className='p-6'>
                                    <div className='flex'>
                                        <div className='flex-none'>
                                            <CalenderInput
                                                SelectedDateList={SelectedDateList}
                                                setSelectedDateList={setSelectedDateList}
                                                onSelectDate={calenderFn.onSelectDate}
                                                setData={calenderFn.setItems}
                                                name='items'
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
                            {props.schedule && <DeleteButton onClick={scheduleFn.delete}>Delete</DeleteButton>}

                            <LoadingButton
                                loading={processing}
                                type="submit"
                                className="ml-auto btn-indigo"
                            >
                                {props.schedule ? 'Update Schedule' : 'Create Schedule'}
                            </LoadingButton>
                        </div>
                    </Component>
                </form>
            </div>
        </MainLayout>
    );
}