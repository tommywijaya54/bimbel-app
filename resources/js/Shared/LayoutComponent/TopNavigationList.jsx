import React from 'react';
import { Link, usePage } from '@inertiajs/inertia-react';

export default function TopNavigationList() {
    const permissions = usePage().props.auth.permissions;
    
    const NavList = ({list}) => {
        return list.filter(alist => alist.includes('list-')).map(((listonly,i) => {
            const model = listonly.split("list-")[1];
            const href = "/"+model.replaceAll(" ",'-');
            return <Link
                        key={i}
                        href={href}
                        className = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                        >
                        {model.cap()}
                    </Link>
        }))


        /*
        return list.map((l,i) => {
            if(l.includes("list")){
                const href = l.split("list-")[1];
                const newhref = "/"+href.replaceAll(" ",'-');
                return <Link
                        key={i}
                        href={newhref}
                        className = 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                        >
                        {href.cap()}
                    </Link>
            }
            return null;
        })
        */
    }

    return <>
        <NavList list={permissions}></NavList>
    </>;
}
