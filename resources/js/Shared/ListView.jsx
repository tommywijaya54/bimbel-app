import { InertiaLink } from "@inertiajs/inertia-react"
import Icon from "./Icon"

export default ({listprops}) => {
    const PrimaryId = listprops.PrimaryId || "id";
    const Elements = (listprops.view.split(",")).map((header) => {
        return {
            entityname : header.split(":")[0],
            label : header.split(":")[1] || (header.split(":")[0]).cap()
        }
    })
    const Data = listprops.data;
    const RouteTo = listprops.route || null;

    return <>
        <table className="w-full table-padding-row"> 
                    <thead className="text-left">
                        <tr>
                            {
                                Elements.map((el, keyID) => {
                                    return <th key={keyID}>{el.label}</th>
                                })
                            }
                        </tr>
                    </thead>
                    <tbody>
                        {
                            Data.map((data,i) => {
                                return <tr 
                                    key={i}
                                    className="hover:bg-gray-100 focus-within:bg-gray-100"
                                    >
                                    
                                    {
                                        Elements.map((el, keyID) => {
                                            return <td key={keyID}>{data[el.entityname]}</td>
                                        })
                                    }
                                    {RouteTo && 
                                        <td>
                                            <InertiaLink
                                                tabIndex="-1"
                                                href={route(RouteTo, data[PrimaryId])}
                                                className="flex items-center px-4 focus:outline-none"
                                            >
                                            <Icon
                                                name="cheveron-right"
                                                className="block w-6 h-6 text-gray-400 fill-current"
                                            />
                                            </InertiaLink>
                                        </td>
                                    }
                                </tr>
                            })
                        }
                    </tbody>
            </table>
    </>
}