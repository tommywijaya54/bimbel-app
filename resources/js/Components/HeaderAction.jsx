export default ({action}) => {
    const actions = action.split(",");

    return (<span className="header-action">
        {
            current_user.hasPermission('create-user') && actions.includes('create-user') && 
            <a href="/user/create" className="button btn-sm btn-light">Create New User</a>
        }

        {
            current_user.hasPermission('create-branch') && actions.includes('create-branch') && 
            <a href="/branch/create" className="button btn-sm btn-light">Create New Branch</a>
        }


    </span>);
}