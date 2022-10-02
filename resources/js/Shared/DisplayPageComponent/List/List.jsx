import Icon from "@/Shared/Icon";
import ListItemField from "../Field/ListItemField";

export default (listprops) => {
    const {fields, data, item_url} = listprops;

    const PrimaryId = "id";
    const TableTD = fields; // Header
    const TableData = data;

    return <>
    <div className="display-list overflow-x-auto bg-white rounded shadow">
        <table className="w-full table-padding-row"> 
                    <thead className="text-left">
                        <tr>
                            {
                                TableTD.map((el, keyID) => {
                                    return <th key={keyID}>{el.label}</th>
                                })
                            }
                        </tr>
                    </thead>
                    <tbody>
                        {
                            TableData.map((data,i) => {
                                return <tr 
                                    key={i}
                                    className="hover:bg-gray-100 focus-within:bg-gray-100"
                                    >
                                    {
                                        TableTD.map((el, keyID) => {
                                            return <td key={keyID}>
                                                <ListItemField field={el} data={data[el.entityname]} rawdata={data}></ListItemField>
                                            </td>
                                        })
                                    }
                                    {item_url && 
                                        <td>
                                            <a 
                                                href={item_url.replace('{id}',data[PrimaryId])} 
                                                className="link goto link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                                    <Icon
                                                        name="cheveron-right"
                                                        className="block w-6 h-6 text-gray-400 fill-current"
                                                    />
                                            </a>
                                            
                                            
                                        </td>
                                    }
                                </tr>
                            })
                        }
                    </tbody>
            </table>
        </div>
    </>
}