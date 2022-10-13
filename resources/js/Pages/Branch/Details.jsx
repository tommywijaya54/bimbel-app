import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Component from '@/Shared/PageComponent/Form/Component';
import { FieldUtil } from '@/Shared/Util/Field_util';
import ValueField from '@/Shared/PageComponent/Field/ValueField';
import { useForm } from '@inertiajs/inertia-react';
import { Rule, RuleSet } from '@/Shared/Util/Rule_util';
import Icon from '@/Shared/Icon';
import Form from '@/Shared/PageComponent/Form/Form';
import DetailsSummaryComponent from '@/Shared/PageComponent/Element/DetailsSummaryComponent';

let FieldRules = new RuleSet();
FieldRules.add(new Rule('entityname','includes',['amount','qty','cost'],(field) => field.input_type = 'number'));
FieldRules.add(new Rule('entityname','includes',['date'],(field) => field.input_type = 'date'));

const fieldtypeAdder = (field) => {
    if(!FieldRules.check(field)){
        field.input_type = 'text';
    }
}

const TableList = ({header, table_data, className, post_to}) => {
    let th = FieldUtil.turnStringToArrayOfField(header);
    th.forEach(f => fieldtypeAdder(f));

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
        destroy(post_to+'/'+id,
            {
                preserveScroll: true,
            }
        );
    }
    
    return <>
        <form onSubmit={submit}>
            <table className={'table-border-compact w-full '+className}>
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
                                <td>
                                    <button type="button" className='delete-button' onClick={e => delete_item(d.id)}>
                                        <Icon name="trash" className="block w-5 h-5 text-sky-500 fill-current"></Icon>
                                    </button>
                                </td>
                            </tr>
                        })}
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
                </tbody>
            </table>
        </form>
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
                        className="w-full"
                    ></TableList>
                </MiniComponent>

                <MiniComponent 
                    header="Rental">
                    <TableList
                        header="start_date:Kontrak Mulai,end_date:Kontrak Habis,owner_name:Pemilik,owner_phone:Phone,note"
                        table_data={props.branch.rentals}
                        post_to='rental'
                        className="w-full"
                    ></TableList>
                </MiniComponent>

                <MiniComponent 
                    header="Assets">
                    <TableList
                        header="purchase_date:Tanggal Beli,item_name:Description,qty:Quantity,cost:Cost,note"
                        table_data={props.branch.assets}
                        post_to='asset'
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