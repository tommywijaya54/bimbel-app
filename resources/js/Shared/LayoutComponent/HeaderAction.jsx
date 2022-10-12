import { CurrentUser } from "../Util/CurrentUser.util";

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