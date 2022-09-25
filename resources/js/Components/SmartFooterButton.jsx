const SmartFooterButton = ({componentFor, obj}) => {
    /* 
        const app = document.getElementById('app');
        const data = JSON.parse(app.dataset.page).props;
        const permissions = data.auth.permissions;
    */

    const component = [];

    if(componentFor === 'user'){
        // edit-user deactivate-user activate-user
        const url = {
            deactivate:'/user/'+obj.id+'/deactivate',
            activate:'/user/'+obj.id+'/activate',
            edit:'/user/'+obj.id+'/edit',
            reset_password:'/user/'+obj.id+'/resetpassword',
        }
        current_user.hasPermission('deactivate-user') ? 
            component.push(<a href={url.deactivate} className={'button ' + (obj.disabled ? 'disabled' : '')}>Deactivate user</a>) : ''

        current_user.hasPermission('activate-user') ? 
            component.push(<a href={url.activate} className={'button ' + (obj.disabled ? '' : 'disabled')}>Activate user</a>) : ''
        
        current_user.hasPermission('reset password-user') ? 
            component.push(<a href={url.reset_password} className={'button '}>Reset Password</a>) : ''

        current_user.hasPermission('edit-user') ? 
            component.push(<a href={url.edit} className={'button '}>Edit user</a>) : ''

        
        /*
        current_user.hasPermission('deactivate-user') ? 
            component.push(<button type="button" className="text-red-600 hover:underline">Deactivate User</button>) : ''
        
        current_user.hasPermission('edit-user') ? 
            component.push(<button type="button" className="flex items-center btn-indigo ml-auto" >Edit User</button>) : ''
        
        current_user.hasPermission('activate-user') ? 
            component.push(<button type="button" className="flex items-center btn-indigo ml-auto" >Activate User</button>) : '' 
        */  
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