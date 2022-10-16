import Icon from "@/Shared/Icon";
import { FieldUtil } from "@/Shared/Util/Field_util";
import { useForm } from "@inertiajs/inertia-react";
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
                                <ValueField field={{...f,value:d[f.entityname]}}></ValueField>
                            </td>
                        })}
                        <td className="text-right">
                            {delete_item && 
                            <button type="button" className='delete-button' onClick={e => delete_item(d.id)}>
                                <Icon name="trash" className="block w-5 h-5 text-sky-500 fill-current"></Icon>
                            </button>}
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
                        {columns.map((f,ki) => {
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
            </TableComponent>
        </form>
    </>
}

export {TableComponent, TableWithInlineForm}