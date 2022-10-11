import { Link, usePage } from "@inertiajs/inertia-react";

export default () => {
    const permissions = usePage().props.auth.permissions;
    const includeFromTopNavList = ['user', 'branch', 'role', 'employee']; // for admin
    const NavList = ({list}) => {
        return list.filter((alist) => {
            return alist.includes('list-') && (includeFromTopNavList.includes(alist.split('-')[1]));
        }).map(((listonly,i) => {
            const model = listonly.split("list-")[1];
            const href = "/"+model.replaceAll(" ",'-');
            return <Link
                        key={i}
                        href={href}
                        className = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-700 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                        >
                        {model.cap()}
                    </Link>
        }))
    }
    return (
    <nav className="bg-slate-100 border-b border-gray-100">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex h-10">   
                <div className="shrink-0 flex items-center">
                
                </div>     
                <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <NavList list={permissions}></NavList>
                </div>
            </div>
        </div>
    </nav>)
}