import { CurrentUser } from "@/Shared/Util/CurrentUser_util";

const FormFooter = ({form, obj, link, children}) => {
    const user = new CurrentUser();
    const model = window.location.pathname.split('/')[1];

    let component = [];
    
    if(link){
        const linkvar = link.permission.split('-');
        user.hasPermission(link.permission) ? 
            component.push(<a href={'/'+linkvar[1]+'/'+link.id+'/edit'} className={'button '}>{linkvar[0].cap()} {linkvar[1].cap()}</a>) : ''
    }

    if(form && obj){
        if(form.create_form || form.edit_form){
            return '';
        }

        if(form.display_form){
            user.hasPermission('edit-'+model) ? 
                component.push(<a href={'/'+model+'/'+obj.id+'/edit'} className={'button '}>Edit {model.cap()}</a>) : ''
        }
    }

    if(form.urls){
        return <>
            <div className="form-footer">
                <div className="px-6 py-4 bg-gray-50 flex justify-end">
                    {form.urls.map((url, keyId) => <a href={url.link} className='button' key={keyId}>{url.label}</a>)}
                </div>
            </div>
        </>
    }

    return (<div className="form-footer">
                <div className="px-6 py-4 bg-gray-50 flex justify-end">
                    {component.map((comp,keyId)=>{
                        return <div key={keyId}>{comp}</div>
                    })}
                </div>
            </div>);
}
export default FormFooter;