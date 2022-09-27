const SmartFooterButton = ({componentFor, obj}) => {
    /* 
        const app = document.getElementById('app');
        const data = JSON.parse(app.dataset.page).props;
        const permissions = data.auth.permissions;
    */

    let component = [];

    if(componentFor === 'user'){
        const url = {
            deactivate:'/user/'+obj.id+'/deactivate',
            activate:'/user/'+obj.id+'/activate',
            edit:'/user/'+obj.id+'/edit',
            resetPassword:'/user/'+obj.id+'/resetpassword',
        }
        current_user.hasPermission('deactivate-user') ? 
            component.push(<a href={url.deactivate} className={'button ' + (obj.disabled ? 'disabled' : '')}>Deactivate user</a>) : ''

        current_user.hasPermission('activate-user') ? 
            component.push(<a href={url.activate} className={'button ' + (obj.disabled ? '' : 'disabled')}>Activate user</a>) : ''
        
        current_user.hasPermission('reset password-user') ? 
            component.push(<a href={url.resetPassword} className={'button '}>Reset Password</a>) : ''

        current_user.hasPermission('edit-user') ? 
            component.push(<a href={url.edit} className={'button '}>Edit user</a>) : ''
    }

    if(componentFor === 'branch'){
        current_user.hasPermission('edit-branch') ? 
            component.push(<a href={'/branch/'+obj.id+'/edit'} className={'button '}>Edit Branch</a>) : ''
    }

    if(componentFor === 'employee'){
        current_user.hasPermission('edit-employee') ? 
            component.push(<a href={'/employee/'+obj.id+'/edit'} className={'button '}>Edit Employee</a>) : ''
    }

    

    return (<div className="smart-footer">
                <div className="px-6 py-4 bg-gray-50 flex justify-end">
                    {component.map((comp,keyId)=>{
                        return <div key={keyId}>{comp}</div>
                    })}
                </div>
            </div>);
}
export default SmartFooterButton;