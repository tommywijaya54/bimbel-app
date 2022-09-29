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
                /*
                <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
                return <pre className="prettyprint lang-html" key={i}>
                    The lang-* class specifies the language file extensions.
                    File extensions supported by default include:
                        "bsh", "c", "cc", "cpp", "cs", "csh", "cyc", "cv", "htm", "html", "java",
                        "js", "m", "mxml", "perl", "pl", "pm", "py", "rb", "sh", "xhtml", "xml",
                        "xsl".
                    </pre>
                    */

                return <pre key={i}><code>
                    props.{ob.id} : {JSON.stringify(ob.value)}
                    </code>
                </pre>
                
                /*
                return <div className='parsed-object' key={i}>
                    {ob.id} : {JSON.stringify(ob.value)}
                </div>
                */
            })
        }</>
    }

    const AutoFill = () => {
        if(!window.tomatoDebugger){
            return ''
        }
        // find field 
        const fillTheFields = () => {
            if(window.tomatoDebugger){
                const fields = window.tomatoDebugger.form.fields;
                const setData = window.tomatoDebugger.setData;
                
                fields.forEach((field) => {
                    console.log(field.entityname);
                    window.setData(field.entityname,'hello');
                });
            }else{
                alert('Debugger not assign')
            }
        }

        return <div className='autofill absolute top-10 right-10'>
            <button className='flex items-center focus:outline-none ml-auto btn-indigo' onClick={fillTheFields}>Auto Fill data</button>
            </div>
    }

    return <>
        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-indigo-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="debug p-6">
                        <AutoFill></AutoFill>
                        <DataParser></DataParser>
                        <ArrayList list={permissions}></ArrayList>
                        <ArrayList list={roles}></ArrayList>
                    </div>
                </div>
            </div>
        </div>
    </>;
}