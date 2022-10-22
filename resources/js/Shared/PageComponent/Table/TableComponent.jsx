import Icon from "@/Shared/Icon";
import { FieldUtil } from "@/Shared/Util/Field_util";
import { useForm } from "@inertiajs/inertia-react";
import { DeleteButton, GoToButton } from "../Button/DeleteButton";
import InputField from "../Field/InputField";
import ValueField from "../Field/ValueField";

const columnModifier = (va) => {
    if(typeof va === 'string'){
        let fields = FieldUtil.turnStringToArrayOfField(va);
        FieldUtil.Rules.processFields(fields);
        return fields;
    }
    return va;
}

const TableComponent = ({column, data, row_link, delete_item, children, className, }) => {
    column = columnModifier(column);

    return <table className={'table-border-compact w-full '+className}>
            <thead>
                <tr>
                    {column.map((t,i) => <th key={i}>{t.label}</th>)}
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {data.map((d,keyId) => {
                    return <tr key={keyId}>
                        {column.map((f,keyf) => {
                            return <td key={keyf}>
                                <ValueField nowrapper='true' field={{...f,value:d[f.entityname]}}></ValueField>
                            </td>
                        })}
                        <td className="text-right">
                            {delete_item && <DeleteButton onClick={e => delete_item(d.id)} />}
                            {row_link &&  <GoToButton href={row_link.replace('{id}',d['id'])} />}
                        </td>
                    </tr>
                })}
            </tbody>
            {children}
        </table>
    }


const TableWithInlineForm = ({column, data : table_data, className, create_url, delete_url, row_link}) => {
    let columns = columnModifier(column);

    const { data, setData, post, processing, errors, delete : destroy } = useForm(columns.reduce((obj,field) => (obj[field.entityname] = '',obj),{})); 
   
    function submit(e) {
        e.preventDefault();
        post(create_url,{
                preserveScroll: true,
            });
    }
    
    function delete_item(id){
        destroy(delete_url+'/'+id,
            {
                preserveScroll: true,
            }
        );
    }

    return <>
        <form onSubmit={submit}>
            <TableComponent 
                column={column} 
                data={table_data} 
                className={className} 
                row_link={row_link}
                delete_item={delete_item}
                >
                <tfoot>
                    <tr className='table-inline-form'>
                        {columns.map((Field,keyId) => {
                            return <td key={keyId}>
                                <InputField 
                                    Field={Field} 
                                    key={keyId}
                                    errors={errors}
                                    data={data}
                                    setData={setData}   
                                    nowrapper='true' 
                                ></InputField>
                            </td>
                        })}
                        <td>
                            <button type="submit" className='post-form' disabled={processing}>Save</button>
                        </td>
                    </tr>
                </tfoot>
            </TableComponent>
        </form>
    </>
}

export {TableComponent, TableWithInlineForm}