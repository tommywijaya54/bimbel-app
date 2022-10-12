import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Component from '@/Shared/DisplayPageComponent/Form/Component';
import ValueField from '@/Shared/DisplayPageComponent/Field/ValueField';

const Table = ({header,data, className}) => {
    const th = header.split(',').map(h => {
        const heading = h.split(':');
        return {
            entityname:heading[0],
            label:(heading[1]||heading[0].cap())
        }
    });

    return <>
        <table className={'table-border-compact w-full '+className}>
            <thead>
                <tr>
                    {th.map((t,i) => <th key={i}>{t.label}</th>)}
                </tr>
            </thead>
            <tbody>
                    {data.map((d,i) => {
                        return <tr key={i}>
                            {th.map((t,y) => <td key={y}>
                                <ValueField field={t} data={data[i]}></ValueField>
                            </td>)}
                        </tr>
                    })}
            </tbody>
        </table>
    </>
}
// 

const MiniComponent = ({header,children}) => {
    return <>
        <div className='w-full mb-8'>
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
                    <Table
                        header="date:Tanggal,expense_type:Type,description:Description,amount:Nominal"
                        data={props.branch.expenses}
                    ></Table>
                </MiniComponent>

                <MiniComponent 
                    header="Rental">
                    <Table
                        header="start_date:Kontrak Mulai,end_date:Kontrak Habis,owner_name:Pemilik,owner_phone:Phone"
                        data={props.branch.rentals}
                    ></Table>
                </MiniComponent>

                <MiniComponent 
                    header="Assets">
                    <Table
                        header="item_name:Description,qty:Quantity,cost:Cost"
                        data={props.branch.assets}
                        className="w-1/2"
                    ></Table>
                </MiniComponent>
            </Component>
        </MainLayout>
    );
}