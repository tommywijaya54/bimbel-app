export default ({route_name = '', children, can}) => {
    const label = children || route_name.cap();
    const url = route(route_name);
    const navClassName = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
    const active = route().current(route_name)? ' active-nav' : '';
    
    return <a
        href={url}
        className={navClassName+active}
        >
        {label}
    </a>
}