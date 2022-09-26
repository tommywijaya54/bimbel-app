export default ({action}) => {
    const actions = action.split(",");

    return (<span className="header-action">
        {
            current_user.hasPermission('create-branch') && actions.includes('create-branch') && 
            <a href="/branch/create" className="button btn-sm btn-light">Create New Branch</a>
        }
    </span>);
}