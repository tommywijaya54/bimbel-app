import { CurrentUser } from "@/util";

export default ({action}) => {
    const actions = action.split(",");
    const user = new CurrentUser();

    return (<span className="header-action">
        {
            user.hasPermission('create-user') && actions.includes('create-user') && 
            <a href="/user/create" className="button btn-sm btn-light">Create New User</a>
        }

        {
            user.hasPermission('create-branch') && actions.includes('create-branch') && 
            <a href="/branch/create" className="button btn-sm btn-light">Create New Branch</a>
        }

        {
            user.hasPermission('create-employee') && actions.includes('create-employee') && 
            <a href="/employee/create" className="button btn-sm btn-light">Create Employee</a>
        }
    </span>);
}