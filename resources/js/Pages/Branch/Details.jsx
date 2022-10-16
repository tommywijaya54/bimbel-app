import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Component from '@/Shared/PageComponent/Form/Component';
import { FieldUtil } from '@/Shared/Util/Field_util';
import ValueField from '@/Shared/PageComponent/Field/ValueField';
import { useForm } from '@inertiajs/inertia-react';

import Icon from '@/Shared/Icon';
import Form from '@/Shared/PageComponent/Form/Form';
import DetailsSummaryComponent from '@/Shared/PageComponent/Element/DetailsSummaryComponent';

const TableList = ({header, table_data, className, post_to, delete_url, row_link, children}) => {
    let th = FieldUtil.turnStringToArrayOfField(header);
    FieldUtil.Rules.processFields(th);

    const { data, setData, post, processing, errors } = useForm(th.reduce((obj,field) => (obj[field.entityname] = '',obj),{})); 
    const {delete : destroy} = useForm();

    function submit(e) {
        e.preventDefault();
        post(post_to,
            {
                preserveScroll: true,
                // onSuccess: () => reset('password'),
            });
    }
    
    function delete_item(id){
        destroy(delete_url+'/'+id,
            {
                preserveScroll: true,
            }
        );
    }

    const TableElement = ({children, className, table_data, th, row_link}) => {
        return <table className={'table-border-compact w-full '+className}>
                <thead>
                    <tr>
                        {th.map((t,i) => <th key={i}>{t.label}</th>)}
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {table_data.map((d,keyId) => {
                        return <tr key={keyId}>
                            {th.map((f,keyf) => {
                                return <td key={keyf}>
                                    <ValueField field={{...f,value:d[f.entityname]}}></ValueField>
                                </td>
                            })}
                            <td className="text-right">
                                <button type="button" className='delete-button' onClick={e => delete_item(d.id)}>
                                    <Icon name="trash" className="block w-5 h-5 text-sky-500 fill-current"></Icon>
                                </button>
                                {row_link && 
                                    <a 
                                        href={row_link.replace('{id}',d['id'])} 
                                        className="link goto link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <Icon
                                                name="cheveron-right"
                                                className="block w-6 h-6 text-gray-400 fill-current"
                                            />
                                    </a>
                                }
                            </td>
                        </tr>
                    })}
                </tbody>
                {children}
            </table>
    }


    if(post_to){
        return <>
            <form onSubmit={submit}>
                <TableElement th={th} table_data={table_data} className={className} row_link={row_link}>
                    <tfoot>
                        <tr className='table-inline-form'>
                            {th.map((f,ki) => {
                                return <td key={ki}>
                                    <input 
                                        type={f.input_type} 
                                        value={data[f.entityname]} 
                                        onChange={e => setData(f.entityname, e.target.value)}
                                        placeholder={f.label}    
                                        />
                                    {errors[f.entityname] && <div>{errors[f.entityname]}</div>}
                                </td>
                            })}
                            <td>
                                <button type="submit" className='post-form' disabled={processing}>Save</button>
                            </td>
                        </tr>
                    </tfoot>
                </TableElement>
            </form>
        </>
    }else{
        return <TableElement th={th} table_data={table_data} className={className} row_link={row_link}>
            {children}
        </TableElement>
    }
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
                header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">
                            <a href={'/branch/'+props.branch.id}>
                                {props.branch.name}
                                <span className='info'>{props.branch.address}
                                    <Icon
                                        name='office'
                                        className="inline-block w-5 h-5 ml-6 text-white fill-current"
                                        >

                                    </Icon>
                                </span>
                            </a>
                        </h2>
                }
            > 

                <MiniComponent 
                    header="Expenses">
                    <TableList
                        header="date:Tanggal,expense_type:Type,description:Description,amount:Nominal,note"
                        table_data={props.branch.expenses}
                        post_to='expense'
                        delete_url='expense'
                        className="w-full"
                    ></TableList>
                </MiniComponent>

                <MiniComponent 
                    header="Rental">
                    <TableList
                        header="start_date:Kontrak Mulai,end_date:Kontrak Habis,owner_name:Pemilik,owner_phone:Phone,note"
                        table_data={props.branch.rentals}
                        row_link={'rental/{id}'}
                        delete_url='rental'
                        className="w-full"
                    >
                        <tfoot>
                            <tr>
                                <td colSpan='6' className='text-right'>
                                    <a href='rental/create' className='button link'>Create New Rental</a>
                                </td>
                            </tr>
                        </tfoot>
                    </TableList>
                </MiniComponent>

                <MiniComponent 
                    header="Assets">
                    <TableList
                        header="purchase_date:Tanggal Beli,item_name:Description,qty:Quantity,cost:Cost,note"
                        table_data={props.branch.assets}
                        post_to='asset'
                        delete_url='asset'
                        className="w-full"
                    ></TableList>
                </MiniComponent>
            </Component>
        </MainLayout>
    );
}

/*
<DetailsSummaryComponent
                    header="Branch information"
                    className="mb-8"
                >   
                    <Form
                        {...props.form_schema}
                    >
                    </Form>
                </DetailsSummaryComponent>
                
                */