import { CurrentUser } from "@/util";

export default ({action}) => {
    const user = new CurrentUser();
    const model = window.location.pathname.split('/')[1];

    return (<span className="header-action">
        {
            user.hasPermission('create-'+model) && 
            <a href={"/"+model+"/create"} className="button btn-sm btn-light">Create New {model.cap()}</a>
        }
    </span>);
}

/*
        {
            user.hasPermission('create-user') && actions.includes('create-user') && 
            
        }

        {
            user.hasPermission('create-branch') && actions.includes('create-branch') && 
            <a href="/branch/create" className="button btn-sm btn-light">Create New Branch</a>
        }

        {
            user.hasPermission('create-employee') && actions.includes('create-employee') && 
            <a href="/employee/create" className="button btn-sm btn-light">Create Employee</a>
        }
*/