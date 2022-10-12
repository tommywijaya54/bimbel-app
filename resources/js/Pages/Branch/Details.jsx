import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Component from '@/Shared/DisplayPageComponent/Form/Component';
import { FieldUtil } from '@/Shared/DisplayPageComponent/Field/util_field';
import ValueField from '@/Shared/DisplayPageComponent/Field/ValueField';
import { useForm } from '@inertiajs/inertia-react';

const TableList = ({header, data, className, post_to}) => {
    const th = FieldUtil.turnStringToArrayOfField(header);
    
    const inline_form_obj = {};
    th.forEach(f => inline_form_obj[f.entityname] = '');

    const { data, setData, post, processing, errors } = useForm(inline_form_obj);   
    
    function submit(e) {
        e.preventDefault();
        post(post_to);
    }
    

    return <>
        <table className={'table-border-compact w-full '+className}>
            <thead>
                <tr>
                    {th.map((t,i) => <th key={i}>{t.label}</th>)}
                </tr>
            </thead>
            <tbody>
                    {data.map((d,keyId) => {
                        return <tr key={keyId}>
                            {th.map((f,keyf) => {
                                return <td key={keyf}>
                                    <ValueField field={{...f,value:d[f.entityname]}}></ValueField>
                                </td>
                            })}
                        </tr>
                    })}
                    {inline_form && <form onSubmit={submit}>
                        <tr>
                        {th.map((f,ki) => {
                            return <td>
                                <input type="text" value={data[f.entityname]} onChange={e => setData(f.entityname, e.target.value)} />
                                    {errors[f.entityname] && <div>{errors[f.entityname]}</div>}
                            </td>
                        })}
                        <td>
                            <button type="submit" disabled={processing}>Login</button>
                        </td>
                        </tr>
                    </form>}
            </tbody>
        </table>
    </>
}

const MiniComponent = ({header,children}) => {
    return <>
        <div className='w-full mb-12'>
            <h2 className="font-semibold text-lg text-gray-800 leading-tight mb-2">{header}</h2>
            {children}
        </div>
    </>
}


export default function Show(props) {
    console.log(props.branch);

    return (
        <MainLayout
            {...props}
        >
            <Component
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        {props.branch.name}
                        <span className="info">
                            {props.branch.address}
                        </span>
                    </h2>
                }
            > 
                <MiniComponent 
                    header="Expenses">
                    <TableList
                        header="date:Tanggal,expense_type:Type,description:Description,amount:Nominal"
                        data={props.branch.expenses}
                        post_to={'branch/'+props.branch.id+'/addexpense'}
                    ></TableList>
                </MiniComponent>

                <MiniComponent 
                    header="Rental">
                    <TableList
                        header="start_date:Kontrak Mulai,end_date:Kontrak Habis,owner_name:Pemilik,owner_phone:Phone"
                        data={props.branch.rentals}
                        post_to={'branch/'+props.branch.id+'/addrental'}
                    ></TableList>
                </MiniComponent>

                <MiniComponent 
                    header="Assets">
                    <TableList
                        header="item_name:Description,qty:Quantity,cost:Cost"
                        data={props.branch.assets}
                        post_to={'branch/'+props.branch.id+'/addasset'}
                        className="w-1/2"
                    ></TableList>
                </MiniComponent>
            </Component>
        </MainLayout>
    );
}