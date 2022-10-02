import DisplayField from "@/Pages/Common/Shared/Field/DisplayField";
import { FormObject, DisplayElement as DisplayEl } from "@/util";
import { InertiaLink } from "@inertiajs/inertia-react"
import DisplayElement from "./DisplayElement";
import Icon from "./Icon"
import SimpleLink from "./SimpleLink";

export default ({listprops}) => {
    const PrimaryId = listprops.PrimaryId || "id";
    const TableTD = (listprops.fields.split(",")).map((header) => {
        return new DisplayEl(header);
    });
    const TableData = listprops.data;
    const item_url = listprops.item_url || null;

    return <>
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
                                                <DisplayElement data={data} el={el}></DisplayElement>
                                                
                                            </td>
                                        })
                                    }
                                    {item_url && 
                                        <td>
                                            <SimpleLink 
                                                type='goto'
                                                id={data[PrimaryId]}
                                                href={item_url}
                                            >
                                            </SimpleLink>
                                        </td>
                                    }
                                </tr>
                            })
                        }
                    </tbody>
            </table>
    </>
}