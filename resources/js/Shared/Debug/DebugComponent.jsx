import { usePage } from '@inertiajs/inertia-react';
import ArrayList from "./ArrayList";

export default () => {
    const data = usePage().props;
    const user =  data.auth;
    const permissions = user.permissions;
    const roles = user.roles;

    function omit(obj, ...props) {
        const result = { ...obj };
        props.forEach(function(prop) {
            delete result[prop];
        });
        return result;
    }

    const debugOb = omit(data,'auth','ziggy','errors','flash');

    const DataParser = () => {
        let parsedOb = []; 

        for(const propKey in debugOb){
            parsedOb.push({
                id:propKey,
                value:debugOb[propKey]
            })
        }

        return <>{
            parsedOb.map((ob,i) => {
                return <div className='parsed-object' key={i}>
                    {ob.id} : {JSON.stringify(ob.value)}
                </div>
            })
        }</>
    }

    return <>
        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-indigo-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="debug p-6">
                        <DataParser></DataParser>
                        <ArrayList list={permissions}></ArrayList>
                        <ArrayList list={roles}></ArrayList>
                    </div>
                </div>
            </div>
        </div>
    </>;
}