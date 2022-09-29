import { CurrentUser, getAlias } from "@/util";

const FormFooter = ({form, obj}) => {
    const user = new CurrentUser();
    const model = window.location.pathname.split('/')[1];

    let component = [];

    if(form.create_form){
        return '';
        
        user.hasPermission('create-'+model) ? 
            component.push(<a href={'/'+model+'/'+obj.id+'/edit'} className={'button '}>Save / Create {model.cap()}</a>) : ''
    }

    if(form.display_form){
        user.hasPermission('edit-'+model) ? 
            component.push(<a href={'/'+model+'/'+obj.id+'/edit'} className={'button '}>Edit {model.cap()}</a>) : ''
    }
    
    if(model === 'user'){
        const url = {
            deactivate:'/user/'+obj.id+'/deactivate',
            activate:'/user/'+obj.id+'/activate',
            edit:'/user/'+obj.id+'/edit',
            resetPassword:'/user/'+obj.id+'/resetpassword',
        }
        user.hasPermission('deactivate-user') ? 
            component.push(<a href={url.deactivate} className={'button ' + (obj.disabled ? 'disabled' : '')}>Deactivate user</a>) : ''

        user.hasPermission('activate-user') ? 
            component.push(<a href={url.activate} className={'button ' + (obj.disabled ? '' : 'disabled')}>Activate user</a>) : ''
        
        user.hasPermission('reset password-user') ? 
            component.push(<a href={url.resetPassword} className={'button '}>Reset Password</a>) : ''

        user.hasPermission('edit-user') ? 
            component.push(<a href={url.edit} className={'button '}>Edit user</a>) : ''
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