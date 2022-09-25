import { InertiaLink } from "@inertiajs/inertia-react"
import Icon from "./Icon"
import SimpleLink from "./SimpleLink";

export default ({listprops}) => {
    const PrimaryId = listprops.PrimaryId || "id";

    const Elements = (listprops.view.split(",")).map((header) => {
        return header.toDisplayElement();
        
        /*
        return {
            entityname : header.split(":")[0],
            label : header.split(":")[1] || (header.split(":")[0]).cap()
        }
        */
    });

    const Data = listprops.data;
    const GotoHref = listprops.goto || null;

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
                                    {GotoHref && 
                                        <td>
                                            <SimpleLink 
                                                type='goto'
                                                id={data[PrimaryId]}
                                                href={GotoHref}
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